// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "solmate/tokens/ERC20.sol";

contract Token is ERC20 {
    mapping(address => bool) public isWhitelisted;
    address public creator;

    modifier onlyWhitelisted(address _to) {
        require(
            isWhitelisted[_to],
            "Can only transfer/approve to whitelisted addresses"
        );
        _;
    }

    constructor(
        string memory _name,
        string memory _symbol,
        uint8 _decimals
    ) ERC20(_name, _symbol, _decimals) {
        creator = msg.sender;
    }

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

    function permit(
        address owner,
        address spender,
        uint256 value,
        uint256 deadline,
        uint8 v,
        bytes32 r,
        bytes32 s
    ) public override {
        require(deadline >= block.timestamp, "PERMIT_DEADLINE_EXPIRED");

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

            require(
                recoveredAddress != address(0) && recoveredAddress == owner,
                "INVALID_SIGNER"
            );

            allowance[recoveredAddress][spender] = value;
        }

        emit Approval(owner, spender, value);
    }

    function mint(address _to, uint256 _amount) external {
        require(msg.sender == creator, "Only creator can mint");

        _mint(_to, _amount);
    }

    function slash(address _from, uint256 _amount) external {
        require(msg.sender == creator, "Only creator can slash");

        _burn(_from, _amount);
    }

    function addToWhitelist(address _whitelisted) public {
        require(msg.sender == creator, "Only creator can add to whitelist");

        isWhitelisted[_whitelisted] = true;
    }
}
