// SPDX-License-Identifier: MIT
pragma solidity ^0.8.13;

import "./NTT.sol";

/** 
    @title The Lighthouse contract
    @author SusheendharVijay
    @notice The Lighthouse contract is used to manage logic for all Lighthouse communities.
*/
contract LighthouseV2 {
    mapping(string => mapping(address => bool)) public isSteward;
    mapping(string => address) public nameToCommunityToken;

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

    modifier onlySteward(string calldata name) {
        require(isSteward[name][msg.sender], "UNAUTHORIZED");
        _;
    }

    function create(
        string calldata name,
        string calldata tokenName,
        string calldata tokenSymbol,
        uint8 tokenDecimals,
        address firstSteward
    ) external {
        require(nameToCommunityToken[name] == address(0), "ALREADY_EXISTS");
        NTT token = new NTT(tokenName, tokenSymbol, tokenDecimals);

        nameToCommunityToken[name] = address(token);

        isSteward[name][firstSteward] = true;

        emit CommunityCreated(name);
    }

    function reward(
        string calldata communityName,
        address receiver,
        uint256 amount
    ) external onlySteward(communityName) {
        NTT(nameToCommunityToken[communityName]).mint(receiver, amount);

        emit Rewarded(communityName, receiver, amount, communityName);
    }

    function slash(
        string calldata communityName,
        address from,
        uint256 amount
    ) external onlySteward(communityName) {
        NTT(nameToCommunityToken[communityName]).slash(from, amount);

        emit Slashed(communityName, from, amount, communityName);
    }

    function authorize(string calldata communityName, address steward)
        external
        onlySteward(communityName)
    {
        isSteward[communityName][steward] = true;

        emit StewardAdded(communityName, steward, communityName);
    }

    function revoke(string calldata communityName, address steward)
        external
        onlySteward(communityName)
    {
        isSteward[communityName][steward] = false;

        emit StewardRevoked(communityName, steward, communityName);
    }

    function whitelist(string calldata communityName, address whitelisted)
        external
        onlySteward(communityName)
    {
        NTT(nameToCommunityToken[communityName]).whitelist(whitelisted);

        emit Whitelisted(communityName, whitelisted);
    }

    function attest(
        string calldata communityName,
        address receiver,
        uint256 amount,
        string calldata reason
    ) external onlySteward(communityName) {
        emit Attested(communityName, receiver, amount, reason);
    }
}
