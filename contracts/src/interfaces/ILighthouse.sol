// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.10;

interface ILighthouse {
    event TokenWhitelistAdded(string indexed name, address _whitelisted);

    function addPointsTo(address receiver, uint256 amount) external;

    function addToTokenWhitelist(address _whitelisted) external;

    function factoryAddress() external view returns (address);

    function isAdmin(address) external view returns (bool);

    function makeAdmin(address _newAdmin) external;

    function name() external view returns (string memory);

    function pointsBalanceOf(address) external view returns (uint256);

    function slashPoints(address _from, uint256 _amount) external;

    function tokenAddress() external view returns (address);
}
