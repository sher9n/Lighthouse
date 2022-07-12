use anchor_lang::prelude::*;
mod error;
mod instructions;
mod state;
use instructions::*;

declare_id!("BRm9A4ztatp9RXLNULZqmg7WUtKL2GvWpz7tC579RzUr");
// declare_id!("Fg6PaFpoGXkYsidMpWTK6W2BeZ7FEfcYkg476zPFsLnS");

#[program]
pub mod lighthouse_program {

    use super::*;

    pub fn create_community(
        ctx: Context<CreateCommunity>,
        name: String,
        token_name: String,
    ) -> Result<()> {
        instructions::create_community::create_community(ctx, name, token_name)
    }

    pub fn add_points(ctx: Context<AddPoints>, amount: u64) -> Result<()> {
        instructions::add_points::add_points(ctx, amount)
    }

    pub fn add_to_whitelist(ctx: Context<AddWhitelist>) -> Result<()> {
        instructions::add_to_whitelist::add_to_whitelist(ctx)
    }

    pub fn transfer_to_whitelist(ctx: Context<TransferToWhitelist>, amount: u64) -> Result<()> {
        instructions::transfer_to_whitelist::transfer_to_whitelist(ctx, amount)
    }

    pub fn add_admin(ctx: Context<AddAdmin>, new_admin: Pubkey) -> Result<()> {
        instructions::add_admin::add_admin(ctx, new_admin)
    }

    pub fn log_attestation(ctx: Context<Log>, root_hash: String) -> Result<()> {
        instructions::log_attestation::log_attestation(ctx, root_hash)
    }

    pub fn delegate(ctx: Context<Delegate>) -> Result<()> {
        instructions::delegate::delegate(ctx)
    }

    pub fn slash_points(ctx: Context<SlashPoints>, amount: u64) -> Result<()> {
        instructions::slash_points::slash_points(ctx, amount)
    }

    pub fn remove_admin(ctx: Context<RemoveAdmin>, admin: Pubkey) -> Result<()> {
        instructions::remove_admin::remove_admin(ctx, admin)
    }
}
