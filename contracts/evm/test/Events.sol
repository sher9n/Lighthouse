// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

contract Events {
    event CommunityCreated(string name);

    event ProposalCreated(
        string indexed _communityName,
        uint256 indexed _proposalID,
        bytes proposalType
    );

    event Voted(
        string indexed _communityName,
        uint256 indexed _proposalID,
        address indexed _from,
        bool _decision
    );

    event StewardAdded(
        string indexed name,
        address indexed steward,
        string communityName
    );

    event StewardRevoked(
        string indexed name,
        address indexed steward,
        string communityName
    );

    event Rewarded(
        string indexed name,
        address indexed receiver,
        uint256 amount,
        string communityName
    );

    event Slashed(
        string indexed name,
        address indexed from,
        uint256 amount,
        string communityName
    );

    event Whitelisted(string indexed name, address whitelisted);

    event Attested(string indexed name, bytes32 rootHash);
}
