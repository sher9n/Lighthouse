// SPDX-License-Identifier: MIT
pragma solidity ^0.8.13;

import "./NTT.sol";

/** 
    @title The Lighthouse contract
    @author SusheendharVijay
    @notice The Lighthouse contract is used to manage logic for all Lighthouse communities.
*/
contract LighthouseV2 {
    ///////////////////////////////////////////////////////////////
    //  STORAGE
    ///////////////////////////////////////////////////////////////

    mapping(string => mapping(address => bool)) public isSteward;
    mapping(string => address) public nameToCommunityToken;

    address constant uninitializedToken =
        address(bytes20(keccak256(bytes("Community Without a Token"))));

    ///////////////////////////////////////////////////////////////
    //  EVENTS
    ///////////////////////////////////////////////////////////////

    // Events are subject to change according to actual usage.

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

    event Attested(string indexed name, bytes32 attestation);

    ///////////////////////////////////////////////////////////////
    //  MODIFIERS
    ///////////////////////////////////////////////////////////////

    modifier onlySteward(string calldata name) {
        require(isSteward[name][msg.sender], "UNAUTHORIZED");
        _;
    }

    ///////////////////////////////////////////////////////////////
    //  LOGIC
    ///////////////////////////////////////////////////////////////

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

    function createWithoutToken(string calldata name, address firstSteward)
        external
    {
        require(nameToCommunityToken[name] == address(0), "ALREADY_EXISTS");

        nameToCommunityToken[name] = uninitializedToken;

        isSteward[name][firstSteward] = true;

        emit CommunityCreated(name);
    }

    function createToken(
        string calldata name,
        string calldata tokenName,
        string calldata tokenSymbol,
        uint8 tokenDecimals
    ) external {
        require(
            nameToCommunityToken[name] == uninitializedToken,
            "WRONG_COMMUNITY"
        );
        NTT token = new NTT(tokenName, tokenSymbol, tokenDecimals);
        nameToCommunityToken[name] = address(token);
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

    function attest(string calldata communityName, bytes32 rootHash)
        external
        onlySteward(communityName)
    {
        emit Attested(communityName, rootHash);
    }
}
