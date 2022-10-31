// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "forge-std/Test.sol";
import "../src/NTT.sol";

contract NTTTest is Test {
    address constant alice = address(0xbabe);
    address constant bob = address(0xb0b);
    NTT token;

    function setUp() public {
        token = new NTT("Lighthouse Token", "LHT", 18);
    }

    function testFailTransfer() public {
        token.mint(alice, 100);

        hoax(alice);
        token.transfer(bob, 50);
    }

    function testCannotTransfer() public {
        token.mint(alice, 100);

        hoax(alice);
        vm.expectRevert(abi.encodePacked("NOT_WHITELISTED"));
        token.transfer(bob, 50);
    }

    function testWhitelistTransfer() public {
        token.mint(alice, 100);
        token.whitelist(bob);

        hoax(alice);
        token.transfer(bob, 50);

        assertEq(token.balanceOf(bob), 50);
        assertEq(token.balanceOf(alice), 50);
    }

    function testFailApprove() public {
        token.mint(alice, 100);

        hoax(alice);
        token.approve(bob, 50);
    }

    function testApproveToWhitelist() public {
        token.mint(alice, 100);
        token.whitelist(bob);

        hoax(alice);
        token.approve(bob, 50);
    }

    function testFailApprovedToNonWhitelisted() public {
        token.mint(alice, 100);
        token.whitelist(bob);

        hoax(alice);
        token.approve(bob, 50);

        hoax(bob);
        token.transferFrom(alice, address(this), 50);
    }

    function testTransferFromToWhitelist() public {
        token.mint(alice, 100);
        token.whitelist(bob);

        hoax(alice);
        token.approve(bob, 50);

        hoax(bob);
        token.transferFrom(alice, bob, 50);

        assertEq(token.balanceOf(bob), 50);
        assertEq(token.balanceOf(alice), 50);
    }
}
