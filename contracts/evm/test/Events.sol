// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

contract Events {
    event CommunityCreated(string name);

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

    event Attested(
        string indexed name,
        address receiver,
        uint256 amount,
        string reason
    );
}
