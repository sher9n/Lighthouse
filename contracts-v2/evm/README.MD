# Lighthouse Certificates

- Contract has developed based on this spec: https://docs.google.com/document/d/1RQdK28cb0voI3M5Ff_kgiYp3dc1NpbNRPRIHVbLAUU4/
- Fully covered with tests.
- Deployed and verified at Mumbai testnet: https://mumbai.polygonscan.com/address/0x7e8862D4836D6a4654043B2b7d97b439E1273bBc

# Abstract

Lighthouse certificates is decentralized way to store information about Your's achievements such a education/training/sport certificates or any others.

# Functions

## setAuthority()

```
setAuthority(string calldata _did, address _wallet)
```

Function that sets Authority, callable only by admin of contract. Automatically registers `_did` if it hadn't yet, and associates it with given `_wallet`, emits `UserRegistred()` event it this case.
Note: doesn't change wallet address for `_did` if it already registred
Emits event:

```
event AuthorityGranted(string indexed did);
```

## revokeAuthority()

```
revokeAuthority(string calldata _authorityDid)
```

Function that revokes user's Authority role by user's DID.
Only callable by admin of contract.
Emits event:

```
event AuthorityRevoked(string indexed did);
```

## setEducator()

```
setEducator(string calldata _educatorDid, address _wallet)
```

Function that provides to user Educator role of msg.sender's organisation.
Only callable by Authorities.
Automatically registers `_did` if it hadn't yet, and associates it with given `_wallet`, emits `UserRegistred()` event it this case.
Note: doesn't change wallet address for `_did` if it already registred.
Emits event:

```
event EducatorGranted(
    string indexed educatorDid,
    string indexed authorityDid
);
```

## revokeEducator()

```
revokeEducator(string calldata _educatorDid)
```

Function that revokes user's Educator role of msg.sender's organization by user's DID.
Only callable by Authorities.
Emits event:

```
event EducatorRevoked(
    string indexed educatorDid,
    string indexed authorityDid
);
```

## registerDid()

```
registerDid(string calldata _did, address _wallet)
```

Function that registers DID and assocciates it with wallet address on this contract.
Only callable by admin of contract or Authorities.
Emits event:

```
event UserRegistred(
    string indexed did,
    address indexed wallet
);
```

## changeAddressForDid()

```
changeAddressForDid(string calldata _did, address _newAddress)
```

Function that change wallet address for given DID and transfers all certificates to new address. Any user can change theirselves wallet if needed. Also admin of contract have permission to change wallet for any user's DIDs.
Emits event:

```
event WalletForDidChanged(
    string indexed did,
    address indexed oldWallet,
    address indexed newWallet
);
```

## registerCertificate()

```
registerCertificate(uint256 _certificateId)
```

Function that registers certificate id and associates with Authority DID.
Only callable by Authority.
Emits event:

```
event CertificateRegistred (
    string indexed organizationDid,
    uint256 indexed certificateId
);
```

## mintCertificate()

```
mintCertificate(string calldata _studentDid, uint256 _certificateId)
```

Function that mints single certificate to user by his DID. DID of student must be registered on contract. One user can obtain only 1 instance of particular certificate Id. Authorities and Educators can only mint certificates that relate to their organizations.
Only callable, by Authorities and Educators.
Emits event:

```
event CetificateIssued(
    string indexed issuerDid,
    uint256 indexed certificateId,
    string indexed studentDid
);
```

Also emits standard ERC1155 `TransferSingle()` event.

## mintBatchCertificates()

```
mintBatchCertificates(string calldata _studentDid, uint256[] calldata _certificateIds)
```

Function that mints batch of certificates to user by his DID. DID of student must be registered on contract. One user can obtain only 1 instance of particular certificate Id. Authorities and Educators can only mint certificates that relate to their organizations.
Only callable, by Authorities and Educators.
Emits event:

```
event BatchOfCetificatesIssued(
    string indexed issuerDid,
    uint256[] indexed certificateIds,
    string indexed studentDid
);
```

Also emits standard ERC1155 `TransferBatch()` event.

## changeValidStatusForCertificate()

```
changeValidStatusForCertificate(string calldata _studentDid, uint256 _certificateId, bool _newStatus)
```

Function that allows Admin and Authorities to mark single particullar student's certificateId as retrieved(invalid) or revert this changes.
Emits event:

```
event CertficateStatusChanged(
    string indexed _studentDid,
    uint256 indexed _certificateId,
    bool _status
);
```

## changeValidStatusForBatchOfCertificates()

```
changeValidStatusForBatchOfCertificates(string calldata _studentDid, uint256[] memory _certificateIds, bool _newStatus)
```

Function that allows Admin and Authorities to mark batch particullar student's certificateIds as retrieved(invalid) or revert this changes.
Emits event:

```
event BatchOfCertficatesStatusChanged(
    string indexed _studentDid,
    uint256 indexed _certificateId,
    bool _status
);
```

## isEducatorOf()

```
isEducatorOf(string calldata _educatorDid, string calldata _authorityDid) return(bool)
```

View function that returns information if particular Educator's DID is associated with given \_authorityDid.
