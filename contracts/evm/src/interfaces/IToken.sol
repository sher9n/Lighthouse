// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.10;

interface IToken {
    event Approval(
        address indexed owner,
        address indexed spender,
        uint256 amount
    );
    event Transfer(address indexed from, address indexed to, uint256 amount);

    function DOMAIN_SEPARATOR() external view returns (bytes32);

    function addToWhitelist(address _whitelisted) external;

    function allowance(address, address) external view returns (uint256);

    function approve(address spender, uint256 amount) external returns (bool);

    function balanceOf(address) external view returns (uint256);

    function creator() external view returns (address);

    function decimals() external view returns (uint8);

    function isWhitelisted(address) external view returns (bool);

    function mint(address _to, uint256 _amount) external;

    function name() external view returns (string memory);

    function nonces(address) external view returns (uint256);

    function permit(
        address owner,
        address spender,
        uint256 value,
        uint256 deadline,
        uint8 v,
        bytes32 r,
        bytes32 s
    ) external;

    function slash(address _from, uint256 _amount) external;

    function symbol() external view returns (string memory);

    function totalSupply() external view returns (uint256);

    function transfer(address _to, uint256 _amount) external returns (bool);

    function transferFrom(
        address from,
        address to,
        uint256 amount
    ) external returns (bool);
}
