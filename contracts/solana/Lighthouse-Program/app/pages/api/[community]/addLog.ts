import db from "../../../utils/db";
import { Program } from "@project-serum/anchor";
import * as anchor from "@project-serum/anchor";

import { PublicKey, Keypair } from "@solana/web3.js";
import type { NextApiRequest, NextApiResponse } from "next";

import { getProgram } from "../../../utils/programUtils";
import NextCors from "nextjs-cors";
import { IWalletInfo } from "../../../lib/types";
import { MerkleTree } from "merkletreejs";
import SHA256 from "crypto-js/sha256";

type Result = {
  txHash: string;
};
type Error = {
  error: string;
};

type AddLogBody = {
  communityName: string;
  receiver: string;
  amount: number;
  reason: string;
  tags: string;
  pointsBreakdown: string;
};

/**
 * @swagger
 * /api/{community}/addLog:
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
 *     summary: Log an attestation
 *     description: Log an attestation
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
 *                  description: Amount to attest
 *                reason:
 *                  type: string
 *                  description: Reason
 *                tags:
 *                  type: string
 *                  description: Tags
 *                pointsBreakdown:
 *                  type: string
 *                  description: Points breakdown
 *
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

    const logInfo = req.body as AddLogBody;
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
    const [adminState] = await PublicKey.findProgramAddress(
      [
        anchor.utils.bytes.utf8.encode("admin"),
        anchor.utils.bytes.utf8.encode(community as string),
        gasTank.publicKey.toBuffer(),
      ],
      program.programId
    );

    const leaves = Object.values(logInfo).map((x) => SHA256(x.toString()));
    const tree = new MerkleTree(leaves, SHA256);
    const root = tree.getRoot().toString("hex");

    const txHash = await program.methods
      .logAttestation(root)
      .accounts({
        community: walletInfo.pda,
        admin: gasTank.publicKey,
        adminState,
      })
      .signers([gasTank])
      .rpc();

    // console.log("tx:", txHash);

    res.status(200).json({ txHash });
  } catch (error) {
    // // console.log(error);
    res.status(400).json({ error: error as string });
  }
}
