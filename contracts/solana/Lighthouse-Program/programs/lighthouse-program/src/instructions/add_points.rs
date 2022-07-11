use super::LHT_PDA_SEED;
use crate::state::{Admin, Community};
use anchor_lang::prelude::*;
use anchor_spl::token::{self, FreezeAccount, Mint, MintTo, ThawAccount, Token, TokenAccount};

use crate::error::LighthouseError;
/// add_points : use this fn to add points
pub fn add_points(ctx: Context<AddPoints>, amount: u64) -> Result<()> {
    let (pda, bump_seed) = Pubkey::find_program_address(&[LHT_PDA_SEED], ctx.program_id);
    let seeds = &[&LHT_PDA_SEED[..], &[bump_seed]];
    let signer_seeds = &[&seeds[..]];

    require!(
        ctx.accounts.token_account.delegate.is_some(),
        LighthouseError::NotDelegated
    );

    require_keys_eq!(
        ctx.accounts.token_account.delegate.unwrap(),
        pda,
        LighthouseError::NotDelegated
    );

    // If frozen, thawing the account
    if ctx.accounts.token_account.is_frozen() {
        token::thaw_account(ctx.accounts.into_thaw_context().with_signer(signer_seeds))?;
    }

    token::mint_to(
        ctx.accounts.into_mint_context().with_signer(signer_seeds),
        amount,
    )?;

    // token::approve(ctx, amount)?;

    token::freeze_account(ctx.accounts.into_freeze_context().with_signer(signer_seeds))?;

    Ok(())
}

#[derive(Accounts)]
pub struct AddPoints<'info> {
    #[account(
        has_one = token_mint @ LighthouseError::WrongTokenMint,
        seeds=[b"community".as_ref(),community.name.as_ref()],
        bump= community.bump)
    ]
    pub community: Account<'info, Community>,
    #[account(mut)]
    pub admin: Signer<'info>,
    #[account(seeds=[b"admin".as_ref(),community.name.as_ref(),admin.key().as_ref()], bump=admin_state.bump)]
    pub admin_state: Account<'info, Admin>,
    #[account(mut)]
    pub token_mint: Account<'info, Mint>,
    #[account(mut, token::mint = token_mint)]
    pub token_account: Account<'info, TokenAccount>,
    pub token_program: Program<'info, Token>,
    /// CHECK: If invalid account is sent, it will still fail while invoking cpi.
    pub pda_account: AccountInfo<'info>,
}

impl<'info> AddPoints<'info> {
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
    pub fn into_mint_context(&self) -> CpiContext<'_, '_, '_, 'info, MintTo<'info>> {
        let cpi_accounts = MintTo {
            mint: self.token_mint.to_account_info().clone(),
            to: self.token_account.to_account_info(),
            authority: self.pda_account.clone(),
        };

        let cpi_program = self.token_program.to_account_info();

        CpiContext::new(cpi_program, cpi_accounts)
    }
}
