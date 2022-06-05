// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "forge-std/Test.sol";
import "../src/LighthouseFactory.sol";
import "../src/Lighthouse.sol";
import "../src/interfaces/IToken.sol";
import "../src/interfaces/ILighthouse.sol";

contract LighthouseFactoryTest is Test {
    LighthouseFactory factory;
    address constant alice = address(0xbabe);
    address constant bob = address(0xb0b);
    address constant gasTank = address(0xbaadf00d);
    address newLighthouseAddr;
    event LighthouseCreated(string name, address addr);
    event Whitelisted(string name, address _whitelisted);
    event PointsAdded(
        address indexed targetAddress,
        address indexed receiver,
        uint256 points
    );
    event AdminAdded(address indexed targetAddress, address indexed admin);
    event SolPointsAdded(string tokenAddress, string receiver, uint256 points);
    event LighthouseLog(
        uint256 indexed timestamp,
        string indexed communityIndexed,
        string community,
        string message
    );

    function setUp() public {
        factory = new LighthouseFactory(address(this));
        newLighthouseAddr = factory.createLighthouse(
            alice,
            gasTank,
            "Uniswap",
            "Uniswap points",
            "UNI",
            18
        );
    }

    function testCreatingLighthouse() public {
        IToken token = IToken(Lighthouse(newLighthouseAddr).tokenAddress());

        assertEq(factory.nameToAddress("Uniswap"), newLighthouseAddr);
        assertEq(factory.gasTankOf(newLighthouseAddr), gasTank);

        assertEq(
            Lighthouse(newLighthouseAddr).factoryAddress(),
            address(factory)
        );
        assertEq(Lighthouse(newLighthouseAddr).name(), "Uniswap");
        assertEq(token.name(), "Uniswap points");
        assertEq(token.symbol(), "UNI");
        assertEq(token.decimals(), 18);
        assertTrue(Lighthouse(newLighthouseAddr).isAdmin(alice));
    }

    function testFailCreatingDupLighthouse() public {
        factory.createLighthouse(
            alice,
            gasTank,
            "Uniswap",
            "Uniswap points",
            "UNI",
            18
        );
    }

    function testGasTank() public {
        assertEq(factory.gasTankOf(newLighthouseAddr), gasTank);
    }

    function testAddPoints() public {
        hoax(alice);
        factory.addPointsTo(bob, 100, newLighthouseAddr);
    }

    function testAddPointsEvent() public {
        hoax(alice);
        vm.expectEmit(true, true, false, false);
        emit PointsAdded(newLighthouseAddr, bob, 100);
        factory.addPointsTo(bob, 100, newLighthouseAddr);
    }

    function testGasTankCanCall() public {
        hoax(gasTank);
        factory.addPointsTo(bob, 100, newLighthouseAddr);
    }

    function testSlashPoints() public {
        hoax(alice);
        factory.addPointsTo(bob, 100, newLighthouseAddr);
        hoax(gasTank);
        factory.slashPoints(bob, 50, newLighthouseAddr);
        assertEq(
            IToken(Lighthouse(newLighthouseAddr).tokenAddress()).balanceOf(bob),
            50
        );
    }

    function testMakeAdmin() public {
        hoax(alice);
        factory.makeAdmin(bob, newLighthouseAddr);
        assertTrue(Lighthouse(newLighthouseAddr).isAdmin(bob));
    }

    function testMakeAdminEvent() public {
        hoax(gasTank);
        vm.expectEmit(true, true, false, false);
        emit AdminAdded(newLighthouseAddr, bob);
        factory.makeAdmin(bob, newLighthouseAddr);
    }

    function testAddTokenWhitelist() public {
        hoax(alice);
        factory.addToTokenWhitelist(bob, newLighthouseAddr);
        address tokenAddr = Lighthouse(newLighthouseAddr).tokenAddress();
        assertTrue(IToken(tokenAddr).isWhitelisted(bob));
    }

    function testAddSolPoints() public {
        vm.expectEmit(false, false, false, true);
        emit SolPointsAdded("solana token", "solana account", 42);
        factory.addSolPointsTo("solana token", "solana account", 42);
    }

    function testSetOwner() public {
        factory.setOwner(bob);
        assertEq(factory.owner(), bob);
    }

    function testFailNotOwnerSetOwner() public {
        hoax(bob);
        factory.setOwner(alice);
    }

    function testFailNotOwnerAddSolPoint() public {
        hoax(bob);
        factory.addSolPointsTo("solana token", "solana account", 42);
    }

    function testOwner() public {
        assertEq(factory.owner(), address(this));
    }

    function testSetGasTank() public {
        hoax(gasTank);
        factory.setGasTank(bob, newLighthouseAddr);
        assertEq(factory.gasTankOf(newLighthouseAddr), bob);
    }

    function testFailSetGasTank() public {
        factory.setGasTank(bob, newLighthouseAddr);
        assertEq(factory.gasTankOf(newLighthouseAddr), bob);
    }

    function testLogMsg() public {
        vm.expectEmit(true, true, false, true);
        emit LighthouseLog(12345, "Uniswap", "Uniswap", "Made 100 swaps");
        factory.logMsg(12345, "Uniswap", "Made 100 swaps");
    }
}
