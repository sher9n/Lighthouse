use anchor_lang::prelude::*;
#[account]
pub struct WhitelistState {
    pub is_whitelisted: bool,
    pub bump: u8,
}

impl WhitelistState {
    pub const SIZE: usize = 1 + 1;
}
