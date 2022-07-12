use anchor_lang::prelude::*;
#[account]
pub struct Community {
    pub name: String,       // can be 20 bytes in length
    pub token_name: String, // can be 20 bytes in length
    pub admin_authority: Pubkey,
    pub token_mint: Pubkey,
    pub bump: u8,
}

const PUBKEY_SIZE: usize = 32;
const STRING_20: usize = 4 + 20;
const BUMP_SIZE: usize = 1;

impl Community {
    pub const MAX_SIZE: usize = 2 * STRING_20 + 2 * PUBKEY_SIZE + BUMP_SIZE;
}
