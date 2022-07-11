use super::LHT_PDA_SEED;
use crate::state::Community;
use anchor_lang::prelude::*;
use anchor_spl::token::{self, Mint, SetAuthority, Token};
use spl_token::instruction::AuthorityType;

pub fn create_community(
    ctx: Context<CreateCommunity>,
    name: String,
    token_name: String,
) -> Result<()> {
    let community = &mut ctx.accounts.community;
    community.name = name;
    community.token_name = token_name;
    community.admin_authority = ctx.accounts.payer.key();
    community.bump = *ctx.bumps.get("community").unwrap();

    let (pda, _bump_seed) = Pubkey::find_program_address(&[LHT_PDA_SEED], ctx.program_id);
    token::set_authority(ctx.accounts.into(), AuthorityType::MintTokens, Some(pda))?;
    token::set_authority(ctx.accounts.into(), AuthorityType::FreezeAccount, Some(pda))?;

    ctx.accounts.community.token_mint = ctx.accounts.token_mint.key();
    Ok(())
}
#[derive(Accounts)]
#[instruction(name:String)]
pub struct CreateCommunity<'info> {
    #[account(init,seeds =[b"community".as_ref(), name.as_ref()], bump, payer=payer, space = 8 + Community::MAX_SIZE)]
    pub community: Account<'info, Community>,
    #[account(mut)]
    pub payer: Signer<'info>,
    #[account(mut, constraint = token_mint.supply == 0)]
    pub token_mint: Account<'info, Mint>,
    pub token_program: Program<'info, Token>,
    pub system_program: Program<'info, System>,
}

impl<'info> From<&mut CreateCommunity<'info>>
    for CpiContext<'_, '_, '_, 'info, SetAuthority<'info>>
{
    fn from(accounts: &mut CreateCommunity<'info>) -> Self {
        let cpi_accounts = SetAuthority {
            current_authority: accounts.payer.to_account_info().clone(),
            account_or_mint: accounts.token_mint.to_account_info().clone(),
        };
        let cpi_program = accounts.token_program.to_account_info();
        CpiContext::new(cpi_program, cpi_accounts)
    }
}
