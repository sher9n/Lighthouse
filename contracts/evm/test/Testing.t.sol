// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "forge-std/Test.sol";

contract Testing is Test {
    struct Community {
        string name;
        address tokenAddress;
    }
    mapping(string => Community) public nameToCommunity;

    function testEmpty() public {
        Community memory com = nameToCommunity["Hello"];

        emit log_address(com.tokenAddress);
    }
}
