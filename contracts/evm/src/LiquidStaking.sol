// SPDX-License-Identifier: MIT
pragma solidity ^0.8.13;

import "@openzeppelin/access/Ownable.sol";
import "@opengsn/packages/contracts/src/ERC2771Recipient.sol";
import "./interfaces/ILido.sol";
import "./interfaces/IGETH.sol";
import "./gETH.sol";

error TransferFailed();

/** 
    @title The Lighthouse contract
    @author SusheendharVijay
    @author Mikhail Rozalenok
    @notice The Lighthouse contract is used to manage logic for all Lighthouse communities.
*/
contract LiquidStaking is Ownable, ERC2771Recipient {
    address immutable lido;
    gETH immutable token;
    address lighthouseTreasure;

    // User's rewards that slashed by fee distribution.
    uint256 usersRewards;
    uint256 treasuryRewards;
    uint256 feePercent = 10000; // eq to 10%

    mapping(address => uint256) share;
    uint256 totalStaked;
    uint256 totalPooledEth;
    uint256 tps;
    uint256 lastStETHBalanceOfContract;

    // Struct for contain info about staker.
    struct Staker {
        uint256 rewardMissed;
        uint256 rewardGained;
        uint256 rewardClaimed;
    }

    // address of staker => object of info about staker.
    mapping(address => Staker) usersStakes;

    event Staked(address indexed depositor, uint256 indexed amount);

    event Claimed(address indexed to, uint256 indexed claimAmount);

    constructor(address _lido, address _trustedForwarder) {
        _setTrustedForwarder(_trustedForwarder);
        token = new gETH("gETH", "gETH");
        lido = _lido;
    }

    // TODO: May be we should remove refferal as an option.
    function stake(address refferal) external payable {
        _updateTps();
        ILido(lido).submit{value: msg.value}(refferal);
        totalPooledEth += msg.value;
        token.mint(msg.sender, msg.value);
        usersStakes[msg.sender].rewardMissed += (msg.value * tps);

        emit Staked(msg.sender, msg.value);
    }

    function claim() external {
        _updateTps();

        uint256 claimAmount = (token.balanceOf(msg.sender) * tps) -
            usersStakes[msg.sender].rewardMissed -
            usersStakes[msg.sender].rewardClaimed;

        usersStakes[msg.sender].rewardClaimed = claimAmount;

        uint256 treasurePart = (claimAmount * feePercent) / 100000;
        uint256 usersPart = claimAmount - treasurePart;

        // TODO: Bad behavior to move transfer to treasure in user's tx. May be better to store
        // tresure fees and transfer with another function that can be called by anyone.
        IERC20(lido).transfer(lighthouseTreasure, treasurePart);

        IERC20(lido).transfer(msg.sender, usersPart);

        lastStETHBalanceOfContract = ILido(lido).balanceOf(address(this));
        emit Claimed(msg.sender, usersPart);
    }

    // TODO: unstake is unsupported now for ETH2 staking and also for Lido.
    function unstake() external {}

    // function distributeFee() external {
    // }

    /**
     * Function that sets trusted forwarder, for handle gasless transactions.
     * @param trustedForwarder Address of new trusted forwarder.
     */
    function setTrustedForwarder(address trustedForwarder) external onlyOwner {
        _setTrustedForwarder(trustedForwarder);
    }

    // TODO: There can be an error with decimal.
    function _updateTps() private {
        uint256 currentStEthBalanceOfContract = ILido(lido).balanceOf(
            address(this)
        );
        uint256 rewardsEarned = currentStEthBalanceOfContract -
            lastStETHBalanceOfContract;
        uint256 totalShares = token.totalSupply();
        if (totalShares != 0) {
            tps += rewardsEarned / totalShares;
        }
        lastStETHBalanceOfContract = currentStEthBalanceOfContract;
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
