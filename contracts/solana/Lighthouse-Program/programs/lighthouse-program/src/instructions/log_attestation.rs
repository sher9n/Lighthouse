use anchor_lang::prelude::*;

use crate::state::{Admin, Community};

pub fn log_attestation(_ctx: Context<Log>, root_hash: String) -> Result<()> {
    emit!(LogRootHash {
        root_hash,
        timestamp: Clock::get().unwrap().unix_timestamp
    });
    Ok(())
}

#[event]
pub struct LogRootHash {
    root_hash: String,
    timestamp: i64,
}

#[derive(Accounts)]
pub struct Log<'info> {
    #[account(
        seeds=[b"community".as_ref(),community.name.as_ref()],
        bump= community.bump)
    ]
    pub community: Account<'info, Community>,
    pub admin: Signer<'info>,
    #[account(seeds=[b"admin".as_ref(),community.name.as_ref(),admin.key().as_ref()], bump=admin_state.bump)]
    pub admin_state: Account<'info, Admin>,
    pub system_program: Program<'info, System>,
}
