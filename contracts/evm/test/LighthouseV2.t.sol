// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "forge-std/Test.sol";
import "../src/LighthouseV2.sol";
import "../src/NTT.sol";
import "./Events.sol";

contract LighthouseV2Test is Test, Events {
    LighthouseV2 lighthouse = new LighthouseV2();
    address constant steward = address(0xbabe);
    address constant normie = address(0xb0b);

    function setUp() public {
        lighthouse.create("Uniswap", "Uniswap points", "UNI", 18, steward);
    }

    function testCreate() public {
        address tokenAddr = lighthouse.nameToCommunityToken("Uniswap");
        NTT token = NTT(tokenAddr);

        assertTrue(tokenAddr != address(0x0));
        assertEq(token.name(), "Uniswap points");
        assertEq(token.symbol(), "UNI");
        assertEq(token.decimals(), 18);
        assertEq(token.totalSupply(), 0);
    }

    function testCreateDup() public {
        vm.expectRevert("ALREADY_EXISTS");
        lighthouse.create("Uniswap", "Uniswap points", "UNI", 18, steward);
    }

    function testCreateEvent() public {
        vm.expectEmit(false, false, false, true);
        emit CommunityCreated("Unisocks");
        lighthouse.create("Unisocks", "Uniswap points", "UNI", 18, steward);
    }

    function testReward() public {
        hoax(steward);
        vm.expectEmit(true, true, false, true);
        emit Rewarded("Uniswap", normie, 100, "Uniswap");
        lighthouse.reward("Uniswap", normie, 100);

        address tokenAddr = lighthouse.nameToCommunityToken("Uniswap");
        assertEq(NTT(tokenAddr).balanceOf(normie), 100);
        assertEq(NTT(tokenAddr).totalSupply(), 100);
    }

    function testSlash() public {
        startHoax(steward);

        lighthouse.reward("Uniswap", normie, 100);
        vm.expectEmit(true, true, false, true);
        emit Slashed("Uniswap", normie, 50, "Uniswap");
        lighthouse.slash("Uniswap", normie, 50);

        vm.stopPrank();

        address tokenAddr = lighthouse.nameToCommunityToken("Uniswap");
        assertEq(NTT(tokenAddr).balanceOf(normie), 50);
        assertEq(NTT(tokenAddr).totalSupply(), 50);
    }

    function testAuthorize() public {
        hoax(steward);
        vm.expectEmit(true, true, false, true);
        emit StewardAdded("Uniswap", normie, "Uniswap");
        lighthouse.authorize("Uniswap", normie);

        assertTrue(lighthouse.isSteward("Uniswap", normie));

        hoax(normie);
        lighthouse.reward("Uniswap", normie, 100);
    }

    function testFakeAuthority() public {
        vm.expectRevert("UNAUTHORIZED");
        lighthouse.authorize("Uniswap", normie);
    }

    function testRevoke() public {
        hoax(steward);
        lighthouse.authorize("Uniswap", normie);

        hoax(normie);
        lighthouse.authorize("Uniswap", address(this));

        hoax(steward);
        vm.expectEmit(true, true, false, true);
        emit StewardRevoked("Uniswap", normie, "Uniswap");
        lighthouse.revoke("Uniswap", normie);

        vm.expectRevert("UNAUTHORIZED");
        hoax(normie);
        lighthouse.authorize("Uniswap", address(this));
    }

    function testWhitelist() public {
        startHoax(steward);

        lighthouse.reward("Uniswap", address(this), 100);

        vm.expectEmit(true, false, false, true);
        emit Whitelisted("Uniswap", normie);
        lighthouse.whitelist("Uniswap", normie);

        vm.stopPrank();

        // TODO: here expectRevert("NOT_WHITELISTED") doesn't work while transfering to non-whitelisted
        // even though the same reason shows up while testing.

        NTT(lighthouse.nameToCommunityToken("Uniswap")).transfer(normie, 50);
    }

    function testAttest() public {
        hoax(steward);
        vm.expectEmit(true, true, false, true);
        emit Attested("Uniswap", normie, 69, "Nice");
        lighthouse.attest("Uniswap", normie, 69, "Nice");
    }
}
