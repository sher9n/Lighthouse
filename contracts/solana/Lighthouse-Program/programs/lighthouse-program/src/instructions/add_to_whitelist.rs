use crate::state::Admin;
use crate::state::Community;
use crate::state::WhitelistState;
use anchor_lang::prelude::*;
use anchor_spl::token::TokenAccount;

pub fn add_to_whitelist(ctx: Context<AddWhitelist> ) -> Result<()> {
    ctx.accounts.whitelist_state.is_whitelisted = true;

    ctx.accounts.whitelist_state.bump = *ctx.bumps.get("whitelist_state").unwrap();
    Ok(())
}

#[derive(Accounts)]
pub struct AddWhitelist<'info> {
    #[account(
        init,
        seeds =
            [
                b"whitelist".as_ref(),
                community.name.as_ref(), 
                whitelisted_account.key().as_ref()
            ],
        bump,
        payer = admin, 
        space= 8 + WhitelistState::SIZE
    )]
    pub whitelist_state: Account<'info, WhitelistState>,
    #[account(token::mint = community.token_mint)]
    pub whitelisted_account: Account<'info,TokenAccount>,
    #[account(mut)]
    pub admin: Signer<'info>,
    #[account(seeds =[b"admin".as_ref(),community.name.as_ref(),admin.key().as_ref()], bump= admin_state.bump )]
    pub admin_state: Account<'info,Admin>,
    #[account(
        seeds = [b"community",community.name.as_ref()],
        bump=community.bump
    )]
    pub community: Account<'info, Community>,
    pub system_program: Program<'info, System>,
}
