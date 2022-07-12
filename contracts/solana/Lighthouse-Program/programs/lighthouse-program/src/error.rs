use anchor_lang::error_code;

#[error_code]
pub enum LighthouseError {
    #[msg("Only the admin is allowed to call this function!")]
    NotAdmin,
    #[msg("Only the admin authoriy is allowed add admins")]
    NotAdminAuthority,
    #[msg("Given account is not owned by receiver")]
    WrongReceiverAccount,
    #[msg("Init error")]
    InitError,
    #[msg("Wrong token mint for this community")]
    WrongTokenMint,
    #[msg("Insufficient funds")]
    InsufficientFunds,
    #[msg("Receipient account isn't whitelisted")]
    NotWhitelisted,
    #[msg("Given PDA does not match the program PDA")]
    WrongPDA,
    #[msg("Given token account must be delegated to the program PDA")]
    NotDelegated,
}
