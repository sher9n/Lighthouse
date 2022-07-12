import { PublicKey, LAMPORTS_PER_SOL, Keypair } from "@solana/web3.js";
import { expect, assert } from "chai";
import {
  Account,
  createMint,
  getAccount,
  getMint,
  getOrCreateAssociatedTokenAccount,
} from "@solana/spl-token";

import * as anchor from "@project-serum/anchor";
import { Program, IdlAccounts } from "@project-serum/anchor";

import { LighthouseProgram } from "../target/types/lighthouse_program";

describe("Lighthouse Program", () => {
  // Configure the client to use the local cluster.
  anchor.setProvider(anchor.AnchorProvider.env());
  const provider = anchor.AnchorProvider.env();
  type CommunityState = IdlAccounts<LighthouseProgram>["community"];
  type WhitelistState = IdlAccounts<LighthouseProgram>["whitelistState"];

  const program = anchor.workspace
    .LighthouseProgram as Program<LighthouseProgram>;

  const mywallet = (program.provider as anchor.AnchorProvider).wallet.publicKey;
  const fakeAdmin = anchor.web3.Keypair.generate();

  const details = {};

  const setupCommunity = async (name: string) => {
    try {
      const payer = anchor.web3.Keypair.generate();
      const admin = anchor.web3.Keypair.generate();

      const signature = await provider.connection.requestAirdrop(
        payer.publicKey,
        LAMPORTS_PER_SOL * 1000
      );
      await provider.connection.confirmTransaction(signature, "confirmed");
      const signature2 = await provider.connection.requestAirdrop(
        admin.publicKey,
        LAMPORTS_PER_SOL * 1000
      );
      await provider.connection.confirmTransaction(signature2, "confirmed");

      const mint = await createMint(
        provider.connection,
        payer,
        payer.publicKey,
        payer.publicKey,
        9
      );

      const [communityPDA, _] = await PublicKey.findProgramAddress(
        [
          anchor.utils.bytes.utf8.encode("community"),
          anchor.utils.bytes.utf8.encode(name),
        ],
        program.programId
      );
      const [adminState, ___] = await PublicKey.findProgramAddress(
        [
          anchor.utils.bytes.utf8.encode("admin"),
          anchor.utils.bytes.utf8.encode(name),
          admin.publicKey.toBuffer(),
        ],
        program.programId
      );

      const tx = await program.methods
        .createCommunity(name, "UNI")
        .accounts({
          community: communityPDA,
          tokenMint: mint,
          payer: payer.publicKey,
        })
        .signers([payer])
        .rpc();

      details[name] = { payer, mint, communityPDA, admin, adminState };
      return { payer, mint, communityPDA, admin };
    } catch (e) {
      console.log(e);
    }
  };

  it("creates new community 🎉", async () => {
    // Add your test here.

    const { payer, mint, communityPDA, admin } = (await setupCommunity(
      "1"
    )) as {
      payer: Keypair;
      mint: PublicKey;
      communityPDA: PublicKey;
      admin: Keypair;
    };

    const communityState: CommunityState =
      await program.account.community.fetch(communityPDA);

    const mintInfo = await getMint(
      provider.connection,
      communityState.tokenMint
    );

    expect(communityState.tokenMint).to.eql(mint);
    expect(communityState.name).to.equal("1");
    expect(communityState.tokenName).to.equal("UNI");

    expect(communityState.adminAuthority).to.eql(payer.publicKey);

    const [pda, _nonce] = await PublicKey.findProgramAddress(
      [Buffer.from(anchor.utils.bytes.utf8.encode("Light"))],
      program.programId
    );

    details["pda"] = pda;
    expect(mintInfo.freezeAuthority).to.eql(pda);
    expect(mintInfo.mintAuthority).to.eql(pda);
  });

  it("adds admin", async () => {
    const { communityPDA, admin, adminState, payer } = details["1"];

    await program.methods
      .addAdmin(admin.publicKey)
      .accounts({
        community: communityPDA,
        adminState: adminState,
        adminAuthority: payer.publicKey,
      })
      .signers([payer])
      .rpc();
  });

  it("does not allow unauthorized to add admin", async () => {
    const { communityPDA, admin, adminState, payer } = details["1"];
    const [notAdminState, ___] = await PublicKey.findProgramAddress(
      [
        anchor.utils.bytes.utf8.encode("admin"),
        anchor.utils.bytes.utf8.encode("1"),
        payer.publicKey.toBuffer(),
      ],
      program.programId
    );

    details["1"].notAdminState = notAdminState;

    try {
      await program.methods
        .addAdmin(payer.publicKey)
        .accounts({
          community: communityPDA,
          adminState: notAdminState,
          adminAuthority: admin.publicKey,
        })
        .signers([admin])
        .rpc();
      assert.fail("should not have been able to add admin");
    } catch (e) {
      expect(e.error.errorMessage).to.equal(
        "Only the admin authoriy is allowed add admins"
      );
    }
  });

  it("only adds points to delegated 💯", async () => {
    const { communityPDA, mint, admin, adminState } = details["1"];
    const nonDelegated = anchor.web3.Keypair.generate();
    const tokenAccount = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      admin,
      mint,
      nonDelegated.publicKey
    );
    const [pda, _nonce] = await PublicKey.findProgramAddress(
      [Buffer.from(anchor.utils.bytes.utf8.encode("Light"))],
      program.programId
    );

    try {
      await program.methods
        .addPoints(new anchor.BN(64))
        .accounts({
          community: communityPDA,
          admin: admin.publicKey,
          adminState: adminState,
          tokenAccount: tokenAccount.address,
          tokenMint: mint,
          pdaAccount: pda,
        })
        .signers([admin])
        .rpc();
      assert.fail(
        "should not have been able to add points to non delegated account"
      );
    } catch (e) {
      expect(e.error.errorMessage).to.equal(
        "Given token account must be delegated to the program PDA"
      );
    }
  });

  it("allows delegation ✨", async () => {
    const { mint, communityPDA, admin } = details["1"] as {
      mint: PublicKey;
      admin: Keypair;
      communityPDA: PublicKey;
    };
    const fromAccount = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      admin,
      mint,
      admin.publicKey
    );
    const [pda, _nonce] = await PublicKey.findProgramAddress(
      [Buffer.from(anchor.utils.bytes.utf8.encode("Light"))],
      program.programId
    );

    const pdaTokenAccount = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      admin,
      mint,
      pda,
      true
    );

    try {
      await program.methods
        .delegate()
        .accounts({
          pdaAccount: pda,
          pdaTokenAccount: pdaTokenAccount.address,
          community: communityPDA,
          tokenMint: mint,
          tokenAccount: fromAccount.address,
          user: admin.publicKey,
        })
        .signers([admin])
        .rpc();

      const tokenInfo = await getAccount(
        provider.connection,
        fromAccount.address
      );

      expect(tokenInfo.delegate).to.eql(pda);

      details["1"].fromAccount = fromAccount;
    } catch (e) {
      console.log(e);
    }
  });

  it("adds points 💯", async () => {
    const { payer, communityPDA, mint, admin, adminState, fromAccount } =
      details["1"];

    const [pda, _nonce] = await PublicKey.findProgramAddress(
      [Buffer.from(anchor.utils.bytes.utf8.encode("Light"))],
      program.programId
    );

    try {
      await program.methods
        .addPoints(new anchor.BN(64))
        .accounts({
          community: communityPDA,
          admin: admin.publicKey,
          adminState: adminState,
          tokenAccount: fromAccount.address,
          tokenMint: mint,
          pdaAccount: pda,
        })
        .signers([admin])
        .rpc();
    } catch (e) {
      console.log(e.error.errorMessage);
    }
    const tokenInfo = await getAccount(
      provider.connection,
      fromAccount.address
    );

    details["1"].pda = pda;
    expect(tokenInfo.amount.toString()).to.equal("64");
    expect(tokenInfo.owner).to.eql(admin.publicKey);
    assert(tokenInfo.isFrozen);
  });
  it("only allows admins to add points 🚫", async () => {
    const { payer, communityPDA, mint, admin, adminState, notAdminState } =
      details["1"];
    const tokenAccount = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      admin,
      mint,
      admin.publicKey
    );

    const [pda, _nonce] = await PublicKey.findProgramAddress(
      [Buffer.from(anchor.utils.bytes.utf8.encode("Light"))],
      program.programId
    );

    try {
      await program.methods
        .addPoints(new anchor.BN(64))
        .accounts({
          community: communityPDA,
          admin: payer.publicKey,
          adminState: notAdminState,
          tokenAccount: tokenAccount.address,
          tokenMint: mint,
          pdaAccount: pda,
        })
        .signers([payer])
        .rpc();
    } catch (e) {
      expect(e.error.errorMessage).to.equal(
        "The program expected this account to be already initialized"
      );
    }
  });

  it("adds to whitelist ✅", async () => {
    const { payer, communityPDA, mint, admin, adminState } = details["1"];
    const whitelisted = anchor.web3.Keypair.generate();
    const toAccount = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      admin,
      mint,
      whitelisted.publicKey
    );

    const [whitelistPDA, _] = await PublicKey.findProgramAddress(
      [
        Buffer.from(anchor.utils.bytes.utf8.encode("whitelist")),
        Buffer.from(anchor.utils.bytes.utf8.encode("1")),
        toAccount.address.toBuffer(),
      ],

      program.programId
    );

    try {
      await program.methods
        .addToWhitelist()
        .accounts({
          admin: admin.publicKey,
          adminState,
          whitelistState: whitelistPDA,
          community: communityPDA,
          whitelistedAccount: toAccount.address,
        })
        .signers([admin])
        .rpc();
    } catch (e) {
      console.log(e);
    }

    const whitelistState = await program.account.whitelistState.fetch(
      whitelistPDA
    );

    expect(whitelistState.isWhitelisted).to.equal(true);
    details["1"].whitelistPDA = whitelistPDA;
    details["1"].toAccount = toAccount;
  });

  it("only allows admins to whitelist  🚫", async () => {
    const { payer, communityPDA, mint, admin, adminState, notAdminState } =
      details["1"];
    const whitelisted = anchor.web3.Keypair.generate();
    const toAccount = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      admin,
      mint,
      whitelisted.publicKey
    );

    const [whitelistPDA, _] = await PublicKey.findProgramAddress(
      [
        Buffer.from(anchor.utils.bytes.utf8.encode("whitelist")),
        Buffer.from(anchor.utils.bytes.utf8.encode("1")),
        toAccount.address.toBuffer(),
      ],

      program.programId
    );

    try {
      await program.methods
        .addToWhitelist()
        .accounts({
          admin: payer.publicKey,
          adminState: notAdminState,
          whitelistState: whitelistPDA,
          community: communityPDA,
          whitelistedAccount: toAccount.address,
        })
        .signers([payer])
        .rpc();

      assert.fail("should not have the authority to add to whitelist");
    } catch (e) {
      expect(e.error.errorMessage).to.equal(
        "The program expected this account to be already initialized"
      );
    }
  });

  it("does not whitelist account with wrong token mint 🚫", async () => {
    const { payer, communityPDA, mint, admin, adminState } = details["1"];
    const whitelisted = anchor.web3.Keypair.generate();

    const failMint = await createMint(
      provider.connection,
      payer,
      payer.publicKey,
      payer.publicKey,
      9
    );

    const failAccount = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      admin,
      failMint,
      whitelisted.publicKey
    );

    const [whitelistPDA, _] = await PublicKey.findProgramAddress(
      [
        Buffer.from(anchor.utils.bytes.utf8.encode("whitelist")),
        Buffer.from(anchor.utils.bytes.utf8.encode("1")),
        failAccount.address.toBuffer(),
      ],

      program.programId
    );

    try {
      await program.methods
        .addToWhitelist()
        .accounts({
          admin: admin.publicKey,
          adminState,
          whitelistState: whitelistPDA,
          community: communityPDA,
          whitelistedAccount: failAccount.address,
        })
        .signers([admin])
        .rpc();

      assert.fail("should not be able to add to whitelist");
    } catch (e) {
      expect(e.error.errorMessage).to.equal(
        "A token mint constraint was violated"
      );
    }
  });

  it("transfers to whitelist 🔂", async () => {
    const {
      payer,
      communityPDA,
      mint,
      fromAccount,
      whitelistPDA,
      toAccount,
      admin,
    } = details["1"];

    await program.methods
      .transferToWhitelist(new anchor.BN(30))
      .accounts({
        fromAccount: fromAccount.address,
        toAccount: toAccount.address,
        community: communityPDA,
        whitelistState: whitelistPDA,
        tokenMint: mint,
        owner: admin.publicKey,
        pdaAccount: details["pda"],
      })
      .signers([admin])
      .rpc();

    const toTokenInfo: Account = await getAccount(
      provider.connection,
      toAccount.address
    );
    const fromTokenInfo: Account = await getAccount(
      provider.connection,
      fromAccount.address
    );

    expect(fromTokenInfo.amount.toString()).to.equal("34");
    expect(toTokenInfo.amount.toString()).to.equal("30");
    assert(toTokenInfo.isFrozen, "toTokenAccount should be frozen");
    assert(fromTokenInfo.isFrozen, "fromTokenAccount should be frozen");
  });

  it("does not transfer to non-whitelisted 🚫", async () => {
    try {
      const {
        payer,
        communityPDA,
        mint,
        fromAccount,
        whitelistPDA,
        toAccount,
        admin,
      } = details["1"];

      const nonWhitelisted = anchor.web3.Keypair.generate();

      const nonAccount = await getOrCreateAssociatedTokenAccount(
        provider.connection,
        admin,
        mint,
        nonWhitelisted.publicKey
      );
      const [nonWhitelistPDA, _] = await PublicKey.findProgramAddress(
        [
          Buffer.from(anchor.utils.bytes.utf8.encode("whitelist")),
          Buffer.from(anchor.utils.bytes.utf8.encode("1")),
          nonAccount.address.toBuffer(),
        ],

        program.programId
      );

      await program.methods
        .transferToWhitelist(new anchor.BN(30))
        .accounts({
          fromAccount: fromAccount.address,
          toAccount: toAccount.address,
          community: communityPDA,
          whitelistState: nonWhitelistPDA,
          tokenMint: mint,
          owner: admin.publicKey,
          pdaAccount: details["pda"],
        })
        .signers([admin])
        .rpc();

      assert.fail("The transfer should have thrown an error");
    } catch (e) {
      expect(e.error.errorMessage).to.equal(
        "The program expected this account to be already initialized"
      );
    }
  });

  it("logs attestation ", async () => {
    const { communityPDA, fromAccount, admin, adminState } = details["1"];

    const tx = await program.methods
      .logAttestation("roothash")
      .accounts({
        community: communityPDA,
        admin: admin.publicKey,
        adminState,
      })
      .signers([admin])
      .rpc();

    // const parser = new EventParser(program.programId);
    // console.log("tx:", tx);
    // const info = await provider.connection.getParsedTransaction(
    //   tx,
    //   "confirmed"
    // );
    // const parser = new EventParser(program.programId, program.coder);
    // const events: Event[] = [];

    // if (info?.meta?.logMessages) {
    //   console.log("here");
    //   parser.parseLogs(info?.meta?.logMessages as string[], (log) =>
    //     events.push(log)
    //   );
    // }

    // console.log(info);

    // expect(events).to.have.lengthOf(1);
    // expect(events[0]).to.eql({
    //   data: {
    //     community: "grape",
    //     receipient: admin.PublicKey,
    //     amount: new anchor.BN(69),
    //     reason: "Nice",
    //     tag: "DEV",
    //   },
    //   name: "LogAttestation",
    // });
  });

  it("burns points 🔥", async () => {
    const { mint, payer, communityPDA, fromAccount, admin, pda } = details["1"];
    const tokenInfoBefore = await getAccount(
      provider.connection,
      fromAccount.address
    );

    const { amount: initialAmount } = tokenInfoBefore;

    const pdaTokenAccount = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      admin,
      mint,
      pda,
      true
    );
    try {
      await program.methods
        .slashPoints(new anchor.BN(30))
        .accounts({
          community: communityPDA,
          admin: admin.publicKey,
          tokenMint: mint,
          tokenAccount: fromAccount.address,
          pdaAccount: pda,
        })
        .signers([admin])
        .rpc();

      const tokenInfoAfter = await getAccount(
        provider.connection,
        fromAccount.address
      );

      const { amount: finalAmount } = tokenInfoAfter;

      expect(Number(initialAmount)).to.equal(Number(finalAmount) + 30);
    } catch (e) {
      console.log("Slash issue", e);
    }
  });

  it("removes admin 🔥", async () => {
    const { communityPDA, admin, adminState, payer } = details["1"];

    await program.methods
      .removeAdmin(admin.publicKey)
      .accounts({
        community: communityPDA,
        adminState: adminState,
        adminAuthority: payer.publicKey,
      })
      .signers([payer])
      .rpc();
  });
});
