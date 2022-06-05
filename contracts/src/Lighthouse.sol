// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "./Token.sol";

contract Lighthouse {
    string public name;
    address public immutable tokenAddress;
    address public factoryAddress;

    mapping(address => bool) public isAdmin;
    mapping(address => uint256) public pointsBalanceOf;

    event TokenWhitelistAdded(string indexed name, address _whitelisted);

    modifier onlyAllowed() {
        require(
            msg.sender == factoryAddress || isAdmin[msg.sender],
            "UNAUTHORIZED"
        );
        _;
    }

    constructor(
        address _initialAdmin,
        string memory _name,
        string memory _tokenName,
        string memory _tokenSymbol,
        uint8 _tokenDecimals
    ) {
        name = _name;
        isAdmin[_initialAdmin] = true;
        factoryAddress = msg.sender;
        Token token = new Token(_tokenName, _tokenSymbol, _tokenDecimals);
        tokenAddress = address(token);
    }

    function addPointsTo(address receiver, uint256 amount) public onlyAllowed {
        Token(tokenAddress).mint(receiver, amount);
    }

    function slashPoints(address _from, uint256 _amount) public onlyAllowed {
        // TODO: add an event if necessary.
        Token(tokenAddress).slash(_from, _amount);
    }

    function makeAdmin(address _newAdmin) public onlyAllowed {
        isAdmin[_newAdmin] = true;
    }

    function addToTokenWhitelist(address _whitelisted) public onlyAllowed {
        Token(tokenAddress).addToWhitelist(_whitelisted);
        emit TokenWhitelistAdded(name, _whitelisted);
    }
}
