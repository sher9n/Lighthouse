import db from "../../utils/db";
import { Program, web3 } from "@project-serum/anchor";
import * as anchor from "@project-serum/anchor";
import { actions, NodeWallet } from "@metaplex/js";
const { createMetadata } = actions;
import { MetadataDataData } from "@metaplex-foundation/mpl-token-metadata";
import {
  Connection,
  PublicKey,
  Keypair,
  LAMPORTS_PER_SOL,
} from "@solana/web3.js";
import type { NextApiRequest, NextApiResponse } from "next";
// Latest version of spl-token
// import { createMint } from "@solana/spl-token";

// Old version to support metaplex
import { Token, TOKEN_PROGRAM_ID } from "@solana/spl-token";

import {
  getConnection,
  getPayerKeypair,
  getProgram,
} from "./../../utils/programUtils";
import NextCors from "nextjs-cors";
import { IWalletInfo } from "../../lib/types";

type Data = {
  state: CommunityState;
  tx_hash: string;
};

type CommunityState = {
  name: string;
  tokenName: string;
  adminAuthority: web3.PublicKey;
  tokenMint: web3.PublicKey;
  bump: number;
};
type Error = {
  error: string;
};

type CreateBody = {
  name: string;
  tokenName: string;
  tokenSymbol: string;
  tokenDecimals?: number;
  initialAdmin: PublicKey;
};

type Oldtype = {
  communityAddress: string;
  tokenAddress: string;
  gasTankInfo: {
    address: string;
    privateKey: string;
    created: string;
  };
  txHash: string;
};

/**
 * @swagger
 * /api/create:
 *  post:
 *   parameters:
 *    - in: path
 *      name: community
 *      schema:
 *        type: string
 *      description: Name of the community
 *    - in: query
 *      name: key
 *      schema:
 *        type: string
 *        description: API key
 *   summary: Create a new community
 *   description: Create a new community and return the community account.
 *   requestBody:
 *      required: true
 *      content:
 *        application/json:
 *          schema:
 *            type: object
 *            properties:
 *              name:
 *                type: string
 *                description: Name of the community
 *                required: true
 *              tokenName:
 *                type: string
 *                description: Name of the new token
 *                required: true
 *              tokenSymbol:
 *                type: string
 *                description: Symbol of the new token
 *                required: true
 *              tokenDecimals:
 *                type: number
 *                description: Decimals of the new token
 *                required: false
 *              initialAdmin:
 *                type: string
 *                description: Publickey of initial admin
 *                required: true
 *   responses:
 *     200:
 *      description: Created a new community
 *      content:
 *       application/json:
 *         schema:
 *           type: object
 *           properties:
 *             account:
 *               type: string
 *               description: Community account address.
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
 *     406:
 *        description: Incorrect amount
 *        content:
 *          application/json:
 *            schema:
 *              type: object
 *              properties:
 *                error:
 *                  type: string
 *                  description: "error message"
 *
 *
 *
 */

export default async function handler(
  req: NextApiRequest,
  res: NextApiResponse<Oldtype | Error>
) {
  await NextCors(req, res, {
    // Options
    methods: ["POST"],
    origin: "*",
    optionsSuccessStatus: 200, // some legacy browsers (IE11, various SmartTVs) choke on 204
  });

  try {
    let { name, tokenName, tokenSymbol, tokenDecimals, initialAdmin } =
      req.body as CreateBody;

    const payer = getPayerKeypair();
    const gasTank = anchor.web3.Keypair.generate();
    const connection: Connection = getConnection();
    const program: Program = getProgram();
    initialAdmin = new PublicKey(initialAdmin);

    const mint: Token = await Token.createMint(
      connection,
      payer,
      payer.publicKey,
      payer.publicKey,
      tokenDecimals as number,
      TOKEN_PROGRAM_ID
    );

    const metadataData = new MetadataDataData({
      name: tokenName,
      symbol: tokenSymbol,
      // values below are only used for NFT metadata
      uri: "",
      sellerFeeBasisPoints: 0,
      creators: null,
    });

    await createMetadata({
      connection,
      wallet: new NodeWallet(payer),
      editionMint: mint.publicKey,
      metadataData,
      updateAuthority: payer.publicKey,
    });

    const [communityPDA, _bump] = await PublicKey.findProgramAddress(
      [
        anchor.utils.bytes.utf8.encode("community"),
        anchor.utils.bytes.utf8.encode(name),
      ],
      program.programId
    );
    const tx: string = await program.methods
      .createCommunity(name, tokenName)
      .accounts({
        community: communityPDA,
        tokenMint: mint.publicKey,
        payer: payer.publicKey,
      })
      .signers([payer])
      .rpc();

    const [adminState] = await PublicKey.findProgramAddress(
      [
        anchor.utils.bytes.utf8.encode("admin"),
        anchor.utils.bytes.utf8.encode(name),
        gasTank.publicKey.toBuffer(),
      ],
      program.programId
    );
    await program.methods
      .addAdmin(gasTank.publicKey)
      .accounts({
        community: communityPDA,
        adminState: adminState,
        adminAuthority: payer.publicKey,
      })
      .signers([payer])
      .rpc();

    const [initialAdminState] = await PublicKey.findProgramAddress(
      [
        anchor.utils.bytes.utf8.encode("admin"),
        anchor.utils.bytes.utf8.encode(name),
        initialAdmin.toBuffer(),
      ],
      program.programId
    );
    await program.methods
      .addAdmin(initialAdmin)
      .accounts({
        community: communityPDA,
        adminState: initialAdminState,
        adminAuthority: payer.publicKey,
      })
      .signers([payer])
      .rpc();

    const communityState = (await program.account.community.fetch(
      communityPDA
    )) as CommunityState;

    const walletInfo: IWalletInfo = {
      pda: communityPDA.toBase58(),
      tokenName: communityState.tokenName,
      tokenMint: communityState.tokenMint.toBase58(),
      tokenDecimals: tokenDecimals as number,
      gasTankPublicKey: gasTank.publicKey.toBase58(),
      gasTankSecretKey: anchor.utils.bytes.bs58.encode(gasTank.secretKey),
      created: new Date().toISOString(),
    };

    const result: FirebaseFirestore.WriteResult = await db
      .collection(program.programId.toBase58())
      .doc(name)
      .set(walletInfo);

    const transaction = new web3.Transaction().add(
      web3.SystemProgram.transfer({
        fromPubkey: payer.publicKey,
        toPubkey: gasTank.publicKey,
        lamports: 0.1 * LAMPORTS_PER_SOL, // number of SOL to send
      })
    );

    await web3.sendAndConfirmTransaction(connection, transaction, [payer]);

    const oldFormat = {
      communityAddress: communityPDA.toBase58(),
      tokenAddress: mint.publicKey.toBase58(),
      gasTankInfo: {
        address: gasTank.publicKey.toBase58(),
        privateKey: anchor.utils.bytes.bs58.encode(gasTank.secretKey),
        created: walletInfo.created,
      },
    };

    res.status(200).json({ ...oldFormat, txHash: tx });
  } catch (error) {
    console.log(error);
    res.status(400).json({ error: error as string });
  }
}
