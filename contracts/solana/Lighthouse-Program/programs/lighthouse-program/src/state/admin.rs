use anchor_lang::prelude::*;
#[account]
pub struct Admin {
    pub bump: u8,
}

impl Admin {
    pub const SIZE: usize = 1;
}
