// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "solmate/tokens/ERC20.sol";

error NotWhitelisted();
error PermitDeadlineExpired();
error InvalidSigner();
error Unauthorized();

/**
 * @notice Non-transferable token.
 */
contract NTT is ERC20 {
    ////////////////////////////////////////////////////////////////
    //  LIGHTHOUSE STORAGE
    ////////////////////////////////////////////////////////////////

    /// Lighthouse contract address.
    address public lighthouse;

    /// Mapping that stores info about whitelisted addresses.
    mapping(address => bool) public isWhitelisted;

    ////////////////////////////////////////////////////////////////
    //  LIGHTHOUSE MODIFIERS
    ////////////////////////////////////////////////////////////////

    /// The modifier that checks if the recipient is on the whitelist.
    modifier onlyWhitelisted(address _to) {
        if (!isWhitelisted[_to]) {
            revert NotWhitelisted();
        }
        _;
    }

    /// The modifier that checks if the caller is the Lighthouse contract.
    modifier onlyLighthouse() {
        if (msg.sender != lighthouse) {
            revert Unauthorized();
        }
        _;
    }

    ////////////////////////////////////////////////////////////////
    //  CONSTRUCTOR
    ////////////////////////////////////////////////////////////////

    /**
     * Function that executes on contract deployment and creates the NTT token.
     * @param _name Name of creating token.
     * @param _symbol Symbol of creating token.
     * @param _decimals Decimals of creating token.
     */
    constructor(
        string memory _name,
        string memory _symbol,
        uint8 _decimals
    ) ERC20(_name, _symbol, _decimals) {
        lighthouse = msg.sender;
    }

    ////////////////////////////////////////////////////////////////
    //  OVERRIDEN ERC20 LOGIC
    ////////////////////////////////////////////////////////////////

    /**
     * Function that transfers tokens from one address to another. Recipient
     * must be whitelisted address. In any other cases will revert.
     * @param _to Recipient address.
     * @param _amount Amount of token to transfer.
     */
    function transfer(address _to, uint256 _amount)
        public
        override
        onlyWhitelisted(_to)
        returns (bool)
    {
        balanceOf[msg.sender] -= _amount;

        unchecked {
            balanceOf[_to] += _amount;
        }

        emit Transfer(msg.sender, _to, _amount);

        return true;
    }

    /**
     * Function that allows `spender` to use some amount of tokens from callers account.
     * Can only be approved to whitelisted address.
     * @param spender The account that gets approved.
     * @param amount The number of approved tokens.
     * @return Always return true.
     */
    function approve(address spender, uint256 amount)
        public
        override
        onlyWhitelisted(spender)
        returns (bool)
    {
        allowance[msg.sender][spender] = amount;

        emit Approval(msg.sender, spender, amount);

        return true;
    }

    /**
     * Function that transfers amount of NTT from one address to another address.
     * Recipient must be whitelisted address.
     * @param from The address from which we want to send NTTs.
     * @param to The address where we want to send NTTs.
     * @param amount amount of NTT we want to transfer.
     * @return Always returns true.
     */
    function transferFrom(
        address from,
        address to,
        uint256 amount
    ) public override onlyWhitelisted(to) returns (bool) {
        uint256 allowed = allowance[from][msg.sender]; // Saves gas for limited approvals.

        if (allowed != type(uint256).max)
            allowance[from][msg.sender] = allowed - amount;

        balanceOf[from] -= amount;

        // Cannot overflow because the sum of all user
        // balances can't exceed the max uint256 value.
        unchecked {
            balanceOf[to] += amount;
        }

        emit Transfer(from, to, amount);

        return true;
    }

    /**
     * Function that sets `value` as the allowance of `spender` over `owner`'s tokens,
     * given `owner`'s signed approval.
     * @param owner The address that grants the approval of his funds.
     * @param spender The account that gets approved.
     * @param value The number of approved tokens.
     * @param deadline The timestamp up to which the signature is valid.
     * @param v V part of signature.
     * @param r R part of signature.
     * @param s S part of signature.
     */
    function permit(
        address owner,
        address spender,
        uint256 value,
        uint256 deadline,
        uint8 v,
        bytes32 r,
        bytes32 s
    ) public override {
        if (!isWhitelisted[spender]) {
            revert NotWhitelisted();
        }
        if (deadline < block.timestamp) {
            revert PermitDeadlineExpired();
        }

        // Unchecked because the only math done is incrementing
        // the owner's nonce which cannot realistically overflow.
        unchecked {
            address recoveredAddress = ecrecover(
                keccak256(
                    abi.encodePacked(
                        "\x19\x01",
                        DOMAIN_SEPARATOR(),
                        keccak256(
                            abi.encode(
                                keccak256(
                                    "Permit(address owner,address spender,uint256 value,uint256 nonce,uint256 deadline)"
                                ),
                                owner,
                                spender,
                                value,
                                nonces[owner]++,
                                deadline
                            )
                        )
                    )
                ),
                v,
                r,
                s
            );

            if (recoveredAddress == address(0) || recoveredAddress != owner) {
                revert InvalidSigner();
            }

            allowance[recoveredAddress][spender] = value;
        }

        emit Approval(owner, spender, value);
    }

    ////////////////////////////////////////////////////////////////
    //  EXTENDED LOGIC
    ////////////////////////////////////////////////////////////////

    /**
     * Function that mints some amount of NTT to address.
     * @param to Address where we want to mint tokens.
     * @param amount Amount of NTT that we want to mint.
     */
    function mint(address to, uint256 amount) external onlyLighthouse {
        _mint(to, amount);
    }

    /**
     * Function that burns some amount of NTT at address.
     * @param from Address where we want to burn tokens.
     * @param amount Amount of NTT that we want to burn.
     */
    function slash(address from, uint256 amount) external onlyLighthouse {
        _burn(from, amount);
    }

    /**
     * Function that adds new address to whitelist and allowed to transfer NTT
     * to it.
     * Can be called only by Lighthouse contract.
     * @param _whitelisted The new address to add to the whitelist.
     */
    function whitelist(address _whitelisted) external onlyLighthouse {
        isWhitelisted[_whitelisted] = true;
    }
}
