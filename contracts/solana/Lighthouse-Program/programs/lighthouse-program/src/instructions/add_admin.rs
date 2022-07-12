use anchor_lang::prelude::*;

use crate::error::LighthouseError;
use crate::state::{Admin, Community};

pub fn add_admin(ctx: Context<AddAdmin>, _new_admin: Pubkey) -> Result<()> {
    ctx.accounts.admin_state.bump = *ctx.bumps.get("admin_state").unwrap();
    Ok(())
}

#[derive(Accounts)]
#[instruction(_new_admin:Pubkey)]
pub struct AddAdmin<'info> {
    #[account(
        init,
        payer = admin_authority,
        seeds =
        [
            b"admin".as_ref(),
            community.name.as_ref(),
            _new_admin.as_ref()
        ],
        bump,
        space = 8+ Admin::SIZE
    )]
    pub admin_state: Account<'info, Admin>,
    #[account(mut)]
    pub admin_authority: Signer<'info>,
    #[account(has_one = admin_authority @ LighthouseError::NotAdminAuthority)]
    pub community: Account<'info, Community>,
    pub system_program: Program<'info, System>,
}
