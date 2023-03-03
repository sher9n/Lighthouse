// SPDX-License-Identifier: MIT
pragma solidity ^0.8.13;

import "@openzeppelin/token/ERC1155/ERC1155.sol";
import "@openzeppelin/access/Ownable.sol";

/** 
    It saves bytecode to revert on custom errors instead of using require
	statements.
*/
error NotAnAuthority();
error CertificateIdAlreadyExists();
error CertificateIdNotExists();
error NotAnAutohorityNorEducator();
error WalletAlreadyAssociatedWithDID();
error WalletNotAssociatedWithDID();
error NotAccessedToChangeAddress();
error NonTransferableToken();
error InvalidAddress();
error AuthorityHasBeenRevoked();
error AccessDenied();
error StudentAlreadyHaveCertificate();

/**
 * @title The Lighthouse Certificates contract.
 * @author Mikhail Rozalenok
 * @notice The Lighthouse contract provide You a possibility to have union wallet with all
 * Yours education/training/whatever certificates that are non transferable and standartized. All
 * organization and students are verified members of community and represents not only by wallet address,
 * but also by DID(Decentralized Identifier, https://www.w3.org/TR/did-core/).
 */
contract LighthouseCertificate is ERC1155, Ownable {
    ///////////////////////////////////////////////////////////////
    //  STORAGE
    ///////////////////////////////////////////////////////////////

    /// mapping to store DIDs that have Authority role.
    mapping(string => bool) public authorityDids;
    /// Mapping for associates DID to actual wallet address.
    mapping(string => address) public didToAddress;
    /// mapping that associates wallet address and DID;
    mapping(address => string) public usersDids;
    /// DID of educator -> DID of authority -> true/false
    mapping(string => mapping(string => bool)) educatorOf;
    /// CertificateId that belongs to particular authority DID that registered it.
    mapping(uint256 => string) public certificateIdToAuthority;
    /// Mapping that stores User's DID to array that contains all certificateIds that belongs to him.
    mapping(string => uint256[]) public usersCertificates;
    /// Mapping that contain information about user's certificates if they are retrieved.
    mapping(string => mapping(uint256 => bool)) public IsCertificateRetrieved;

    ///////////////////////////////////////////////////////////////
    //  EVENTS
    ///////////////////////////////////////////////////////////////

    /**
     * This event emitted when user has associated wallet with DID.
     * @param did DID of user that registered.
     * @param wallet Wallet address of user that registered.
     */
    event UserRegistred(string indexed did, address indexed wallet);

    /**
     * This event emitted when wallet addres has been changed for particular DID.
     * @param did DID of the user whose wallet address was changed.
     * @param oldWallet Old wallet address that was associated with given DID.
     * @param newWallet New wallet address that associated to the given DID.
     */
    event WalletForDidChanged(
        string indexed did,
        address indexed oldWallet,
        address indexed newWallet
    );

    /**
     * This event emitted when Authority registered new certificate.
     * @param organizationDid DID of the Authority that registered certificate.
     * @param certificateId Id of certificate that was registered.
     */
    event CertificateRegistred(
        string indexed organizationDid,
        uint256 indexed certificateId
    );

    /**
     * This event emitted when certificate has been minted.
     * @param issuerDid DID of the issuer of certificate.
     * @param certificateId Id of certificate that was issued.
     * @param studentDid DID of the student(receiver  of certificate).
     */
    event CetificateIssued(
        string indexed issuerDid,
        uint256 indexed certificateId,
        string indexed studentDid
    );

    /**
     * This event emitted when certificate has been minted.
     * @param issuerDid DID of the issuer of certificate.
     * @param certificateIds Ids of certificates that was issued.
     * @param studentDid DID of the student(receiver  of certificate).
     */
    event BatchOfCetificatesIssued(
        string indexed issuerDid,
        uint256[] indexed certificateIds,
        string indexed studentDid
    );

    /**
     * This event emitted when Authority role has been granted.
     * @param did DID of the new Authority.
     */
    event AuthorityGranted(string indexed did);

    /**
     * This event emitted when Authority role has been revoked.
     * @param did DID of the Authority that has been revoked.
     */
    event AuthorityRevoked(string indexed did);

    /**
     * This event emitted when Educator role has been granted.
     * @param educatorDid DID of the new Educator.
     * @param authorityDid DID of the Authority that granted the role.
     */
    event EducatorGranted(
        string indexed educatorDid,
        string indexed authorityDid
    );

    /**
     * This event emitted when Educator role has been revoked.
     * @param educatorDid DID of the Educator that has been revoked.
     * @param authorityDid DID of the Authority that revoked the role.
     */
    event EducatorRevoked(
        string indexed educatorDid,
        string indexed authorityDid
    );

    /**
     * This event emitted when status of retrieve for certficate id of particular user
     * has been changed.
     * @param _studentDid DID of the student, certificates status of whose has been changed.
     * @param _certificateId Id of the certificate whose status was changed.
     * @param _status The new status of a particular user's certificate.
     */
    event CertficateStatusChanged(
        string indexed _studentDid,
        uint256 indexed _certificateId,
        bool _status
    );

    /**
     * This event emitted when status of retrieve for certficate id of particular user
     * has been changed.
     * @param _studentDid DID of the student, certificates status of whose has been changed.
     * @param _certificateIds Ids of the certificates which status was changed.
     * @param _status The new status of a particular user's certificate.
     */
    event BatchOfCertficatesStatusChanged(
        string indexed _studentDid,
        uint256[] indexed _certificateIds,
        bool _status
    );

    ///////////////////////////////////////////////////////////////
    //  LOGIC
    ///////////////////////////////////////////////////////////////

    /**
     * Function that executes on contract deployment.
     * @param _uri URI of ERC1155 collection.
     */
    constructor(string memory _uri) ERC1155(_uri) {}

    /**
     * Overrided function of safe transfer with revert on any execution, because of token
     * non-transferable.
     */
    function safeTransferFrom(
        address, /*from*/
        address, /*to*/
        uint256, /*id*/
        uint256, /*amount*/
        bytes memory /*data*/
    ) public virtual override {
        revert NonTransferableToken();
    }

    /**
     * Overrided function of safe transfer from with revert on any execution, because of token
     * non-transferable.
     */
    function safeBatchTransferFrom(
        address, /*from*/
        address, /*to*/
        uint256[] memory, /*ids*/
        uint256[] memory, /*amounts*/
        bytes memory /*data*/
    ) public virtual override {
        revert NonTransferableToken();
    }

    /**
     * Function that provides user Authority role by user's DID.
     * Only callable by admin of contract.
     * @param _did DID of user that becomes Authority.
     * @param _wallet If DID wasn't registered on contract, then it will register and
     * associate with provided _wallet.
     */
    function setAuthority(string calldata _did, address _wallet)
        external
        onlyOwner
    {
        // register Authority DID if needed.
        if (didToAddress[_did] == address(0)) {
            _registerDid(_did, _wallet);
        }
        authorityDids[_did] = true;
        emit AuthorityGranted(_did);
    }

    /**
     * Function that revokes user's Authority role by user's DID.
     * Only callable by admin of contract.
     * @param _authorityDid DID of the user whose role is being revoked.
     */
    function revokeAuthority(string calldata _authorityDid) external onlyOwner {
        authorityDids[_authorityDid] = false;
        emit AuthorityRevoked(_authorityDid);
    }

    /**
     * Function that provides to user Educator role of msg.sender's organisation.
     * Only callable by Authorities.
     * @param _educatorDid DID of user that becomes Educator.
     * @param _wallet If DID wasn't registered on contract, then it will register and
     * associate with provided _wallet.
     */
    function setEducator(string calldata _educatorDid, address _wallet)
        external
    {
        string memory organisationDid = usersDids[msg.sender];
        if (!authorityDids[organisationDid]) {
            revert NotAnAuthority();
        }
        // register Educator DID if needed.
        if (didToAddress[_educatorDid] == address(0)) {
            _registerDid(_educatorDid, _wallet);
        }

        educatorOf[_educatorDid][organisationDid] = true;

        emit EducatorGranted(_educatorDid, organisationDid);
    }

    /**
     * Function that revokes user's Educator role of msg.sender's organization by user's DID.
     * Only callable by Authorities.
     * @param _educatorDid DID of the user whose Educator role is being revoked for
     * msg.sender's organisation.
     */
    function revokeEducator(string calldata _educatorDid) external {
        string memory organisationDid = usersDids[msg.sender];
        if (!authorityDids[organisationDid]) {
            revert NotAnAuthority();
        }
        educatorOf[_educatorDid][organisationDid] = false;

        emit EducatorRevoked(_educatorDid, organisationDid);
    }

    /**
     * Function that registers DID and assocciates to wallet address on this contract.
     * Only callable by admin of contract and Authorities.
     * @param _did DID of user that being registered.
     * @param _wallet Wallet address that will be associated to DID.
     */
    function registerDid(string calldata _did, address _wallet) public {
        if (owner() != msg.sender && !authorityDids[usersDids[msg.sender]]) {
            revert AccessDenied();
        }
        if (didToAddress[_did] != address(0)) {
            revert WalletAlreadyAssociatedWithDID();
        }
        _registerDid(_did, _wallet);
    }

    /**
     * Function that change wallet address for given DID and transfers all certificates to new
     * address. Any user can change theirselves wallet if needed. Also admin of contract have permission
     * to change wallet for any user's DIDs.
     * @param _did DID of user whose address changes.
     * @param _newAddress New wallet address for given user's DID.
     */
    function changeAddressForDid(string calldata _did, address _newAddress)
        external
    {
        address _oldAddress = didToAddress[_did];
        if (_oldAddress == address(0)) {
            revert WalletNotAssociatedWithDID();
        }
        if (bytes(usersDids[_newAddress]).length != 0) {
            revert WalletAlreadyAssociatedWithDID();
        }
        string memory userDid = usersDids[msg.sender];
        if (owner() != msg.sender) {
            if (_oldAddress != msg.sender) {
                revert NotAccessedToChangeAddress();
            }
        }
        didToAddress[userDid] = _newAddress;
        delete usersDids[_oldAddress];
        uint256 numberOfCertificates = usersCertificates[_did].length;
        uint256[] memory amountsArray = new uint256[](numberOfCertificates);
        for (uint256 i = 0; i < numberOfCertificates; ) {
            amountsArray[i] = 1;
            unchecked {
                ++i;
            }
        }
        _safeBatchTransferFrom(
            _oldAddress,
            _newAddress,
            usersCertificates[_did],
            amountsArray,
            ""
        );
        emit WalletForDidChanged(userDid, msg.sender, _newAddress);
    }

    /**
     * Function that registers certificate id and associates with Authority DID.
     * Only callable by Authority.
     * @param _certificateId Id of certificate that being registered.
     */
    function registerCertificate(uint256 _certificateId) external {
        string memory organizationDid = usersDids[msg.sender];
        if (!authorityDids[organizationDid]) {
            revert NotAnAuthority();
        }
        if (bytes(certificateIdToAuthority[_certificateId]).length != 0) {
            revert CertificateIdAlreadyExists();
        }
        certificateIdToAuthority[_certificateId] = organizationDid;
        emit CertificateRegistred(organizationDid, _certificateId);
    }

    /**
     * Function that mints single certificate to user by his DID. DID of student
     * must be registered on contract.
     * One user can obtain only 1 instance of particular certificate Id.
     * Authorities and Educators can only mint certificates that relate to their organizations.
     * Only callable, by Authority and Educators that are associated with them.
     * @param _studentDid DID of student that will receive certificate.
     * @param _certificateId The ID of the certificate being minted.
     */
    function mintCertificate(
        string calldata _studentDid,
        uint256 _certificateId
    ) external {
        address studentAddress = didToAddress[_studentDid];
        if (studentAddress == address(0)) {
            revert WalletNotAssociatedWithDID();
        }
        string memory issuerDid = usersDids[msg.sender];
        _mintHelper(_studentDid, _certificateId, issuerDid, studentAddress);
        _mint(studentAddress, _certificateId, 1, "");
        emit CetificateIssued(issuerDid, _certificateId, _studentDid);
    }

    /**
     * Function that mints batch of certificates to user by his DID. DID must be registered on contract.
     * One user can obtain only 1 instance of particular certificate Id.
     * Only callable, by Authority and Educators that are associated with it.
     * @param _studentDid DID of student that will receive certificates.
     * @param _certificateIds The IDs of the certificates being minted.
     */
    function mintBatchCertificates(
        string calldata _studentDid,
        uint256[] calldata _certificateIds
    ) external {
        address studentAddress = didToAddress[_studentDid];
        if (studentAddress == address(0)) {
            revert WalletNotAssociatedWithDID();
        }
        string memory issuerDid = usersDids[msg.sender];
        uint256[] memory amounts = new uint256[](_certificateIds.length);
        for (uint256 i = 0; i < _certificateIds.length; ) {
            _mintHelper(
                _studentDid,
                _certificateIds[i],
                issuerDid,
                studentAddress
            );
            amounts[i] = 1;
            unchecked {
                ++i;
            }
        }
        _mintBatch(studentAddress, _certificateIds, amounts, "");
        emit BatchOfCetificatesIssued(issuerDid, _certificateIds, _studentDid);
    }

    /**
     * Function that allows Admin and Authorities to mark single particullar student's certificateId
     * as retrieved(invalid) or revert this changes.
     * @param _studentDid The DID of the student whose certificate status is being changed.
     * @param _certificateId Id of the certificate which status is being changed.
     * @param _newStatus Status that being set.
     */
    function changeValidStatusForCertificate(
        string calldata _studentDid,
        uint256 _certificateId,
        bool _newStatus
    ) external {
        if (owner() != msg.sender) {
            if (
                !_strCompare(
                    certificateIdToAuthority[_certificateId],
                    usersDids[msg.sender]
                )
            ) {
                revert AccessDenied();
            }
        }
        _changeValidStatusForCertificate(
            _studentDid,
            _certificateId,
            _newStatus
        );
        emit CertficateStatusChanged(_studentDid, _certificateId, _newStatus);
    }

    /**
     * Function that allows Admin and Authorities to mark batch particullar student's certificateIds
     * as retrieved(invalid) or revert this changes.
     * @param _studentDid The DID of the student whose certificates statuses are being changed.
     * @param _certificateIds Ids of the certificates which statuses is being changed.
     * @param _newStatus Status that being set.
     */
    function changeValidStatusForBatchOfCertificates(
        string calldata _studentDid,
        uint256[] memory _certificateIds,
        bool _newStatus
    ) external {
        if (owner() != msg.sender) {
            for (uint256 i = 0; i < _certificateIds.length; ) {
                if (
                    !_strCompare(
                        certificateIdToAuthority[_certificateIds[i]],
                        usersDids[msg.sender]
                    )
                ) {
                    revert AccessDenied();
                }
                unchecked {
                    ++i;
                }
            }
        }
        for (uint256 i = 0; i < _certificateIds.length; ) {
            _changeValidStatusForCertificate(
                _studentDid,
                _certificateIds[i],
                _newStatus
            );
            unchecked {
                ++i;
            }
        }
        emit BatchOfCertficatesStatusChanged(
            _studentDid,
            _certificateIds,
            _newStatus
        );
    }

    /**
     * View function that returns information if particular Educator's DID is associated with
     * given _authorityDid.
     * @param _educatorDid DID of Educator.
     * @param _authorityDid DID of Authority.
     */
    function isEducatorOf(
        string calldata _educatorDid,
        string calldata _authorityDid
    ) external view returns (bool result) {
        if (
            educatorOf[_educatorDid][_authorityDid] &&
            authorityDids[_authorityDid]
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Helper function that mints certificate and checks all the requirements.
     * @param _studentDid DID of student that will receive certificate.
     * @param _certificateId The ID of the certificates being minted.
     */
    function _mintHelper(
        string calldata _studentDid,
        uint256 _certificateId,
        string memory _issuerDid,
        address _studentAddress
    ) private {
        string memory authorityDid = certificateIdToAuthority[_certificateId];
        // Check if certificate id registered.
        if (bytes(authorityDid).length == 0) {
            revert CertificateIdNotExists();
        }
        // Check if Authority revoked.
        if (!authorityDids[authorityDid]) {
            revert AuthorityHasBeenRevoked();
        }
        address authorityAddress = didToAddress[authorityDid];
        if (msg.sender != authorityAddress) {
            if (!educatorOf[_issuerDid][authorityDid])
                revert NotAnAutohorityNorEducator();
        }
        if (balanceOf(_studentAddress, _certificateId) > 0) {
            revert StudentAlreadyHaveCertificate();
        }
        usersCertificates[_studentDid].push(_certificateId);
    }

    /**
     * Helper function that allows to mark single particullar student's certificateId
     * as retrieved(invalid) or revert this changes.
     * @param _studentDid The DID of the student whose certificates statuses are being changed.
     * @param _certificateId Ids of the certificates which statuses is being changed.
     * @param _newStatus Status that being set.
     */
    function _changeValidStatusForCertificate(
        string calldata _studentDid,
        uint256 _certificateId,
        bool _newStatus
    ) internal {
        IsCertificateRetrieved[_studentDid][_certificateId] = _newStatus;
    }

    /**
     * Helper function that regiters DID on contract and associates with give wallet.
     * @param _did DID that being registered.
     * @param _wallet Address that will be associate with given DID.
     */
    function _registerDid(string calldata _did, address _wallet) private {
        if (_wallet == address(0)) {
            revert InvalidAddress();
        }
        usersDids[_wallet] = _did;
        didToAddress[_did] = _wallet;
        emit UserRegistred(_did, _wallet);
    }

    /**
     * Helper function that compares 2 strings.
     * @param str1 First given string.
     * @param str2 Second given string.
     */
    function _strCompare(string memory str1, string memory str2)
        private
        pure
        returns (bool)
    {
        if (bytes(str1).length != bytes(str2).length) {
            return false;
        }
        return
            keccak256(abi.encodePacked(str1)) ==
            keccak256(abi.encodePacked(str2));
    }

    /**
     * @dev See {IERC165-supportsInterface}.
     */
    function supportsInterface(bytes4 interfaceId)
        public
        view
        virtual
        override(ERC1155)
        returns (bool)
    {
        return super.supportsInterface(interfaceId);
    }
}
