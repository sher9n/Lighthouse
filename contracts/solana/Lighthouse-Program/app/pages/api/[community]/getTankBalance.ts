import { getConnection } from "./../../../utils/programUtils";
import db from "../../../utils/db";
import { Program } from "@project-serum/anchor";
import { Connection, LAMPORTS_PER_SOL, PublicKey } from "@solana/web3.js";
import type { NextApiRequest, NextApiResponse } from "next";

import { getProgram } from "../../../utils/programUtils";
import NextCors from "nextjs-cors";
import { IWalletInfo } from "../../../lib/types";

type Error = {
  error: string;
};

type Balance = {
  balance: number;
};

/**
 * @swagger
 * /api/{community}/getTankBalance:
 *   get:
 *     parameters:
 *      - in: path
 *        name: community
 *        schema:
 *          type: string
 *        description: Name of the community
 *     summary: Get gas tank balance
 *     description: Get gas tank balance
 *     responses:
 *       200:
 *        description: Successfully returned balance
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
  res: NextApiResponse<Balance | Error>
) {
  await NextCors(req, res, {
    // Options
    methods: ["POST"],
    origin: "*",
    optionsSuccessStatus: 200, // some legacy browsers (IE11, various SmartTVs) choke on 204
  });
  try {
    const { community } = req.query;
    const connection = getConnection();
    const program: Program = getProgram();

    const wallet = await db
      .collection(program.programId.toBase58())
      .doc(community as string)
      .get();

    if (!wallet.exists) {
      return res.status(404).json({ error: "Community not found" });
    }

    const walletInfo = wallet.data() as IWalletInfo;

    const balance = await connection.getBalance(
      new PublicKey(walletInfo.gasTankPublicKey)
    );

    res.status(200).json({ balance: balance / LAMPORTS_PER_SOL });
  } catch (error) {
    // console.log(error);
    res.status(400).json({ error: error as string });
  }
}
