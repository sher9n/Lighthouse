import db from "../../../utils/db";
import { EventParser, Program, Event } from "@project-serum/anchor";
import * as anchor from "@project-serum/anchor";

import { Connection, PublicKey, Keypair } from "@solana/web3.js";
import type { NextApiRequest, NextApiResponse } from "next";

import { getConnection, getProgram } from "../../../utils/programUtils";
import NextCors from "nextjs-cors";
import { IWalletInfo } from "../../../lib/types";

type Result = {
  events: Event[];
};
type Error = {
  error: string;
};

type GetLogsBody = {
  limit: number;
};

/**
 * @swagger
 * /api/{community}/getLogs:
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
 *                limit:
 *                  type: number
 *                  description: Number of logs to return

 *
 *     responses:
 *       200:
 *        description: Successfully added points
 *        content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               events:
 *                 type: object
 *                 description: Event logs
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
    const { limit } = req.body as GetLogsBody;
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

    const latestSigs = await connection.getSignaturesForAddress(
      new PublicKey(walletInfo.pda),
      {
        limit,
      }
    );

    const latestTxns = await connection.getParsedTransactions(
      latestSigs.map((sig) => sig.signature)
    );

    const events = latestTxns
      .map((txn) => parseTxnLogs(txn))
      .reduce((acc, cur) => acc.concat(cur), []);

    // console.log(events);

    // Snippet to parse logs

    // const sigs = await connection.getSignaturesForAddress(communityPDA);
    // // console.log("sigs", sigs);
    // const info = await connection.getParsedTransaction(txHash);
    // const parser = new EventParser(program.programId, program.coder);
    // const events: Event[] = [];

    // if (info?.meta?.logMessages) {
    //   // console.log("here");
    //   parser.parseLogs(info?.meta?.logMessages as string[], (log) =>
    //     events.push(log)
    //   );
    // }
    // // console.log(events);

    res.status(200).json({ events });
  } catch (error) {
    // console.log(error);
    res.status(400).json({ error: error as string });
  }
}

const parseTxnLogs = (
  txn: anchor.web3.ParsedTransactionWithMeta | null
): Event[] => {
  const program = getProgram();
  const parser = new EventParser(program.programId, program.coder);
  const events: Event[] = [];

  if (txn?.meta?.logMessages) {
    parser.parseLogs(txn?.meta?.logMessages as string[], (log) =>
      events.push(log)
    );
  }

  return events;
};
