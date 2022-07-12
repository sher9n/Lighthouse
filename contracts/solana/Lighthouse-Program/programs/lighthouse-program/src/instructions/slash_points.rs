use crate::{error::LighthouseError, state::Community};
use anchor_lang::prelude::*;
use anchor_spl::token::{self, Burn, FreezeAccount, Mint, ThawAccount, Token, TokenAccount};

use super::LHT_PDA_SEED;

pub fn slash_points(ctx: Context<SlashPoints>, amount: u64) -> Result<()> {
    let (pda, bump_seed) = Pubkey::find_program_address(&[LHT_PDA_SEED], ctx.program_id);
    let seeds = &[&LHT_PDA_SEED[..], &[bump_seed]];
    let signer_seeds = &[&seeds[..]];

    // Checking if the PDA is correct. Since AccountInfo does not check that for us.
    require_keys_eq!(
        ctx.accounts.pda_account.key(),
        pda.key(),
        LighthouseError::WrongPDA
    );

    // If frozen, thawing the account
    if ctx.accounts.token_account.is_frozen() {
        token::thaw_account(ctx.accounts.into_thaw_context().with_signer(signer_seeds))?;
    }

    token::burn(
        ctx.accounts.into_burn_context().with_signer(signer_seeds),
        amount,
    )?;

    token::freeze_account(ctx.accounts.into_freeze_context().with_signer(signer_seeds))?;
    Ok(())
}

#[derive(Accounts)]
pub struct SlashPoints<'info> {
    #[account(
        has_one = token_mint @ LighthouseError::WrongTokenMint,
        seeds=[b"community".as_ref(),community.name.as_ref()],
        bump= community.bump)
    ]
    pub community: Account<'info, Community>,
    #[account(mut)]
    pub admin: Signer<'info>,
    #[account(mut)]
    pub token_mint: Account<'info, Mint>,
    #[account(mut, token::mint = token_mint )]
    pub token_account: Account<'info, TokenAccount>,
    /// CHECK: There is an explicit check inside the program to check if it's the correct account.
    #[account(mut)]
    pub pda_account: AccountInfo<'info>,
    pub token_program: Program<'info, Token>,
}

impl<'info> SlashPoints<'info> {
    pub fn into_burn_context(&self) -> CpiContext<'_, '_, '_, 'info, Burn<'info>> {
        let cpi_accounts = Burn {
            mint: self.token_mint.to_account_info().clone(),
            from: self.token_account.to_account_info().clone(),
            authority: self.pda_account.to_account_info().clone(),
        };

        let cpi_program = self.token_program.to_account_info();

        CpiContext::new(cpi_program, cpi_accounts)
    }
    pub fn into_thaw_context(&self) -> CpiContext<'_, '_, '_, 'info, ThawAccount<'info>> {
        let cpi_accounts = ThawAccount {
            account: self.token_account.to_account_info().clone(),
            mint: self.token_mint.to_account_info().clone(),
            authority: self.pda_account.to_account_info().clone(),
        };

        let cpi_program = self.token_program.to_account_info();

        CpiContext::new(cpi_program, cpi_accounts)
    }
    pub fn into_freeze_context(&self) -> CpiContext<'_, '_, '_, 'info, FreezeAccount<'info>> {
        let cpi_accounts = FreezeAccount {
            account: self.token_account.to_account_info().clone(),
            mint: self.token_mint.to_account_info().clone(),
            authority: self.pda_account.to_account_info().clone(),
        };

        let cpi_program = self.token_program.to_account_info();

        CpiContext::new(cpi_program, cpi_accounts)
    }
}
