// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "forge-std/Test.sol";
import "../src/LighthouseCertificates.sol";

contract LighthouseCertificateTest is Test {
    address constant admin = address(0xad919);
    address constant authority = address(0xbabe);
    string constant authorityDid =
        "did:lighthousedao:123456789abcdefghi#key-aut1";
    address constant educator = address(0xb0b);
    string constant educatorDid =
        "did:lighthousedao:123456789abcdefghi#key-edu1";
    address constant student = address(0xfde4);
    string constant studentDid =
        "did:lighthousedao:123456789abcdefghi#key-stu1";
    address constant studentNewAddress = address(0xababa12);
    address constant authority2 = address(0xbabd);
    string constant authorityDid2 =
        "did:lighthousedao:123456789abcdefghi#key-aut2";
    LighthouseCertificate lighthouse;

    function setUp() public {
        vm.startPrank(admin);
        lighthouse = new LighthouseCertificate("");
        assertFalse(lighthouse.authorityDids(authorityDid));
        lighthouse.setAuthority(authorityDid, authority);
        vm.stopPrank();
    }

    function testSetAuthority() public {
        vm.startPrank(admin);
        assertFalse(lighthouse.authorityDids(authorityDid2));
        lighthouse.setAuthority(authorityDid2, authority2);
        assertTrue(lighthouse.authorityDids(authorityDid2));
        _assertDidAndAddress(authorityDid2, authority2);
    }

    function testSetEducator() public {
        vm.startPrank(authority);
        assertFalse(lighthouse.isEducatorOf(educatorDid, authorityDid));
        lighthouse.setEducator(educatorDid, educator);
        assertTrue(lighthouse.isEducatorOf(educatorDid, authorityDid));
        _assertDidAndAddress(educatorDid, educator);
    }

    function testSetEducatorWithAddressZero() public {
        vm.startPrank(authority);
        assertFalse(lighthouse.isEducatorOf(educatorDid, authorityDid));
        vm.expectRevert(bytes4(keccak256(bytes("InvalidAddress()"))));
        lighthouse.setEducator(educatorDid, address(0));
    }

    function testRevokeEducator() public {
        testSetEducator();
        assertTrue(lighthouse.isEducatorOf(educatorDid, authorityDid));
        lighthouse.revokeEducator(educatorDid);
        assertFalse(lighthouse.isEducatorOf(educatorDid, authorityDid));
    }

    function testRevokeEducatorByNonAuthority() public {
        testSetEducator();
        vm.stopPrank();
        vm.startPrank(authority2);
        assertTrue(lighthouse.isEducatorOf(educatorDid, authorityDid));
        vm.expectRevert(bytes4(keccak256(bytes("NotAnAuthority()"))));
        lighthouse.revokeEducator(educatorDid);
    }

    // setEducator not by authorirty
    function testSetEducatorByNonAuthority() public {
        vm.startPrank(student);
        assertFalse(lighthouse.isEducatorOf(educatorDid, studentDid));
        vm.expectRevert(bytes4(keccak256(bytes("NotAnAuthority()"))));
        lighthouse.setEducator(educatorDid, educator);
        assertFalse(lighthouse.isEducatorOf(educatorDid, authorityDid));
    }

    function testRevokeAuthority() public {
        vm.startPrank(admin);
        assertTrue(lighthouse.authorityDids(authorityDid));
        _assertDidAndAddress(authorityDid, authority);
        lighthouse.revokeAuthority(authorityDid);
        assertFalse(lighthouse.authorityDids(authorityDid));
        vm.stopPrank();
    }

    function testRegisterDidByNotAnAdmin() public {
        vm.startPrank(student);
        assertEq(lighthouse.didToAddress(studentDid), address(0));
        // No matter which address is provided in 2nd argument, if caller not an admin.
        vm.expectRevert(bytes4(keccak256(bytes("AccessDenied()"))));
        lighthouse.registerDid(studentDid, authority);
    }

    function testRegisterDidByAnAdmin() public {
        vm.startPrank(admin);
        assertEq(lighthouse.didToAddress(studentDid), address(0));
        // If admin is executing this function he can provide address to connect with DID.
        _registerDid(studentDid, student);
        _assertDidAndAddress(studentDid, student);
        vm.stopPrank();
    }

    function testRegisterAccountForAlreadyExistedUser() public {
        testRegisterDidByAnAdmin();
        vm.stopPrank();
        vm.startPrank(admin);
        assertEq(lighthouse.didToAddress(studentDid), student);
        // If admin is executing this function he can provide address to connect with DID.
        vm.expectRevert(
            bytes4(keccak256(bytes("WalletAlreadyAssociatedWithDID()")))
        );
        _registerDid(studentDid, student);
    }

    // setEducator by revoked authority
    function testSetEducatorDeprecated() public {
        testRevokeAuthority();
        vm.startPrank(authority);
        vm.expectRevert(bytes4(keccak256(bytes("NotAnAuthority()"))));
        lighthouse.setEducator(educatorDid, educator);
        assertFalse(lighthouse.isEducatorOf(educatorDid, authorityDid));
    }

    function testRegisterCertificate() public {
        vm.startPrank(authority);
        uint256 tokenId = 0;
        _registerCertificate(tokenId, authorityDid);
        vm.stopPrank();
    }

    function testRegisterCertificateByNonAuthority() public {
        vm.startPrank(student);
        uint256 tokenId = 0;
        assertFalse(lighthouse.authorityDids(studentDid));
        vm.expectRevert(bytes4(keccak256(bytes("NotAnAuthority()"))));
        lighthouse.registerCertificate(tokenId);
    }

    function testRegisterCertificateWithInvalidId() public {
        testRegisterCertificate();
        vm.startPrank(authority);
        uint256 tokenId = 0;
        vm.expectRevert(
            bytes4(keccak256(bytes("CertificateIdAlreadyExists()")))
        );
        lighthouse.registerCertificate(tokenId);
    }

    function testMintSingleCertificateByAuthority() public {
        testRegisterCertificate();
        vm.startPrank(admin);
        lighthouse.registerDid(studentDid, student);
        vm.stopPrank();
        vm.startPrank(authority);
        uint256 tokenId = 0;
        lighthouse.mintCertificate(studentDid, tokenId);
        assertEq(lighthouse.balanceOf(student, tokenId), 1);
    }

    function testMintSingleCertificateByAnEducator() public {
        testRegisterCertificate();
        vm.startPrank(admin);
        lighthouse.registerDid(studentDid, student);
        vm.stopPrank();
        testSetEducator();
        vm.stopPrank();
        vm.startPrank(educator);
        uint256 tokenId = 0;
        lighthouse.mintCertificate(studentDid, tokenId);
        assertEq(lighthouse.balanceOf(student, tokenId), 1);
        vm.stopPrank();
    }

    function testMintBatchCertificatesByAuthority() public {
        vm.startPrank(authority);
        uint256 numberOfCertificates = 5;
        vm.stopPrank();
        vm.startPrank(admin);
        lighthouse.registerDid(studentDid, student);
        vm.stopPrank();
        vm.startPrank(authority);
        _mintCertificates(numberOfCertificates, studentDid, authorityDid);
        for (uint256 i = 0; i < numberOfCertificates; i++) {
            assertEq(lighthouse.balanceOf(student, i), 1);
        }
    }

    function testMintBatchCertificatesByAuthorityThatUserHaveAlready() public {
        vm.startPrank(authority);
        uint256[] memory certificateIds = new uint256[](5);
        for (uint256 i = 0; i < 5; i++) {
            _registerCertificate(i, authorityDid);
            certificateIds[i] = i;
        }
        vm.stopPrank();
        vm.startPrank(admin);
        lighthouse.registerDid(studentDid, student);
        vm.stopPrank();
        vm.startPrank(authority);
        lighthouse.mintCertificate(studentDid, 0);
        vm.expectRevert(
            bytes4(keccak256(bytes("StudentAlreadyHaveCertificate()")))
        );
        lighthouse.mintBatchCertificates(studentDid, certificateIds);
    }

    function testMintCertificateIfBalanceGTZero() public {
        testMintSingleCertificateByAuthority();
        uint256 tokenId = 0;
        vm.expectRevert(
            bytes4(keccak256(bytes("StudentAlreadyHaveCertificate()")))
        );
        lighthouse.mintCertificate(studentDid, tokenId);
    }

    function testMintCertificateToUnregisteredDid() public {
        testMintSingleCertificateByAuthority();
        uint256 tokenId = 0;
        string memory corruptedDid = string.concat(studentDid, "1");
        vm.expectRevert(
            bytes4(keccak256(bytes("WalletNotAssociatedWithDID()")))
        );
        lighthouse.mintCertificate(corruptedDid, tokenId);
    }

    function testMintBatchCertificateToUnregisteredDid() public {
        testMintBatchCertificatesByAuthority();
        uint256[] memory certificateIds = new uint256[](5);
        for (uint256 i = 0; i < 5; i++) {
            certificateIds[i] = i;
        }
        string memory corruptedDid = string.concat(studentDid, "1");
        vm.expectRevert(
            bytes4(keccak256(bytes("WalletNotAssociatedWithDID()")))
        );
        lighthouse.mintBatchCertificates(corruptedDid, certificateIds);
    }

    function testMintByNonAuthorityNorEducator() public {
        testRegisterCertificate();
        testRegisterDidByAnAdmin();
        vm.startPrank(authority2);
        uint256 tokenId = 0;
        vm.expectRevert(
            bytes4(keccak256(bytes("NotAnAutohorityNorEducator()")))
        );
        lighthouse.mintCertificate(studentDid, tokenId);
    }

    function testMintCertificateOfRevokedAuthority() public {
        testRegisterCertificate();
        testRevokeAuthority();
        vm.stopPrank();
        vm.startPrank(admin);
        lighthouse.registerDid(studentDid, student);
        vm.stopPrank();
        vm.startPrank(authority);
        uint256 tokenId = 0;
        vm.expectRevert(bytes4(keccak256(bytes("AuthorityHasBeenRevoked()"))));
        lighthouse.mintCertificate(studentDid, tokenId);
    }

    function testMintCertificateWithInvalidId() public {
        testRegisterCertificate();
        vm.startPrank(admin);
        lighthouse.registerDid(studentDid, student);
        vm.stopPrank();
        vm.startPrank(authority);
        uint256 tokenId = 0;
        uint256 corruptedTokenId = tokenId + 1;
        lighthouse.mintCertificate(studentDid, tokenId);
        vm.expectRevert(bytes4(keccak256(bytes("CertificateIdNotExists()"))));
        lighthouse.mintCertificate(studentDid, corruptedTokenId);
    }

    function testSingleTransferCertificates() public {
        testMintSingleCertificateByAnEducator();
        vm.expectRevert(bytes4(keccak256(bytes("NonTransferableToken()"))));
        lighthouse.safeTransferFrom(student, authority, 0, 1, "");
    }

    function testBatchTransferCertificates() public {
        testMintSingleCertificateByAnEducator();
        uint256[] memory ids = new uint256[](1);
        uint256[] memory amounts = new uint256[](1);
        ids[0] = 0;
        amounts[0] = 1;
        vm.expectRevert(bytes4(keccak256(bytes("NonTransferableToken()"))));
        lighthouse.safeBatchTransferFrom(student, authority, ids, amounts, "");
    }

    function testRetrieveSingleCertificate() public {
        testMintBatchCertificatesByAuthority();
        vm.stopPrank();
        vm.startPrank(authority);
        uint256 burnedToken = 4;
        assertEq(
            lighthouse.IsCertificateRetrieved(studentDid, burnedToken),
            false
        );
        lighthouse.changeValidStatusForCertificate(
            studentDid,
            burnedToken,
            true
        );
        assertEq(
            lighthouse.IsCertificateRetrieved(studentDid, burnedToken),
            true
        );
        vm.stopPrank();
    }

    function testRetrieveSingleCertificateWithoutPermissions() public {
        testMintBatchCertificatesByAuthority();
        vm.stopPrank();
        vm.startPrank(authority2);
        uint256 burnedToken = 4;
        assertEq(
            lighthouse.IsCertificateRetrieved(studentDid, burnedToken),
            false
        );
        vm.expectRevert(bytes4(keccak256(bytes("AccessDenied()"))));
        lighthouse.changeValidStatusForCertificate(
            studentDid,
            burnedToken,
            true
        );
        vm.stopPrank();
    }

    function testRetrieveBatchCertificates() public {
        testMintBatchCertificatesByAuthority();
        vm.stopPrank();
        vm.startPrank(authority);
        uint256[] memory certificateIds = new uint256[](5);
        uint256[] memory amounts = new uint256[](5);
        for (uint256 i = 0; i < 5; i++) {
            certificateIds[i] = i;
            amounts[i] = 1;
        }
        lighthouse.changeValidStatusForBatchOfCertificates(
            studentDid,
            certificateIds,
            true
        );
        for (uint256 i = 0; i < 5; i++) {
            assertEq(
                lighthouse.IsCertificateRetrieved(
                    studentDid,
                    certificateIds[i]
                ),
                true
            );
        }
        vm.stopPrank();
    }

    function testBurnBatchCertificatesPartOfWhichNotBelongsToYou() public {
        vm.stopPrank();
        testSetAuthority();
        vm.stopPrank();
        vm.startPrank(admin);
        lighthouse.registerDid(studentDid, student);
        vm.stopPrank();
        uint256 numberOfCertificates = 3;
        vm.startPrank(authority);
        _mintCertificates(numberOfCertificates, studentDid, authorityDid);
        uint256[] memory certificateIds = new uint256[](
            numberOfCertificates + 1
        );
        uint256[] memory amounts = new uint256[](numberOfCertificates + 1);
        for (uint256 i = 0; i < numberOfCertificates + 1; i++) {
            certificateIds[i] = i;
            amounts[i] = 1;
        }
        vm.expectRevert(bytes4(keccak256(bytes("AccessDenied()"))));
        lighthouse.changeValidStatusForBatchOfCertificates(
            studentDid,
            certificateIds,
            true
        );
    }

    function testBurnBatchCertificatesByAdmin() public {
        testMintBatchCertificatesByAuthority();
        vm.stopPrank();
        vm.startPrank(admin);
        uint256[] memory certificateIds = new uint256[](5);
        uint256[] memory amounts = new uint256[](5);
        for (uint256 i = 0; i < 5; i++) {
            certificateIds[i] = i;
            amounts[i] = 1;
        }
        lighthouse.changeValidStatusForBatchOfCertificates(
            studentDid,
            certificateIds,
            true
        );
        for (uint256 i = 0; i < 5; i++) {
            assertEq(
                lighthouse.IsCertificateRetrieved(
                    studentDid,
                    certificateIds[i]
                ),
                true
            );
        }
        vm.stopPrank();
    }

    function testChangeWalletAddressToDid() public {
        testSetAuthority();

        vm.stopPrank();
        vm.startPrank(admin);
        _registerDid(studentDid, student);
        vm.stopPrank();
        vm.startPrank(authority);
        _mintCertificates(3, studentDid, authorityDid);
        vm.stopPrank();
        vm.startPrank(authority2);
        uint256[] memory certificateIds = new uint256[](2);
        for (uint256 i = 0; i < 2; i++) {
            _registerCertificate(i + 3, authorityDid2);
            certificateIds[i] = i + 3;
        }
        lighthouse.mintBatchCertificates(studentDid, certificateIds);

        for (uint256 i = 0; i < 5; i++) {
            assertEq(lighthouse.balanceOf(student, i), 1);
        }
        vm.stopPrank();
        vm.startPrank(student);
        lighthouse.changeAddressForDid(studentDid, studentNewAddress);
        for (uint256 i = 0; i < 5; i++) {
            assertEq(lighthouse.balanceOf(student, i), 0);
            assertEq(lighthouse.balanceOf(studentNewAddress, i), 1);
        }
    }

    function testChangeWalletAddressToDidButAddressAlreadyBusy() public {
        vm.startPrank(admin);
        _registerDid(studentDid, student);
        vm.expectRevert(
            bytes4(keccak256(bytes("WalletAlreadyAssociatedWithDID()")))
        );
        lighthouse.changeAddressForDid(studentDid, authority);
    }

    function testChangeWalletAddressToDidWithoutPermissions() public {
        vm.startPrank(student);
        vm.expectRevert(
            bytes4(keccak256(bytes("NotAccessedToChangeAddress()")))
        );
        lighthouse.changeAddressForDid(authorityDid, studentNewAddress);
    }

    function testChangeWalletAddressToDidForNonExistingDid() public {
        vm.startPrank(student);
        vm.expectRevert(
            bytes4(keccak256(bytes("WalletNotAssociatedWithDID()")))
        );
        lighthouse.changeAddressForDid(studentDid, studentNewAddress);
    }

    function testSupportsInterface() public {
        assertTrue(lighthouse.supportsInterface(0xd9b67a26));
    }

    function _mintCertificates(
        uint256 numberOfCertificates,
        string memory did,
        string memory _authorityDid
    ) internal {
        uint256[] memory certificateIds = new uint256[](numberOfCertificates);
        for (uint256 i = 0; i < numberOfCertificates; i++) {
            _registerCertificate(i, _authorityDid);
            certificateIds[i] = i;
        }
        lighthouse.mintBatchCertificates(did, certificateIds);
    }

    function _registerCertificate(
        uint256 _certificateId,
        string memory _authorityDid
    ) internal {
        assertTrue(lighthouse.authorityDids(_authorityDid));
        lighthouse.registerCertificate(_certificateId);
        assertEq(
            lighthouse.certificateIdToAuthority(_certificateId),
            _authorityDid
        );
    }

    function _assertDidAndAddress(string memory _did, address _address)
        internal
    {
        assertEq(lighthouse.usersDids(_address), _did);
        assertEq(lighthouse.didToAddress(_did), _address);
    }

    function _registerDid(string memory userDid, address userAddress) internal {
        lighthouse.registerDid(userDid, userAddress);
    }
}
