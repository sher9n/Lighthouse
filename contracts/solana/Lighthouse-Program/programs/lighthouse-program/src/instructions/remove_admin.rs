use crate::error::LighthouseError;
use anchor_lang::prelude::*;

use crate::state::{Admin, Community};

pub fn remove_admin(_ctx: Context<RemoveAdmin>, _admin: Pubkey) -> Result<()> {
    Ok(())
}

#[derive(Accounts)]
#[instruction(_admin:Pubkey)]
pub struct RemoveAdmin<'info> {
    #[account(mut,close=admin_authority,seeds=[b"admin".as_ref(),community.name.as_ref(),_admin.key().as_ref()], bump=admin_state.bump)]
    pub admin_state: Account<'info, Admin>,
    #[account(mut)]
    pub admin_authority: Signer<'info>,
    #[account(has_one = admin_authority @ LighthouseError::NotAdminAuthority)]
    pub community: Account<'info, Community>,
    pub system_program: Program<'info, System>,
}
