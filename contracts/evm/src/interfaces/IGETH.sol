// SPDX-License-Identifier: GPL-3.0

pragma solidity 0.8.13;

import "@openzeppelin/token/ERC20/IERC20.sol";

interface IGETH is IERC20 {
    function mint(address _account, uint256 _amount) external;

    function burn(address _account, uint256 _amount) external;
}
