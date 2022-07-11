use super::LHT_PDA_SEED;
use anchor_lang::prelude::*;
use anchor_spl::token::{self, FreezeAccount, Mint, ThawAccount, Token, TokenAccount, Transfer};

use crate::{
    error::LighthouseError,
    state::{Community, WhitelistState},
};

pub fn transfer_to_whitelist(ctx: Context<TransferToWhitelist>, amount: u64) -> Result<()> {
    require!(
        ctx.accounts.whitelist_state.is_whitelisted,
        LighthouseError::NotWhitelisted
    );

    require!(
        ctx.accounts.from_account.amount >= amount,
        LighthouseError::InsufficientFunds
    );

    let (_pda, bump_seed) = Pubkey::find_program_address(&[LHT_PDA_SEED], ctx.program_id);
    let seeds = &[&LHT_PDA_SEED[..], &[bump_seed]];
    let signer_seeds = &[&seeds[..]];
    // If frozen, thawing the account
    if ctx.accounts.from_account.is_frozen() {
        token::thaw_account(
            ctx.accounts
                .into_thaw_context(&ctx.accounts.from_account)
                .with_signer(signer_seeds),
        )?;
    }

    if ctx.accounts.to_account.is_frozen() {
        token::thaw_account(
            ctx.accounts
                .into_thaw_context(&ctx.accounts.to_account)
                .with_signer(signer_seeds),
        )?;
    }

    token::transfer(
        ctx.accounts
            .into_transfer_context()
            .with_signer(signer_seeds),
        amount,
    )?;

    token::freeze_account(
        ctx.accounts
            .into_freeze_context(&ctx.accounts.from_account)
            .with_signer(signer_seeds),
    )?;
    token::freeze_account(
        ctx.accounts
            .into_freeze_context(&ctx.accounts.to_account)
            .with_signer(signer_seeds),
    )?;

    Ok(())
}

#[derive(Accounts)]
pub struct TransferToWhitelist<'info> {
    #[account(mut, has_one = owner, token::mint = token_mint)]
    pub from_account: Account<'info, TokenAccount>,
    #[account(mut, token::mint = token_mint)]
    pub to_account: Account<'info, TokenAccount>,
    #[account(seeds=[b"whitelist".as_ref(),community.name.as_ref(),to_account.key().as_ref()], bump=whitelist_state.bump)]
    pub whitelist_state: Account<'info, WhitelistState>,
    #[account(has_one = token_mint, seeds = [b"community",community.name.as_ref()],bump=community.bump)]
    pub community: Account<'info, Community>,
    #[account(mut)]
    pub token_mint: Account<'info, Mint>,
    #[account(mut)]
    pub owner: Signer<'info>,
    ///CHECK: Only reading from this account
    #[account(seeds = [LHT_PDA_SEED.as_ref()], bump)]
    pub pda_account: AccountInfo<'info>,
    pub token_program: Program<'info, Token>,
}

impl<'info> TransferToWhitelist<'info> {
    pub fn into_thaw_context(
        &self,
        token_account: &Account<'info, TokenAccount>,
    ) -> CpiContext<'_, '_, '_, 'info, ThawAccount<'info>> {
        let cpi_accounts = ThawAccount {
            account: token_account.to_account_info().clone(),
            mint: self.token_mint.to_account_info().clone(),
            authority: self.pda_account.to_account_info().clone(),
        };

        let cpi_program = self.token_program.to_account_info();

        CpiContext::new(cpi_program, cpi_accounts)
    }

    pub fn into_freeze_context(
        &self,
        token_account: &Account<'info, TokenAccount>,
    ) -> CpiContext<'_, '_, '_, 'info, FreezeAccount<'info>> {
        let cpi_accounts = FreezeAccount {
            account: token_account.to_account_info().clone(),
            mint: self.token_mint.to_account_info().clone(),
            authority: self.pda_account.to_account_info().clone(),
        };

        let cpi_program = self.token_program.to_account_info();

        CpiContext::new(cpi_program, cpi_accounts)
    }
    pub fn into_transfer_context(&self) -> CpiContext<'_, '_, '_, 'info, Transfer<'info>> {
        let cpi_accounts = Transfer {
            from: self.from_account.to_account_info().clone(),
            to: self.to_account.to_account_info().clone(),
            authority: self.owner.to_account_info().clone(),
        };

        let cpi_program = self.token_program.to_account_info();

        CpiContext::new(cpi_program, cpi_accounts)
    }
}
