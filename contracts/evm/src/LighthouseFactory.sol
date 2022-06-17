// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "./Lighthouse.sol";

contract LighthouseFactory {
    address public owner;
    mapping(string => address) public nameToAddress;
    mapping(address => address) public gasTankOf;

    event LighthouseCreated(string name, address addr);
    event AdminAdded(address indexed targetAddress, address indexed admin);
    event PointsAdded(
        address indexed targetAddress,
        address indexed receiver,
        uint256 points
    );
    event PointsSlashed(
        address indexed targetAddress,
        address indexed receiver,
        uint256 points
    );

    event SolPointsAdded(string tokenAddress, string receiver, uint256 points);
    event LighthouseLog(
        uint256 indexed timestamp,
        string indexed communityIndexed,
        string community,
        string message
    );

    modifier onlyAuth(address targetAddress) {
        require(
            Lighthouse(targetAddress).isAdmin(msg.sender) ||
                msg.sender == gasTankOf[targetAddress],
            "UNAUTHORIZED"
        );
        _;
    }

    modifier onlyOwner() {
        require(msg.sender == owner, "ONLY OWNER");
        _;
    }

    constructor(address _owner) {
        owner = _owner;
    }

    function setOwner(address newOwner) public onlyOwner {
        owner = newOwner;
    }

    function setGasTank(address newGasTank, address targetAddress) public {
        require(msg.sender == gasTankOf[targetAddress], "ONLY GASTANK");
        gasTankOf[targetAddress] = newGasTank;
    }

    function createLighthouse(
        address initialAdmin,
        address gasTank,
        string calldata name,
        string calldata tokenName,
        string calldata tokenSymbol,
        uint8 tokenDecimals
    ) public returns (address) {
        require(nameToAddress[name] == address(0), "NAME TAKEN");
        Lighthouse newLighthouse = new Lighthouse(
            initialAdmin,
            name,
            tokenName,
            tokenSymbol,
            tokenDecimals
        );

        address newAddress = address(newLighthouse);
        nameToAddress[name] = newAddress;
        gasTankOf[newAddress] = gasTank;

        emit LighthouseCreated(name, newAddress);
        emit AdminAdded(newAddress, initialAdmin);
        return newAddress;
    }

    function addPointsTo(
        address receiver,
        uint256 amount,
        address targetAddress
    ) public onlyAuth(targetAddress) {
        Lighthouse(targetAddress).addPointsTo(receiver, amount);
        emit PointsAdded(targetAddress, receiver, amount);
    }

    function slashPoints(
        address from,
        uint256 amount,
        address targetAddress
    ) public onlyAuth(targetAddress) {
        Lighthouse(targetAddress).slashPoints(from, amount);
        emit PointsSlashed(targetAddress, from, amount);
    }

    function makeAdmin(address newAdmin, address targetAddress)
        public
        onlyAuth(targetAddress)
    {
        Lighthouse(targetAddress).makeAdmin(newAdmin);

        emit AdminAdded(targetAddress, newAdmin);
    }

    function addToTokenWhitelist(address whitelisted, address targetAddress)
        public
        onlyAuth(targetAddress)
    {
        Lighthouse(targetAddress).addToTokenWhitelist(whitelisted);
    }

    function addSolPointsTo(
        string calldata tokenAddress,
        string calldata receiver,
        uint256 amount
    ) public onlyOwner {
        emit SolPointsAdded(tokenAddress, receiver, amount);
    }

    function logMsg(
        uint256 timestamp,
        string calldata community,
        string calldata message
    ) public onlyOwner {
        emit LighthouseLog(timestamp, community, community, message);
    }
}
