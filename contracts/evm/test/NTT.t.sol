// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "forge-std/Test.sol";
import "../src/NTT.sol";
import "test/SigUtils.sol";

contract NTTTest is Test {
    address constant alice = address(0xbabe);
    address constant bob = address(0xb0b);

    uint256 internal whalePrivateKey;
    address whale;

    NTT token;
    SigUtils sigUtils;

    function setUp() public {
        token = new NTT("Lighthouse Token", "LHT", 18);
        sigUtils = new SigUtils(token.DOMAIN_SEPARATOR());

        whalePrivateKey = 0xa1e;
        whale = vm.addr(whalePrivateKey);
    }

    function testFailTransfer() public {
        token.mint(alice, 100);

        hoax(alice);
        token.transfer(bob, 50);
    }

    function testCannotTransfer() public {
        token.mint(alice, 100);

        hoax(alice);
        vm.expectRevert(bytes4(keccak256(bytes("NotWhitelisted()"))));
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

    function testMetaTransaction() public {
        token.whitelist(bob);
        SigUtils.Permit memory permit = SigUtils.Permit({
            owner: whale,
            spender: bob,
            value: 1e18,
            nonce: 0,
            deadline: 1 days
        });

        bytes32 digest = sigUtils.getTypedDataHash(permit);

        (uint8 v, bytes32 r, bytes32 s) = vm.sign(whalePrivateKey, digest);

        token.permit(
            permit.owner,
            permit.spender,
            permit.value,
            permit.deadline,
            v,
            r,
            s
        );

        assertEq(token.allowance(whale, bob), 1e18);
        assertEq(token.nonces(whale), 1);
    }

    function testCannotPermitToNonWhitelisted() public {
        SigUtils.Permit memory permit = SigUtils.Permit({
            owner: whale,
            spender: bob,
            value: 1e18,
            nonce: 0,
            deadline: 1 days
        });

        bytes32 digest = sigUtils.getTypedDataHash(permit);

        (uint8 v, bytes32 r, bytes32 s) = vm.sign(whalePrivateKey, digest);

        vm.expectRevert(bytes4(keccak256(bytes("NotWhitelisted()"))));
        token.permit(
            permit.owner,
            permit.spender,
            permit.value,
            permit.deadline,
            v,
            r,
            s
        );
    }

    function testCannotExecuteAfterDeadline() public {
        token.whitelist(bob);
        SigUtils.Permit memory permit = SigUtils.Permit({
            owner: whale,
            spender: bob,
            value: 1e18,
            nonce: 0,
            deadline: 1 days
        });

        bytes32 digest = sigUtils.getTypedDataHash(permit);

        (uint8 v, bytes32 r, bytes32 s) = vm.sign(whalePrivateKey, digest);

        skip(1 days);
        vm.expectRevert(bytes4(keccak256(bytes("PermitDeadlineExpired()"))));
        token.permit(
            permit.owner,
            permit.spender,
            permit.value,
            permit.deadline,
            v,
            r,
            s
        );
    }

    function testCannotExecuteWithWrongSignature() public {
        token.whitelist(bob);
        SigUtils.Permit memory permit = SigUtils.Permit({
            owner: alice,
            spender: bob,
            value: 1e18,
            nonce: 0,
            deadline: 1 days
        });

        bytes32 digest = sigUtils.getTypedDataHash(permit);

        (uint8 v, bytes32 r, bytes32 s) = vm.sign(whalePrivateKey, digest);

        vm.expectRevert(bytes4(keccak256(bytes("InvalidSigner()"))));
        token.permit(
            permit.owner,
            permit.spender,
            permit.value,
            permit.deadline,
            v,
            r,
            s
        );
    }
}
