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

    address constant uninitializedToken =
        address(bytes20(keccak256(bytes("Community Without a Token"))));

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
        emit Attested("Uniswap", bytes32("rootHash"));
        lighthouse.attest("Uniswap", bytes32("rootHash"));
    }

    function testCreateWithoutToken() public {
        hoax(steward);
        lighthouse.createWithoutToken("test", steward);

        assertEq(lighthouse.nameToCommunityToken("test"), uninitializedToken);
        assertEq(lighthouse.isSteward("test", steward), true);
    }

    function testFailRewardWithoutToken(
        string memory name,
        address firstSteward,
        uint256 amount
    ) public {
        lighthouse.createWithoutToken(name, firstSteward);

        lighthouse.reward(name, normie, amount);
    }

    function testFailSlashWithoutToken(
        string memory name,
        address firstSteward,
        uint256 amount
    ) public {
        lighthouse.createWithoutToken(name, firstSteward);

        lighthouse.slash(name, normie, amount);
    }

    function testFailWhitelistWithoutToken(
        string memory name,
        address firstSteward
    ) public {
        lighthouse.createWithoutToken(name, firstSteward);

        lighthouse.whitelist(name, normie);
    }

    function testCreateTokenWithToken(string memory name) public {
        lighthouse.create(name, "test", "TEST", 18, steward);
        vm.expectRevert("WRONG_COMMUNITY");
        lighthouse.createToken(name, "Uniswap token", "UNI", 18);
    }

    function testCreateTokenWithoutToken(string memory name) public {
        lighthouse.createWithoutToken(name, steward);
        lighthouse.createToken(name, "Uniswap token", "UNI", 18);
        assertFalse(
            lighthouse.nameToCommunityToken(name) == uninitializedToken
        );
    }

    function testAttestWithoutToken(string memory name) public {
        lighthouse.createWithoutToken(name, steward);
        vm.expectEmit(true, true, false, true);
        emit Attested(name, bytes32("rootHash"));
        hoax(steward);
        lighthouse.attest(name, bytes32("rootHash"));
    }

    function testAuthorizeWithoutToken(string memory name) public {
        lighthouse.createWithoutToken(name, steward);
        vm.expectEmit(true, true, false, true);
        emit StewardAdded(name, normie, name);
        hoax(steward);
        lighthouse.authorize(name, normie);
    }

    function testRevokeWithoutToken(string memory name) public {
        lighthouse.createWithoutToken(name, steward);
        vm.expectEmit(true, true, false, true);
        emit StewardRevoked(name, normie, name);
        hoax(steward);
        lighthouse.revoke(name, normie);
    }
}
