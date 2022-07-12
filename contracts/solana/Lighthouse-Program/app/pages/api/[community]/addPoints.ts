import db from "../../../utils/db";
import { IWalletInfo } from "../../../lib/types";
import { Program, IdlAccounts, web3 } from "@project-serum/anchor";
import * as anchor from "@project-serum/anchor";
import {
  Token,
  ASSOCIATED_TOKEN_PROGRAM_ID,
  TOKEN_PROGRAM_ID,
} from "@solana/spl-token";
const { getAssociatedTokenAddress } = Token;
import {
  Connection,
  PublicKey,
  Keypair,
  LAMPORTS_PER_SOL,
} from "@solana/web3.js";
import type { NextApiRequest, NextApiResponse } from "next";

import { getConnection, getProgram } from "../../../utils/programUtils";
import NextCors from "nextjs-cors";

type Result = {
  txHash: string;
};
type Error = {
  error: string;
};

type AddPointsBody = {
  communityName: string;
  receiver: PublicKey;
  amount: anchor.BN;
};

/**
 * @swagger
 * /api/{community}/addPoints:
 *   post:
 *     parameters:
 *      - in: path
 *        name: community
 *        schema:
 *          type: string
 *        description: Name of the community
 *      - in: query
 *        name: key
 *        schema:
 *          type: string
 *          description: API key
 *     summary: Add points to receiver
 *     description: Add points for good actions
 *     requestBody:
 *        required: true
 *        content:
 *          application/json:
 *            schema:
 *              type: object
 *              properties:
 *                receiver:
 *                  type: string
 *                  description: Pubkey of the receiver
 *                amount:
 *                  type: string
 *                  description: Pubkey of the receiver
 *     responses:
 *       200:
 *        description: Successfully added points
 *        content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               result:
 *                 type: string
 *                 description: Result
 *     401:
 *       description: Authorization error
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               error:
 *                 type: string
 *                 description: "error message"
 *     404:
 *       description: Gas tank info not found
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               error:
 *                 type: string
 *                 description: "error message"
 *
 *
 *
 *
 */

export default async function handler(
  req: NextApiRequest,
  res: NextApiResponse<Result | Error>
) {
  await NextCors(req, res, {
    // Options
    methods: ["POST"],
    origin: "*",
    optionsSuccessStatus: 200, // some legacy browsers (IE11, various SmartTVs) choke on 204
  });
  try {
    const { community, key } = req.query;
    if (process.env.API_KEY != key) {
      return res
        .status(401)
        .send({ error: "You are not authorised to call this API" });
    }
    let { receiver, amount } = req.body as AddPointsBody;
    const connection: Connection = getConnection();
    const program: Program = getProgram();

    const wallet = await db
      .collection(program.programId.toBase58())
      .doc(community as string)
      .get();

    if (!wallet.exists) {
      return res.status(404).json({ error: "Community not found" });
    }

    const walletInfo = wallet.data() as IWalletInfo;
    const gasTank: Keypair = Keypair.fromSecretKey(
      anchor.utils.bytes.bs58.decode(walletInfo.gasTankSecretKey)
    );

    // console.log(walletInfo);

    receiver = new PublicKey(receiver);

    let tokenAccount: PublicKey;

    // // console.log("in try");
    // // console.log(tokenAccount);
    // // console.log("Inside");

    const tokenMint = new Token(
      connection,
      new PublicKey(walletInfo.tokenMint),
      TOKEN_PROGRAM_ID,
      gasTank
    );

    try {
      tokenAccount = await tokenMint.createAssociatedTokenAccount(receiver);
    } catch (_) {
      tokenAccount = await getAssociatedTokenAddress(
        ASSOCIATED_TOKEN_PROGRAM_ID,
        TOKEN_PROGRAM_ID,
        new PublicKey(walletInfo.tokenMint),
        receiver
      );
    }

    const [pda, _nonce] = await PublicKey.findProgramAddress(
      [Buffer.from(anchor.utils.bytes.utf8.encode("Light"))],
      program.programId
    );
    const [adminState, _bump2] = await PublicKey.findProgramAddress(
      [
        anchor.utils.bytes.utf8.encode("admin"),
        anchor.utils.bytes.utf8.encode(community as string),
        gasTank.publicKey.toBuffer(),
      ],
      program.programId
    );

    const lamportAmt = Number(amount) * 10 ** walletInfo.tokenDecimals;

    const txHash = await program.methods
      .addPoints(new anchor.BN(lamportAmt))
      .accounts({
        community: walletInfo.pda,
        adminState: adminState,
        admin: gasTank.publicKey,
        tokenAccount: tokenAccount,
        tokenMint: walletInfo.tokenMint,
        pdaAccount: pda,
      })
      .signers([gasTank])
      .rpc();

    res.status(200).json({ txHash });
  } catch (error) {
    // console.log(error);
    res.status(400).json({ error: error as string });
  }
}
