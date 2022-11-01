// SPDX-License-Identifier: MIT
pragma solidity ^0.8.13;

import "@opengsn/packages/contracts/src/ERC2771Recipient.sol";
import "@openzeppelin/access/Ownable.sol";
import "./NTT.sol";

/** 
    It saves bytecode to revert on custom errors instead of using require
	statements.
*/
error CommunityAlreadyExists();
error InvalidCommunityToCreateToken();
error InvalidProposalId();
error ProposalAlreadyFinshed();
error ProposalIsGoingOn();
error ProposalVoteTimeEnded();
error SameDecisionAlreadyStored();
error WrongRange();

/** 
    @title The Lighthouse contract
    @author SusheendharVijay
    @author Mikhail Rozalenok
    @notice The Lighthouse contract is used to manage logic for all Lighthouse communities.
*/
contract LighthouseV2 is Ownable, ERC2771Recipient {
    ///////////////////////////////////////////////////////////////
    //  STRUCTURES
    ///////////////////////////////////////////////////////////////

    // Enum for check proposal state.
    enum ProposalState {
        UNFINISHED,
        ACCEPTED,
        DECLINED
    }

    // Enum for check proposal type.
    enum ProposalType {
        CHANGE_ADMIN,
        CHANGE_QUORUM,
        CHANGE_DURATION,
        CHANGE_POINTS
    }

    // Struct that contains properties for proposal.
    struct Proposal {
        string description; // Description of proposal.
        bytes proposalData; // Data that contains type of proposal and parameters.
        ProposalState state; // Proposal state.
        uint16 votesFor; // Votes for accept proposal.
        uint256 end; // Deadline of proposal.
    }

    // Struct that contains proposal configuration.
    /**
     * @param quorumToRejec asad
     */
    struct ProposalConfig {
        uint16 quorumToReject; // Minimum number of stewards that voted against to reject proposal.
        uint240 durationOfProposal; // Duration of proposal, added to timestamp when proposal was created.
    }

    ///////////////////////////////////////////////////////////////
    //  STORAGE
    ///////////////////////////////////////////////////////////////

    // Mapping that stores steward's addresses of particular community.
    mapping(string => mapping(address => bool)) public isSteward;
    // Mapping that stores addresses of community tokens.
    mapping(string => address) public nameToCommunityToken;
    // Mapping that stores proposals configs of particular community.
    mapping(string => ProposalConfig) public nameToProposalConfig;
    // Mapping that stores array of all proposals that existed for particular community.
    mapping(string => Proposal[]) public communityProposals;
    // Mapping that stores number of stewards of particular community.
    mapping(string => uint16) public numberOfStewards;
    // Mapping that stores votes of stewards for particular proposal.
    // communityName => proposalId => voterAddress => decision
    mapping(string => mapping(uint256 => mapping(address => bool)))
        public votes;

    // Placeholder for community tokens that have not been initialized.
    address constant uninitializedToken =
        address(bytes20(keccak256(bytes("Community Without a Token"))));

    ///////////////////////////////////////////////////////////////
    //  EVENTS
    ///////////////////////////////////////////////////////////////

    // Events are subject to change according to actual usage.
    /*
     * Event that emits on community creation.
     * @param name Name of the community.
     */
    event CommunityCreated(string _communityName);

    /*
     * Event that emits on proposal creation.
     * @param _communityName Name of the community.
     * @param _proposalId Id of the created proposal.
     * @param _proposalData Data of created proposal, that contains type of proposal
     * and additional parameters.
     */
    event ProposalCreated(
        string indexed _communityName,
        uint256 indexed _proposalID,
        bytes _proposalData
    );

    /**
     * Event that emits when steward votes(actually when steward changes decision, false by default).
     * @param _communityName Name of the community.
     * @param _proposalId Id of the proposal.
     * @param _from Address of steward that voted.
     * @param _decision Decision of steward. True, if votes for and false, if against.
     */
    event Voted(
        string indexed _communityName,
        uint256 indexed _proposalId,
        address indexed _from,
        bool _decision
    );

    /**
     * Event that emits when proposal finished.
     * @param _communityName Name of the community.
     * @param _proposalId Id of the proposal.
     * @param _state Flag that idicates if proposal was accepted or declined.
     */
    event ProposalFinished(
        string indexed _communityName,
        uint256 indexed _proposalId,
        ProposalState indexed _state
    );

    /**
     * Event that emits when add new address to whitelist for particular community token.
     * @param _communityName Name of the community.
     * @param whitelisted New whitelisted address.
     */
    event Whitelisted(string indexed _communityName, address whitelisted);

    /**
     * Event that emits on attest.
     * @param _communityName Name of the community.
     * @param _attestation Attestation.
     */
    event Attested(string indexed _communityName, bytes32 _attestation);

    ///////////////////////////////////////////////////////////////
    //  MODIFIERS
    ///////////////////////////////////////////////////////////////

    /**
     * This modifier checks if the caller is the steward of given community.
     * @param _communityName Name of the community.
     */
    modifier onlySteward(string calldata _communityName) {
        if (!isSteward[_communityName][_msgSender()]) {
            revert Unauthorized();
        }
        _;
    }

    ///////////////////////////////////////////////////////////////
    //  LOGIC
    ///////////////////////////////////////////////////////////////

    /**
     * Function that executes on contract deployment.
     * @param trustedForwarder Forwarder singleton we accept meta tx calls from.
     */
    constructor(address trustedForwarder) {
        _setTrustedForwarder(trustedForwarder);
    }

    /**
     * Function that creates new community with its own non-transferable community token.
     * @param name Name of the community.
     * @param tokenName Name for community token.
     * @param tokenSymbol Symbol for community token.
     * @param tokenDecimals Decimals for community token.
     * @param firstSteward Address of the first steward for created community.
     * @param durationOfProposal Duration for proposals in this community.
     * @param quorumToReject Minimum quorum of stewards that voted against proposal to reject it.
     */
    function create(
        string calldata name,
        string calldata tokenName,
        string calldata tokenSymbol,
        uint8 tokenDecimals,
        address firstSteward,
        uint240 durationOfProposal,
        uint16 quorumToReject
    ) external {
        if (nameToCommunityToken[name] != address(0)) {
            revert CommunityAlreadyExists();
        }
        NTT token = new NTT(tokenName, tokenSymbol, tokenDecimals);

        nameToCommunityToken[name] = address(token);

        isSteward[name][firstSteward] = true;
        unchecked {
            numberOfStewards[name]++;
        }

        ProposalConfig memory newConfig = ProposalConfig({
            durationOfProposal: durationOfProposal,
            quorumToReject: quorumToReject
        });

        nameToProposalConfig[name] = newConfig;

        emit CommunityCreated(name);
    }

    /**
     * Function that creates new community without its own non-transferable community token.
     * Token can be created further via function `createToken`.
     * @param name Name of the community.
     * @param firstSteward Address of the first steward for created community.
     * @param durationOfProposal Duration for proposals in this community.
     * @param quorumToReject Minimum quorum of stewards that voted against proposal to reject it.
     */
    function createWithoutToken(
        string calldata name,
        address firstSteward,
        uint240 durationOfProposal,
        uint16 quorumToReject
    ) external {
        if (nameToCommunityToken[name] != address(0)) {
            revert CommunityAlreadyExists();
        }

        nameToCommunityToken[name] = uninitializedToken;

        isSteward[name][firstSteward] = true;
        unchecked {
            numberOfStewards[name]++;
        }

        ProposalConfig memory newConfig = ProposalConfig({
            durationOfProposal: durationOfProposal,
            quorumToReject: quorumToReject
        });

        nameToProposalConfig[name] = newConfig;

        emit CommunityCreated(name);
    }

    /**
     * Function that creates non-transferable community token for community that exists.
     * @param name Name of the community.
     * @param tokenName Name for community token.
     * @param tokenSymbol Symbol for community token.
     * @param tokenDecimals Decimals for community token.
     */
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
     * can contains in another 254 bits(don't forget that duration is uint240). It should be fine that we have
     * this ristriction for duration and quorum, because in real condition we don't need this big numbers for it.
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

    /**
     * Function that allows stewards to vote for particular proposals.
     * @param _communityName Name of the community.
     * @param _proposalId Id of the porposal.
     * @param _newDecision New decision should be different with that is stored. Remember,
     * that if steward didn't vote at all, contract store his vote as con by default.
     */
    function vote(
        string calldata _communityName,
        uint256 _proposalId,
        bool _newDecision
    ) external onlySteward(_communityName) {
        _vote(_communityName, _proposalId, _msgSender(), _newDecision);
    }

    /**
     * Function that finishes proposal and executes it. Can be called by anyone,
     * after end of proposal.
     * @param _communityName Name of the community.
     * @param _proposalId Id of the proposal.
     */
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

        uint16 rejectedNumber;
        unchecked {
            rejectedNumber =
                numberOfStewards[_communityName] -
                proposal.votesFor;
        }
        // Check quorum.
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

            // Parse type of proposal.
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
                        unchecked {
                            numberOfStewards[_communityName]++;
                        }
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
                        unchecked {
                            numberOfStewards[_communityName]--;
                        }
                    }
                }
            } else if (proposalType == uint256(ProposalType.CHANGE_QUORUM)) {
                nameToProposalConfig[_communityName].quorumToReject = uint16(
                    parsedData >> 2
                );
            } else if (proposalType == uint256(ProposalType.CHANGE_DURATION)) {
                nameToProposalConfig[_communityName]
                    .durationOfProposal = uint240(parsedData >> 2);
            } else {
                uint256 parsedAmount;
                assembly {
                    parsedAmount := mload(add(data, 64))
                }
                if ((parsedData << 253) >> 255 == 1) {
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

    /**
     * Function that adds new address to whitelist of particular community token.
     * Can be called only by stewards of community.
     * @param _communityName Name of the community.
     * @param _whitelisted The new address to add to the whitelist.
     */
    function whitelist(string calldata _communityName, address _whitelisted)
        external
        onlySteward(_communityName)
    {
        NTT(nameToCommunityToken[_communityName]).whitelist(_whitelisted);

        emit Whitelisted(_communityName, _whitelisted);
    }

    /**
     * Function that attests.
     * @param _communityName Name of the community.
     * @param _rootHash Root hash.
     */
    function attest(string calldata _communityName, bytes32 _rootHash)
        external
        onlySteward(_communityName)
    {
        emit Attested(_communityName, _rootHash);
    }

    /**
     * Function that sets trusted forwarder, for handle gasless transactions.
     * @param trustedForwarder Address of new trusted forwarder.
     */
    function setTrustedForwarder(address trustedForwarder) external onlyOwner {
        _setTrustedForwarder(trustedForwarder);
    }

    /**
     * View function that returns information about certain proposal by
     * community name and id.
     * @param _communityName Name of then community.
     * @param _proposalId Id of the proposal
     * @return Proposal info.
     */
    function getCommunityProposal(
        string calldata _communityName,
        uint256 _proposalId
    ) external view returns (Proposal memory) {
        return communityProposals[_communityName][_proposalId];
    }

    /**
     * Function that returns array of the proposals in some range.
     * @param _start Begin of the range.
     * @param _number Number of proposals to return.
     * @return Array of the proposals.
     */
    function getCommunityProposals(
        string calldata _communityName,
        uint256 _start,
        uint256 _number
    ) external view returns (Proposal[] memory) {
        uint256 endOfRange = _start + _number - 1;
        if (endOfRange > communityProposals[_communityName].length - 1) {
            revert WrongRange();
        }
        Proposal[] memory targetProposals = new Proposal[](_number);
        for (uint256 i = _start; i <= endOfRange; ) {
            targetProposals[i - _start] = communityProposals[_communityName][i];
            unchecked {
                ++i;
            }
        }
        return targetProposals;
    }

    function _vote(
        string calldata _communityName,
        uint256 _proposalId,
        address _voter,
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

    /// @inheritdoc IERC2771Recipient
    function _msgSender()
        internal
        view
        override(Context, ERC2771Recipient)
        returns (address ret)
    {
        if (msg.data.length >= 20 && isTrustedForwarder(msg.sender)) {
            // At this point we know that the sender is a trusted forwarder,
            // so we trust that the last bytes of msg.data are the verified sender address.
            // extract sender address from the end of msg.data
            assembly {
                ret := shr(96, calldataload(sub(calldatasize(), 20)))
            }
        } else {
            ret = msg.sender;
        }
    }

    /// @inheritdoc IERC2771Recipient
    function _msgData()
        internal
        view
        override(Context, ERC2771Recipient)
        returns (bytes calldata ret)
    {
        if (msg.data.length >= 20 && isTrustedForwarder(msg.sender)) {
            return msg.data[0:msg.data.length - 20];
        } else {
            return msg.data;
        }
    }
}
