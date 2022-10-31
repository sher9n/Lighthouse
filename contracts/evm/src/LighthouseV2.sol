// SPDX-License-Identifier: MIT
pragma solidity ^0.8.13;

import "@opengsn/packages/contracts/src/ERC2771Recipient.sol";
import "./NTT.sol";

/** 
    It saves bytecode to revert on custom errors instead of using require
	statements.
*/
error Unauthorized();
error CommunityAlreadyExists();
error InvalidCommunityToCreateToken();
error InvalidProposalId();
error ProposalAlreadyFinshed();
error ProposalIsGoingOn();
error ProposalVoteTimeEnded();
error SameDecisionAlreadyStored();

/** 
    @title The Lighthouse contract
    @author SusheendharVijay
    @author Mikhail Rozalenok
    @notice The Lighthouse contract is used to manage logic for all Lighthouse communities.
*/
contract LighthouseV2 is ERC2771Recipient {
    ///////////////////////////////////////////////////////////////
    //  STRUCTURES
    ///////////////////////////////////////////////////////////////
    enum ProposalState {
        UNFINISHED,
        ACCEPTED,
        DECLINED
    }

    enum ProposalType {
        CHANGE_ADMIN,
        CHANGE_QUORUM,
        CHANGE_DURATION,
        CHANGE_POINTS
    }

    //struct that contains properties for proposal
    struct Proposal {
        string description;
        // ProposalType proposalType;
        bytes proposalData;
        ProposalState state;
        uint16 votesFor;
        // uint16 votesAgainst;
        // uint256 start;
        uint256 end;
    }

    struct ProposalConfig {
        uint256 quorumToReject;
        uint256 durationOfProposal;
    }

    ///////////////////////////////////////////////////////////////
    //  STORAGE
    ///////////////////////////////////////////////////////////////

    mapping(string => mapping(address => bool)) public isSteward;
    mapping(string => address) public nameToCommunityToken;
    mapping(string => ProposalConfig) public nameToProposalConfig;
    mapping(string => Proposal[]) public communityProposals;
    mapping(string => uint16) public numberOfAdmins;
    // communityName => proposalId => voterAddress => decision
    mapping(string => mapping(uint256 => mapping(address => bool)))
        public votes;
    // communityName => proposalId => ownerAddress => spenderAddress => access
    // mapping(string => mapping(uint256 => mapping(address => mapping(address => bool)))) public delegated;

    address constant uninitializedToken =
        address(bytes20(keccak256(bytes("Community Without a Token"))));

    ///////////////////////////////////////////////////////////////
    //  EVENTS
    ///////////////////////////////////////////////////////////////

    // Events are subject to change according to actual usage.

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

    event Delegated(
        string indexed _communityName,
        uint256 _proposalID,
        address indexed _owner,
        address indexed _spender
    );

    event ProposalFinished(
        string indexed _communityName,
        uint256 indexed _proposalID,
        ProposalState indexed _state
    );

    event QuorumChanged(
        string indexed _communityName,
        uint256 indexed _newQuorum
    );

    event DurationChanged(
        string indexed _communityName,
        uint256 indexed _newDuration
    );

    event StewardAdded(string indexed name, address indexed steward);

    event StewardRevoked(string indexed name, address indexed steward);

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
        if (!isSteward[name][_msgSender()]) {
            revert Unauthorized();
        }
        _;
    }

    ///////////////////////////////////////////////////////////////
    //  LOGIC
    ///////////////////////////////////////////////////////////////

    constructor(address trustedForwarder) {
        _setTrustedForwarder(trustedForwarder);
    }

    function create(
        string calldata name,
        string calldata tokenName,
        string calldata tokenSymbol,
        uint8 tokenDecimals,
        address firstSteward,
        uint256 durationOfProposal,
        uint256 quorumToReject
    ) external {
        if (nameToCommunityToken[name] != address(0)) {
            revert CommunityAlreadyExists();
        }
        NTT token = new NTT(tokenName, tokenSymbol, tokenDecimals);

        nameToCommunityToken[name] = address(token);

        isSteward[name][firstSteward] = true;
        unchecked {
            numberOfAdmins[name]++;
        }

        ProposalConfig memory newConfig = ProposalConfig({
            durationOfProposal: durationOfProposal,
            quorumToReject: quorumToReject
        });

        nameToProposalConfig[name] = newConfig;

        emit CommunityCreated(name);
    }

    function createWithoutToken(
        string calldata name,
        address firstSteward,
        uint256 durationOfProposal,
        uint256 quorumToReject
    ) external {
        if (nameToCommunityToken[name] != address(0)) {
            revert CommunityAlreadyExists();
        }

        nameToCommunityToken[name] = uninitializedToken;

        isSteward[name][firstSteward] = true;
        unchecked {
            numberOfAdmins[name]++;
        }

        ProposalConfig memory newConfig = ProposalConfig({
            durationOfProposal: durationOfProposal,
            quorumToReject: quorumToReject
        });

        nameToProposalConfig[name] = newConfig;

        emit CommunityCreated(name);
    }

    function createToken(
        string calldata name,
        string calldata tokenName,
        string calldata tokenSymbol,
        uint8 tokenDecimals
    ) external {
        if (nameToCommunityToken[name] != uninitializedToken) {
            revert InvalidCommunityToCreateToken();
        }
        NTT token = new NTT(tokenName, tokenSymbol, tokenDecimals);
        nameToCommunityToken[name] = address(token);
    }

    /**
     * Function that creates a proposal for execute some logic.
     * @param _description String that contains description of proposal.
     * @param _communityName Name of community for which we create the proposal.
     * @param _proposalData Bytecode that contains all necessary data for logic execution.
     * At first 32 bytes we contain type of proposal, boolean flag if need(for add/remove admin
     * or mint/burn token), and one argument. We pack this via bitwise shifts.
     * We always contain type of proposal in 2 first bits, because we have only 4 types.
     * For proposals which interacts with quorum and duration, new values
     * can contains in another 254 bits. It should be fine that we have this ristriction for
     * duration and quorum, because in real condition we don't need this big numbers for it.
     * For proposals that changes admins or mints/burns tokens, we should pack bytes a little bit in
     * different way. Type contains the same, but after it in next bit we store the flag that mentioned
     * before. After it at left 20 bytes we contain address of recipient (new admin or recipient of tokens).
     * 0x0000000000000000000000000000000000000b0b000000000000000000000004
     *   |          recipient address           |      free bytes      | there are 3 bits with type of proposal and flag
     * Also we adding another 32bytes word to this bytecode in case of mint/burn proposals, that contains
     * the amount of tokens to mint/burn.
     * @return index Return index of proposal that connected to community.
     */
    function createProposal(
        string calldata _description,
        string calldata _communityName,
        bytes calldata _proposalData
    ) external onlySteward(_communityName) returns (uint256 index) {
        Proposal memory newProposal = Proposal({
            votesFor: 0,
            proposalData: _proposalData,
            description: _description,
            end: block.timestamp +
                nameToProposalConfig[_communityName].durationOfProposal,
            state: ProposalState.UNFINISHED
        });
        uint256 proposalIndex = communityProposals[_communityName].length;
        communityProposals[_communityName].push(newProposal);
        emit ProposalCreated(_communityName, proposalIndex, _proposalData);
        return proposalIndex;
    }

    function vote(
        string calldata _communityName,
        uint256 _proposalId,
        bool _newDecision
    ) external onlySteward(_communityName) {
        _vote(_communityName, _msgSender(), _proposalId, _newDecision);
    }

    // function voteFrom(string calldata _communityName, address _from, uint256 _proposalId, bool _newDecision) external {
    //     if (_from == address(0)) {
    //         revert AddressZero();
    //     }
    //     if (!delegated[_communityName][_proposalId][_from][_msgSender()]) {
    //         revert NoRightsToVoteFrom();
    //     }
    //     _vote(_communityName, _from, _proposalId, _newDecision);
    // }

    function finishProposal(string calldata _communityName, uint256 _proposalId)
        external
    {
        if (communityProposals[_communityName].length <= _proposalId) {
            revert InvalidProposalId();
        }
        Proposal storage proposal = communityProposals[_communityName][
            _proposalId
        ];
        if (proposal.state != ProposalState.UNFINISHED) {
            revert ProposalAlreadyFinshed();
        }
        if (block.timestamp < proposal.end) {
            revert ProposalIsGoingOn();
        }

        // check quorum
        uint16 rejectedNumber = numberOfAdmins[_communityName] -
            proposal.votesFor;
        if (
            (rejectedNumber <
                nameToProposalConfig[_communityName].quorumToReject) ||
            (nameToProposalConfig[_communityName].quorumToReject == 0)
        ) {
            bytes memory data = proposal.proposalData;
            uint256 parsedData;
            assembly {
                parsedData := mload(add(data, 32))
            }

            // parse type of proposal
            uint256 proposalType = (uint256(parsedData) << 254) >> 254;
            if (proposalType == uint256(ProposalType.CHANGE_ADMIN)) {
                if ((parsedData << 253) >> 255 == 1) {
                    if (
                        !isSteward[_communityName][
                            address(uint160(parsedData >> 96))
                        ]
                    ) {
                        isSteward[_communityName][
                            address(uint160(parsedData >> 96))
                        ] = true;
                        numberOfAdmins[_communityName]++;
                        // emit StewardAdded(_communityName, address(uint160(parsedData >> 2)));
                    }
                } else {
                    if (
                        isSteward[_communityName][
                            address(uint160(parsedData >> 96))
                        ]
                    ) {
                        isSteward[_communityName][
                            address(uint160(parsedData >> 96))
                        ] = false;
                        numberOfAdmins[_communityName]--;
                    }
                    // emit StewardRevoked(_communityName, address(uint160(parsedData >> 2)));
                }
            } else if (proposalType == uint256(ProposalType.CHANGE_QUORUM)) {
                nameToProposalConfig[_communityName].quorumToReject =
                    parsedData >>
                    2;
                // emit QuorumChanged(_communityName, parsedData >> 1);
            } else if (proposalType == uint256(ProposalType.CHANGE_DURATION)) {
                nameToProposalConfig[_communityName].durationOfProposal =
                    parsedData >>
                    2;
                // emit DurationChanged(_communityName, parsedData >> 1);
            } else {
                uint256 parsedAmount;
                assembly {
                    parsedAmount := mload(add(data, 64))
                }
                uint256 flag = (parsedData << 253) >> 255;
                if (flag == 1) {
                    NTT(nameToCommunityToken[_communityName]).mint(
                        address(uint160(parsedData >> 96)),
                        parsedAmount
                    );
                } else {
                    NTT(nameToCommunityToken[_communityName]).slash(
                        address(uint160(parsedData >> 96)),
                        parsedAmount
                    );
                }
            }
            proposal.state = ProposalState.ACCEPTED;
        } else {
            proposal.state = ProposalState.DECLINED;
        }

        emit ProposalFinished(_communityName, _proposalId, proposal.state);
    }

    // function delegate(string calldata _communityName, uint256 _proposalId, address _spender) external returns (bool) {
    //     if (_spender == address(0)) {
    //          revert AddressZero();
    //     }
    //     if (communityProposals[_communityName].length <= _proposalId) {
    //         revert InvalidProposalId();
    //     }
    //     _delegate(_communityName, _proposalId, _msgSender(), _spender);
    //     return true;
    // }

    function _vote(
        string calldata _communityName,
        address _voter,
        uint256 _proposalId,
        bool _newDecision
    ) internal {
        if (communityProposals[_communityName].length <= _proposalId) {
            revert InvalidProposalId();
        }
        Proposal storage proposal = communityProposals[_communityName][
            _proposalId
        ];
        if (block.timestamp >= proposal.end) {
            revert ProposalVoteTimeEnded();
        }
        bool decision = votes[_communityName][_proposalId][_voter];
        if (_newDecision == decision) {
            revert SameDecisionAlreadyStored();
        }

        unchecked {
            if (!_newDecision) {
                proposal.votesFor--;
            } else {
                proposal.votesFor++;
            }
        }

        votes[_communityName][_proposalId][_voter] = _newDecision;
        emit Voted(_communityName, _proposalId, _voter, _newDecision);
    }

    // function _delegate(string calldata _communityName, uint256 _proposalID, address _owner, address _spender) internal {
    //     delegated[_communityName][_proposalID][_owner][_spender] = true;
    //     emit Delegated(_communityName, _proposalID, _owner, _spender);
    // }

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

    function getCommunityProposal(
        string calldata _communityName,
        uint256 _proposalId
    ) external view returns (Proposal memory) {
        return communityProposals[_communityName][_proposalId];
    }

    // TODO: add permissions
    function setTrustedForwarder(address trustedForwarder) external {
        _setTrustedForwarder(trustedForwarder);
    }
}
