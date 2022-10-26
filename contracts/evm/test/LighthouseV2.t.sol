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
        lighthouse.create(
            "Uniswap",
            "Uniswap points",
            "UNI",
            18,
            steward,
            1 days,
            1,
            address(0)
        );
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
        lighthouse.create(
            "Uniswap",
            "Uniswap points",
            "UNI",
            18,
            steward,
            1 days,
            1,
            address(0)
        );
    }

    function testCreateEvent() public {
        vm.expectEmit(false, false, false, true);
        emit CommunityCreated("Unisocks");
        lighthouse.create(
            "Unisocks",
            "Uniswap points",
            "UNI",
            18,
            steward,
            1 days,
            1,
            address(0)
        );
    }

    function testCreateProposal() public {
        hoax(steward);
        vm.expectEmit(true, true, true, true);
        emit ProposalCreated("Uniswap", 0, "");
        lighthouse.createProposal("", "Uniswap", "");
    }

    function testVote() public {
        startHoax(steward);
        lighthouse.createProposal("", "Uniswap", "");

        LighthouseV2.Proposal memory proposal = lighthouse.getCommunityProposal(
            "Uniswap",
            0
        );
        assertEq(proposal.votesFor, 0);

        vm.expectEmit(true, true, true, true);
        emit Voted("Uniswap", 0, steward, true);
        lighthouse.vote("Uniswap", 0, true);

        proposal = lighthouse.getCommunityProposal("Uniswap", 0);
        assertEq(proposal.votesFor, 1);
    }

    function testRevote() public {
        startHoax(steward);
        lighthouse.createProposal("", "Uniswap", "");

        LighthouseV2.Proposal memory proposal = lighthouse.getCommunityProposal(
            "Uniswap",
            0
        );
        assertEq(proposal.votesFor, 0);

        vm.expectEmit(true, true, true, true);
        emit Voted("Uniswap", 0, steward, true);
        lighthouse.vote("Uniswap", 0, true);

        proposal = lighthouse.getCommunityProposal("Uniswap", 0);
        assertEq(proposal.votesFor, 1);

        vm.expectEmit(true, true, true, true);
        emit Voted("Uniswap", 0, steward, false);
        lighthouse.vote("Uniswap", 0, false);

        proposal = lighthouse.getCommunityProposal("Uniswap", 0);
        assertEq(proposal.votesFor, 0);
    }

    function testCannotVoteWithWrongId() public {
        startHoax(steward);
        lighthouse.createProposal("", "Uniswap", "");

        vm.expectRevert("wrong proposal ID");
        lighthouse.vote("Uniswap", 1, true);
    }

    function testCannotVoteAfterEnd() public {
        startHoax(steward);
        lighthouse.createProposal("", "Uniswap", "");

        skip(1 days);

        vm.expectRevert("you can't vote now");
        lighthouse.vote("Uniswap", 0, true);
    }

    function testCannotVoteWithSameDicision() public {
        startHoax(steward);
        lighthouse.createProposal("", "Uniswap", "");

        lighthouse.vote("Uniswap", 0, true);

        vm.expectRevert("your vote already stored");
        lighthouse.vote("Uniswap", 0, true);
    }

    function testFinishProposalWithDecline() public {
        startHoax(steward);
        lighthouse.createProposal("", "Uniswap", "");

        LighthouseV2.Proposal memory proposal = lighthouse.getCommunityProposal(
            "Uniswap",
            0
        );
        assertEq(proposal.votesFor, 0);
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.UNFINISHED)
        );

        skip(7 days);

        lighthouse.finishProposal("Uniswap", 0);

        uint16 admins = lighthouse.numberOfAdmins("Uniswap");
        assertEq(admins, 1);
        proposal = lighthouse.getCommunityProposal("Uniswap", 0);
        assertEq(proposal.votesFor, 0);
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.DECLINED)
        );
    }

    function testChangeQuorum() public {
        startHoax(steward);
        bytes memory bytecode;
        uint256 newQuorum = 2;
        // Adding info about type of proposal
        uint256 tmpUint;
        tmpUint = newQuorum << 2;
        tmpUint += uint8(LighthouseV2.ProposalType.CHANGE_QUORUM);

        bytecode = abi.encodePacked(tmpUint);

        lighthouse.createProposal("", "Uniswap", bytecode);

        LighthouseV2.Proposal memory proposal = lighthouse.getCommunityProposal(
            "Uniswap",
            0
        );
        assertEq(proposal.votesFor, 0);

        (uint256 quorum, ) = lighthouse.nameToProposalConfig("Uniswap");

        assertEq(quorum, 1);
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.UNFINISHED)
        );

        lighthouse.vote("Uniswap", 0, true);

        skip(7 days);

        lighthouse.finishProposal("Uniswap", 0);

        proposal = lighthouse.getCommunityProposal("Uniswap", 0);
        assertEq(proposal.votesFor, 1);
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.ACCEPTED)
        );

        (quorum, ) = lighthouse.nameToProposalConfig("Uniswap");

        assertEq(quorum, newQuorum);
    }

    function testChangeDuration() public {
        startHoax(steward);
        bytes memory bytecode;
        uint256 newDuration = 2 days;
        // Adding info about type of proposal
        uint256 tmpUint;
        tmpUint = newDuration << 2;
        tmpUint += uint8(LighthouseV2.ProposalType.CHANGE_DURATION);

        bytecode = abi.encodePacked(tmpUint);

        lighthouse.createProposal("", "Uniswap", bytecode);

        LighthouseV2.Proposal memory proposal = lighthouse.getCommunityProposal(
            "Uniswap",
            0
        );
        assertEq(proposal.votesFor, 0);

        (, uint256 duration) = lighthouse.nameToProposalConfig("Uniswap");

        assertEq(duration, 1 days);
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.UNFINISHED)
        );

        lighthouse.vote("Uniswap", 0, true);

        skip(1 days);

        lighthouse.finishProposal("Uniswap", 0);

        proposal = lighthouse.getCommunityProposal("Uniswap", 0);
        assertEq(proposal.votesFor, 1);
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.ACCEPTED)
        );

        (, duration) = lighthouse.nameToProposalConfig("Uniswap");

        assertEq(duration, newDuration);
    }

    function testAddAdmin() public {
        startHoax(steward);
        createAuthorizeProposalAndExecute(normie);

        LighthouseV2.Proposal memory proposal = lighthouse.getCommunityProposal(
            "Uniswap",
            0
        );
        assertEq(proposal.votesFor, 1);
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.ACCEPTED)
        );

        assertEq(lighthouse.isSteward("Uniswap", normie), true);

        uint16 admins = lighthouse.numberOfAdmins("Uniswap");
        assertEq(admins, 2);
    }

    function testRevokeAdmin() public {
        startHoax(steward);
        createAuthorizeProposalAndExecute(normie);

        assertEq(lighthouse.isSteward("Uniswap", normie), true);

        uint16 admins = lighthouse.numberOfAdmins("Uniswap");
        assertEq(admins, 2);

        createRevokeProposalAndExecute(normie);

        LighthouseV2.Proposal memory proposal = lighthouse.getCommunityProposal(
            "Uniswap",
            1
        );
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.ACCEPTED)
        );

        assertEq(lighthouse.isSteward("Uniswap", normie), false);

        admins = lighthouse.numberOfAdmins("Uniswap");
        assertEq(admins, 1);

        hoax(normie);
        vm.expectRevert("UNAUTHORIZED");
        lighthouse.createProposal("", "Uniswap", "");
    }

    function testMintToken() public {
        startHoax(steward);
        uint256 amountToMint = 100;
        createMintProposalAndExecute(normie, 100);

        LighthouseV2.Proposal memory proposal = lighthouse.getCommunityProposal(
            "Uniswap",
            0
        );
        assertEq(proposal.votesFor, 1);
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.ACCEPTED)
        );

        address tokenAddr = lighthouse.nameToCommunityToken("Uniswap");
        assertEq(NTT(tokenAddr).balanceOf(normie), amountToMint);
        assertEq(NTT(tokenAddr).totalSupply(), amountToMint);
    }

    function testBurnToken() public {
        startHoax(steward);
        uint256 amountToMint = 100;
        createMintProposalAndExecute(normie, amountToMint);

        createBurnProposalAndExecute(normie, amountToMint / 2);

        address tokenAddr = lighthouse.nameToCommunityToken("Uniswap");
        assertEq(NTT(tokenAddr).balanceOf(normie), amountToMint / 2);
        assertEq(NTT(tokenAddr).totalSupply(), amountToMint / 2);
    }

    function testCannotFinishProposalEarlier() public {
        startHoax(steward);
        lighthouse.createProposal("", "Uniswap", "");

        vm.expectRevert("Proposal is going on");
        lighthouse.finishProposal("Uniswap", 0);
    }

    function testWhitelist() public {
        startHoax(steward);
        // minting tokens
        bytes memory bytecode;
        uint256 recipientAddress = uint256(uint160(address(this)));
        uint256 tmpUint;
        tmpUint = recipientAddress << 94;
        tmpUint += 1;
        tmpUint = tmpUint << 2;
        tmpUint += uint8(LighthouseV2.ProposalType.CHANGE_POINTS);

        uint256 amountToMint = 100;

        bytecode = abi.encodePacked(tmpUint, amountToMint);

        lighthouse.createProposal("", "Uniswap", bytecode);

        lighthouse.vote("Uniswap", 0, true);

        skip(7 days);

        lighthouse.finishProposal("Uniswap", 0);

        address tokenAddress = lighthouse.nameToCommunityToken("Uniswap");

        vm.expectRevert("NOT_WHITELISTED");
        NTT(tokenAddress).transfer(normie, 50);

        vm.expectEmit(true, false, false, true);
        emit Whitelisted("Uniswap", normie);
        lighthouse.whitelist("Uniswap", normie);

        vm.stopPrank();

        NTT(tokenAddress).transfer(normie, 50);
    }

    function testAttest() public {
        hoax(steward);
        vm.expectEmit(true, true, false, true);
        emit Attested("Uniswap", bytes32("rootHash"));
        lighthouse.attest("Uniswap", bytes32("rootHash"));
    }

    function testCreateWithoutToken() public {
        hoax(steward);
        lighthouse.createWithoutToken("test", steward, 1 days, 1);

        assertEq(lighthouse.nameToCommunityToken("test"), uninitializedToken);
        assertEq(lighthouse.isSteward("test", steward), true);
    }

    // function testFailRewardWithoutToken(
    //     string memory name,
    //     address firstSteward,
    //     uint256 amount
    // ) public {
    //     lighthouse.createWithoutToken(name, firstSteward);

    //     // lighthouse.reward(name, normie, amount);
    // }

    // function testFailSlashWithoutToken(
    //     string memory name,
    //     address firstSteward,
    //     uint256 amount
    // ) public {
    //     lighthouse.createWithoutToken(name, firstSteward);

    //     // lighthouse.slash(name, normie, amount);
    // }

    function testFailWhitelistWithoutToken(
        string memory name,
        address firstSteward
    ) public {
        lighthouse.createWithoutToken(name, firstSteward, 1 days, 1);

        lighthouse.whitelist(name, normie);
    }

    function testCreateTokenWithToken(string memory name) public {
        lighthouse.create(
            name,
            "test",
            "TEST",
            18,
            steward,
            1 days,
            1,
            address(0)
        );
        vm.expectRevert("WRONG_COMMUNITY");
        lighthouse.createToken(name, "Uniswap token", "UNI", 18);
    }

    function testCreateTokenWithoutToken(string memory name) public {
        lighthouse.createWithoutToken(name, steward, 1 days, 1);
        lighthouse.createToken(name, "Uniswap token", "UNI", 18);
        assertFalse(
            lighthouse.nameToCommunityToken(name) == uninitializedToken
        );
    }

    function testAttestWithoutToken(string memory name) public {
        lighthouse.createWithoutToken(name, steward, 1 days, 1);
        vm.expectEmit(true, true, false, true);
        emit Attested(name, bytes32("rootHash"));
        hoax(steward);
        lighthouse.attest(name, bytes32("rootHash"));
    }

    // function testAuthorizeWithoutToken(string memory name) public {
    //     lighthouse.createWithoutToken(name, steward);
    //     vm.expectEmit(true, true, false, true);
    //     emit StewardAdded(name, normie, name);
    //     hoax(steward);
    //     // lighthouse.authorize(name, normie);
    // }

    // function testRevokeWithoutToken(string memory name) public {
    //     lighthouse.createWithoutToken(name, steward);
    //     vm.expectEmit(true, true, false, true);
    //     emit StewardRevoked(name, normie, name);
    //     hoax(steward);
    //     // lighthouse.revoke(name, normie);
    // }

    function createMintProposalAndExecute(address recipient, uint256 amount)
        internal
    {
        // Constructing input bytecode which is:
        // 0x + address where we want to mint or burn (20byte eq 160bit) + 93 bits of zeros + flag for
        // determine should we burn or mint(1bit) + type of proposal(2bit cause we have only 4 types).
        // also wa are appending amount of tokens to mint or burn.
        // e.g. 0x0000000000000000000000000000000000000b0b0000000000000000000000070000000000000000000000000000000000000000000000000000000000000064
        //      0x|               adddress                |      flag + type     |                        amount of tokens                       |
        bytes memory bytecode;
        uint256 recipientAddress = uint256(uint160(recipient));
        uint256 tmpUint;
        tmpUint = recipientAddress << 94;
        tmpUint += 1;
        tmpUint = tmpUint << 2;
        tmpUint += uint8(LighthouseV2.ProposalType.CHANGE_POINTS);

        uint256 amountToMint = amount;

        bytecode = abi.encodePacked(tmpUint, amountToMint);

        uint256 proposalIndex = lighthouse.createProposal(
            "",
            "Uniswap",
            bytecode
        );

        lighthouse.vote("Uniswap", proposalIndex, true);

        skip(7 days);

        lighthouse.finishProposal("Uniswap", proposalIndex);
    }

    function createBurnProposalAndExecute(address recipient, uint256 amount)
        internal
    {
        bytes memory bytecode;
        uint256 recipientAddress = uint256(uint160(recipient));
        uint256 tmpUint;
        tmpUint = recipientAddress << 96;
        tmpUint += uint8(LighthouseV2.ProposalType.CHANGE_POINTS);

        uint256 amountToBurn = amount;
        bytecode = abi.encodePacked(tmpUint, amountToBurn);

        uint256 proposalIndex = lighthouse.createProposal(
            "",
            "Uniswap",
            bytecode
        );

        lighthouse.vote("Uniswap", proposalIndex, true);

        skip(7 days);

        lighthouse.finishProposal("Uniswap", proposalIndex);
    }

    function createAuthorizeProposalAndExecute(address recipient) internal {
        bytes memory bytecode;
        uint256 recipientAddress = uint256(uint160(recipient));
        // Adding info about type of proposal
        // Constructing input bytecode which is:
        // 0x + address that we want to authorize or revoke (20byte eq 160bit) + 93 bits of zeros + flag for
        // determine should we add admin or revoke(1bit) + type of proposal(2bit cause we have only 4 types).
        // e.g. 0x0000000000000000000000000000000000000b0b000000000000000000000004
        //      0x|               adddress                |      flag + type     |
        uint256 tmpUint;
        tmpUint = recipientAddress << 94;
        tmpUint += 1;
        tmpUint = tmpUint << 2;
        tmpUint += uint8(LighthouseV2.ProposalType.CHANGE_ADMIN);

        bytecode = abi.encodePacked(tmpUint);
        uint256 proposalIndex = lighthouse.createProposal(
            "",
            "Uniswap",
            bytecode
        );

        LighthouseV2.Proposal memory proposal = lighthouse.getCommunityProposal(
            "Uniswap",
            proposalIndex
        );
        assertEq(proposal.votesFor, 0);
        assertEq(
            uint8(proposal.state),
            uint8(LighthouseV2.ProposalState.UNFINISHED)
        );

        lighthouse.vote("Uniswap", proposalIndex, true);

        skip(7 days);

        lighthouse.finishProposal("Uniswap", proposalIndex);
    }

    function createRevokeProposalAndExecute(address recipient) internal {
        bytes memory bytecode;
        uint256 recipientAddress = uint256(uint160(recipient));
        // Adding info about type of proposal
        // Constructing input bytecode which is:
        // 0x + address that we want to authorize or revoke (20byte eq 160bit) + 93 bits of zeros + flag for
        // determine should we add admin or revoke(1bit) + type of proposal(2bit cause we have only 4 types).
        // e.g. 0x0000000000000000000000000000000000000b0b000000000000000000000004
        //      0x|               adddress                |      flag + type     |
        uint256 tmpUint;
        tmpUint = recipientAddress << 96;
        tmpUint += uint8(LighthouseV2.ProposalType.CHANGE_ADMIN);

        bytecode = abi.encodePacked(tmpUint);

        uint256 proposalIndex = lighthouse.createProposal(
            "",
            "Uniswap",
            bytecode
        );

        lighthouse.vote("Uniswap", proposalIndex, true);
        vm.stopPrank();
        hoax(normie);
        lighthouse.vote("Uniswap", proposalIndex, true);

        skip(7 days);

        lighthouse.finishProposal("Uniswap", proposalIndex);
    }
}
