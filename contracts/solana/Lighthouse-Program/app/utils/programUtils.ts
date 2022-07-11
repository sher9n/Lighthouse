import {
  clusterApiUrl,
  Commitment,
  Connection,
  Keypair,
} from "@solana/web3.js";
import {
  AnchorProvider,
  Program,
  Address,
  Idl,
  Wallet,
  web3,
  getProvider,
  Provider,
} from "@project-serum/anchor";
import * as anchor from "@project-serum/anchor";
import idl from "../idl.json";

export const getConnection = (): Connection => {
  const connection = new Connection(clusterApiUrl("devnet"), "confirmed");
  return connection as Connection;
};

export const getProgram = (): Program => {
  const programID: Address = idl.metadata.address;

  const LHT: Keypair = web3.Keypair.fromSecretKey(
    anchor.utils.bytes.bs58.decode(process.env.LHT_SECRET_KEY as string)
  );

  const LHT_wallet = new Wallet(LHT);

  const opts = {
    preflightCommitment: "processed" as Commitment,
  };

  const provider: Provider = new AnchorProvider(
    getConnection(),
    LHT_wallet,
    opts
  );

  const program = new Program(idl as Idl, programID, provider);
  return program;
};

export const getPayerKeypair = (): Keypair => {
  const LHT: Keypair = web3.Keypair.fromSecretKey(
    anchor.utils.bytes.bs58.decode(process.env.LHT_SECRET_KEY as string)
  );
  return LHT;
};
