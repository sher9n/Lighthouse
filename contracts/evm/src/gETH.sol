//SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.13;

import "@openzeppelin/token/ERC20/ERC20.sol";
import "@openzeppelin/access/Ownable.sol";

contract gETH is ERC20, Ownable {
    constructor(string memory name, string memory symbol) ERC20(name, symbol) {}

    function mint(address _account, uint256 _amount) external onlyOwner {
        _mint(_account, _amount);
    }

    function burn(address _account, uint256 _amount) external onlyOwner {
        _burn(_account, _amount);
    }
}
