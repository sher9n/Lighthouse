import db from "../../../utils/db";
import { Program, IdlAccounts, web3 } from "@project-serum/anchor";
import * as anchor from "@project-serum/anchor";

import { Connection, PublicKey, Keypair } from "@solana/web3.js";
import type { NextApiRequest, NextApiResponse } from "next";

import { getConnection, getProgram } from "../../../utils/programUtils";
import NextCors from "nextjs-cors";
import { IWalletInfo } from "../../../lib/types";

type Result = {
  txHash: string;
};
type Error = {
  error: string;
};

type WhitelistState = {
  isWhitelisted: boolean;
  bump: number;
};

/**
 * @swagger
 * /api/{community}/addToWhitelist:
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
 *     summary: Add a new account to the token whitelist
 *     description: Add a new account to the token whitelist
 *     requestBody:
 *        required: true
 *        content:
 *          application/json:
 *            schema:
 *              type: object
 *              properties:
 *                whitelistedAccount:
 *                  type: string
 *                  description: Pubkey of the receiver
 *     responses:
 *       200:
 *        description: Added to the whitelist
 *        content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               account:
 *                 type: string
 *                 description: Community account address.
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
    let { whitelistedAccount } = req.body;

    const connection: Connection = getConnection();
    const program: Program = getProgram();

    // console.log(whitelistedAccount);

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

    whitelistedAccount = new PublicKey(whitelistedAccount);

    const [whitelistPDA, _] = await PublicKey.findProgramAddress(
      [
        Buffer.from(anchor.utils.bytes.utf8.encode("whitelist")),
        Buffer.from(anchor.utils.bytes.utf8.encode(community as string)),
        whitelistedAccount.toBuffer(),
      ],

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

    const txHash = await program.methods
      .addToWhitelist()
      .accounts({
        admin: gasTank.publicKey,
        whitelistState: whitelistPDA,
        adminState,
        community: new PublicKey(walletInfo.pda),
        whitelistedAccount,
      })
      .signers([gasTank])
      .rpc();

    const whitelistState = (await program.account.whitelistState.fetch(
      whitelistPDA
    )) as WhitelistState;

    // console.log(whitelistState);

    res.status(200).json({ txHash });
  } catch (error) {
    // console.log(error);
    res.status(400).json({ error: error as string });
  }
}
