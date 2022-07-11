import db from "../../../utils/db";
import { Program, IdlAccounts, web3 } from "@project-serum/anchor";
import * as anchor from "@project-serum/anchor";

import { Connection, PublicKey, Keypair } from "@solana/web3.js";
import type { NextApiRequest, NextApiResponse } from "next";

import {
  getConnection,
  getPayerKeypair,
  getProgram,
} from "../../../utils/programUtils";
import NextCors from "nextjs-cors";
import { IWalletInfo } from "../../../lib/types";

type Result = {
  txHash: string;
};
type Error = {
  error: string;
};

/**
 * @swagger
 * /api/{community}/addAdmin:
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
 *     summary: Add a new admin
 *     description: Add a new admin
 *     requestBody:
 *        required: true
 *        content:
 *          application/json:
 *            schema:
 *              type: object
 *              properties:
 *                newAdmin:
 *                  type: string
 *                  description: Pubkey of the new admin
 *     responses:
 *       200:
 *        description: New admin added
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
    let { newAdmin } = req.body;
    if (process.env.API_KEY != key) {
      return res
        .status(401)
        .send({ error: "You are not authorised to call this API" });
    }

    const program: Program = getProgram();
    const payer: Keypair = getPayerKeypair();

    const wallet = await db
      .collection(program.programId.toBase58())
      .doc(community as string)
      .get();

    if (!wallet.exists) {
      return res.status(404).json({ error: "Community not found" });
    }

    const walletInfo = wallet.data() as IWalletInfo;
    newAdmin = new PublicKey(newAdmin);

    const [adminState, _bump2] = await PublicKey.findProgramAddress(
      [
        anchor.utils.bytes.utf8.encode("admin"),
        anchor.utils.bytes.utf8.encode(community as string),
        newAdmin.toBuffer(),
      ],
      program.programId
    );

    const txHash = await program.methods
      .addAdmin(newAdmin)
      .accounts({
        adminAuthority: payer.publicKey,
        adminState,
        community: new PublicKey(walletInfo.pda),
      })
      .signers([payer])
      .rpc();

    const adminStatus = await program.account.admin.fetch(adminState);
    // console.log(adminStatus);

    res.status(200).json({ txHash });
  } catch (error) {
    // console.log(error);
    res.status(400).json({ error: error as string });
  }
}
