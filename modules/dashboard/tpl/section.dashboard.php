<style>
    ul.list-community {
        height: 750px;
        overflow: auto;
    }
</style>
<main class="main-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card shadow">
                    <div class="card-body">
                        <input type="text" class="form-control form-control-search rounded-pill border-0" id="search_coins" placeholder="Search for communities...">
                    </div>
                    <ul id="community_list_items" class="list-community">
                        <li class="list-community-item">
                            <a href="#">
                                <div class="d-flex align-items-center">
                                    <div class="avator d-flex justify-content-center align-items-center me-5">
                                        <img src="<?php echo app_cdn_path; ?>img/company-overall.png" class="rounded-circle bg-white" width="48" height="48" />
                                    </div>
                                    <div class="w-70">
                                        <div class="fs-3 text-truncate">Overall Stats</div>
                                        <div class="text-muted lh-1">Aggregate</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-community-item">
                            <a href="#">
                                <div class="d-flex align-items-center">
                                    <div class="avator d-flex justify-content-center align-items-center me-5">
                                        <img src="<?php echo app_cdn_path; ?>img/company-lighthouse.png" class="rounded-circle bg-white" width="48" height="48" />
                                    </div>
                                    <div class="w-70">
                                        <div class="fs-3 text-truncate">Lighthouse DAO</div>
                                        <div class="text-muted lh-1">Reputation</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div id="loading"></div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-body card-body-md">
                        <!-- user details and bank bank details -->
                        <div class="d-flex align-items-start">
                            <div class="d-flex align-items-center w-60">
                                <div class="avator d-flex justify-content-center align-items-center border border-black bg-purple rounded-circle me-5">
                                    <div class="select-company-logo">
                                        <img src="<?php echo app_cdn_path; ?>img/current-company-logo.jpg" class="rounded-circle border border-white" width="30" height="30" />
                                    </div>
                                </div>
                                <div class="d-flex flex-column  w-70">
                                    <div class="fs-3 text-truncate">You + <span id="network-name"></span></div>
                                    <div class="text-muted lh-1"><span id="selected-account">   +2 others</div>
                                    <input type="hidden" name="user_key" id="user_key">
                                </div>
                            </div>

                            <div class="ms-auto">
                                <div class="d-flex flex-column  text-end mw-220">
                                    <div class="text-muted address">Bankless DAO Price (BANK)</div>
                                    <div class="fs-lg symbol">$0.05628</div>
                                    <div class="fs-lg balance">0.00001829 ETH</div>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container">
                            <main class="grid-item main">
                                <div class="items">
                                    <div class="item">
                                        <div class="fs-3">6,483</div>
                                        <div class="text-muted text-uppercase">Reputation Score</div>
                                    </div>
                                    <div class="item">
                                        <div class="fs-3">$50K</div>
                                        <div class="text-muted text-uppercase">Investment</div>
                                    </div>
                                    <div class="item">
                                        <div class="fs-3">$8K</div>
                                        <div class="text-muted text-uppercase">HODL</div>
                                    </div>
                                    <div class="item">
                                        <div class="fs-3">$15K</div>
                                        <div class="text-muted text-uppercase">Stake</div>
                                    </div>
                                    <div class="item">
                                        <div class="fs-3">$70K</div>
                                        <div class="text-muted text-uppercase">Liquidity</div>
                                    </div>
                                    <div class="item">
                                        <div class="fs-3">24</div>
                                        <div class="text-muted text-uppercase">Votes</div>
                                    </div>
                                    <div class="item">
                                        <div class="fs-3">3</div>
                                        <div class="text-muted text-uppercase">NFT</div>
                                    </div>
                                </div>
                            </main>
                        </div>

                    </div>
                </div>

                <div class="d-flex align-items-center my-7">
                    <!-- Tab nav -->
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  active" id="Reputation-tab" data-bs-toggle="pill" data-bs-target="#Reputation" type="button" role="tab" aria-controls="Reputation" aria-selected="true">Reputation</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="Updates-tab" data-bs-toggle="pill" data-bs-target="#Updates" type="button" role="tab" aria-controls="Updates" aria-selected="false">Updates</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="Governance-tab" data-bs-toggle="pill" data-bs-target="#Governance" type="button" role="tab" aria-controls="Governance" aria-selected="false">Governance</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="Profile-tab" data-bs-toggle="pill" data-bs-target="#Profile" type="button" role="tab" aria-controls="Profile" aria-selected="false">Profile</button>
                        </li>
                    </ul>
                    <select class="form-select w-22 bg-white ms-auto" aria-label="">
                        <option selected>Filter by: All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="Reputation" role="tabpanel" aria-labelledby="Reputation-tab">

                        <div class="my-12">
                            <div class="d-flex align-items-center text-fiord mb-4">
                                <div>
                                    <img src="<?php echo app_cdn_path; ?>img/icon-fire.svg" />
                                </div>
                                <div class="ms-6">HODL streak</div>
                                <div class="mx-5">•</div>
                                <div class="">214 days</div>
                                <div class="mx-5">•</div>
                                <div>467 points</div>
                            </div>
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center w-70">
                                            <div class="avator border rounded-circle me-6">
                                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" />
                                            </div>
                                            <div class="w-80">
                                                <div class="fs-3 text-truncate">HODLing 38.76 BANK</div>
                                                <div class="text-muted lh-1">Governance</div>
                                            </div>
                                        </div>
                                        <div class="ms-auto text-end mw-200">
                                            <div>Daily reputation gain</div>
                                            <div class=" text-muted fs-sm">+14 points</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-4 border-top">
                                    <div class="dropdown">
                                        <button class="btn btn-buy-more dropdown-toggle p-0" type="button" id="dropdownBuyMore" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="d-flex align-items-center" >
                                                <img src="<?php echo app_cdn_path; ?>img/icon-buy.svg" height="20">
                                                <div class=" ms-5 text-primary">Buy More</div>
                                            </div>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-buy-more" aria-labelledby="dropdownBuyMore">
                                            <li class="dropdown-item"><a href="#">Buy more on dYdX</a></li>
                                            <li class="dropdown-item"><a href="#">Buy more on Uniswap (V3)</a></li>
                                            <li class="dropdown-item"><a href="#">Buy more on PancakeSwap (V2)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-12">
                            <div class="d-flex align-items-center text-fiord mb-4">
                                <div>
                                    <img src="<?php echo app_cdn_path; ?>img/icon-fire.svg" />
                                </div>
                                <div class="ms-6">HODL streak</div>
                                <div class="mx-5">•</div>
                                <div>214 days</div>
                                <div class="mx-5">•</div>
                                <div>467 points</div>
                            </div>
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center w-70">
                                            <div class="avator border rounded-circle me-6">
                                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" />
                                            </div>
                                            <div class="w-80">
                                                <div class="fs-3 text-truncate">HODLing 38.76 BANK</div>
                                                <div class="text-muted lh-1">Governance</div>
                                            </div>
                                        </div>
                                        <div class="ms-auto text-end mw-200">
                                            <div>Daily reputation gain</div>
                                            <div class=" text-muted fs-sm">+14 points</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-4 border-top">
                                    <a class="text-primary text-decoration-none" href="#" role="button">
                                        <div class="d-flex align-items-center" >
                                            <img src="<?php echo app_cdn_path; ?>img/icon-coin.svg" height="20">
                                            <div class=" ms-5">Stake More</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Updates" role="tabpanel" aria-labelledby="Updates-tab">
                        <div class="my-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center w-70">
                                            <div class="avator border rounded-circle me-6">
                                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" />
                                            </div>
                                            <div class="w-80">
                                                <div class="fs-3 text-truncate">HODLing 38.76 BANK</div>
                                                <div class="text-muted lh-1">Governance</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top">
                                    <div class="fs-5 ">Revolving light</div>
                                    <div class="border rounded-3 p-12 mt-12 bg-light">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo app_cdn_path; ?>img/img-post.jpg" class="img-post img-fluid rounded-3 me-13" width="200" height="140" alt=""/>
                                            <div>
                                                <a class="text-muted text-decoration-none " href="#" target="_blank">banklessdao.substack.com</a>
                                                <div class="fs-4 mt-3">Breaking Down BANK Tokenomics | BanklessDAO...</div>
                                                <div class="text-muted mt-3">Catch Up With What Happened This Week in BanklessDAO</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty message -->
                        <div class="card shadow d-none">
                            <div class="card-body text-center">
                                <img src="<?php echo app_cdn_path; ?>img/img-myactivity.png" class="img-fluid rounded mt-16" alt=""/>
                                <div class="fs-1 fw-semibold mt-12">No contributions yet!</div>
                                <div class="fs-5  mt-5 text-center">Post an article link or announcement <br>
                                    from a DAO to start contributing</div>
                                <button type="button" class="btn btn-primary btn-lg px-25 text-uppercase mt-23 mb-18">Post Now</button>
                            </div>
                        </div>
                        <!-- Empty message END -->
                    </div>
                    <div class="tab-pane fade" id="Governance" role="tabpanel" aria-labelledby="Governance-tab">
                        <div class="my-12">
                            <div class="d-flex align-items-center  mb-4">
                                <div>January 27, 2022</div>
                            </div>
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="d-flex w-70">
                                            <div class="avator border rounded-circle me-6">
                                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" />
                                            </div>
                                            <div class="w-80">
                                                <div class="fs-3 text-truncate">BalancerDAO’s collaboration with BanklessDAO</div>
                                                <div class="text-muted lh-1">Bankless DAO</div>
                                            </div>
                                        </div>
                                        <div class="ms-auto text-end mw-200">
                                            <div>Open</div>
                                            <div class=" text-muted fs-sm">Low Importance</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-4 border-top">
                                    <a class="text-primary text-decoration-none" href="#" role="button">
                                        <div class="d-flex align-items-center" >
                                            <img src="<?php echo app_cdn_path; ?>img/icon-eye.svg" height="20">
                                            <div class=" ms-5">View Proposal</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Empty message -->
                        <div class="card shadow d-none">
                            <div class="card-body text-center">
                                <img src="<?php echo app_cdn_path; ?>img/img-myactivity.png" class="img-fluid rounded mt-16" alt=""/>
                                <div class="fs-1 fw-semibold mt-12">No contributions yet!</div>
                                <div class="fs-5  mt-5 text-center">Post an article link or announcement <br>
                                    from a DAO to start contributing</div>
                                <button type="button" class="btn btn-primary btn-lg px-25 text-uppercase mt-23 mb-18">Post Now</button>
                            </div>
                        </div>
                        <!-- Empty message END -->
                    </div>
                    <div class="tab-pane fade" id="Profile" role="tabpanel" aria-labelledby="Profile-tab">

                        <div class="my-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="d-flex w-50">
                                            <div class="avator border rounded-circle me-6">
                                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" />
                                            </div>
                                            <div class="w-60">
                                                <div class="fs-3 text-truncate">BalancerDAO’s collaboration with BanklessDAO</div>
                                                <div class="text-muted lh-1">0x2d94a...da198 <img src="<?php echo app_cdn_path; ?>img/icon-coin-rank.svg" class="ms-1" width="15" height="15"></div>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            <ul class="list-equal-horizontal">
                                                <li class="list-equal-item  py-0">
                                                    <div class="fs-3 lh-1">12,371</div>
                                                    <div class="text-muted mt-1">Members</div>
                                                </li>
                                                <li class="list-equal-item  py-0">
                                                    <div class="fs-3 lh-1">$15.65M</div>
                                                    <div class="text-muted mt-1">Market Cap</div>
                                                </li>
                                                <li class="list-equal-item  py-0">
                                                    <div class="fs-3 lh-1">$476K</div>
                                                    <div class="text-muted mt-1">Treasury</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="ms-28 mt-4">
                                        <ul class="list-badge">
                                            <li class="list-badge-item">Community</li>
                                            <li class="list-badge-item">Ethereum</li>
                                            <li class="list-badge-item">DeFi</li>
                                            <li class="list-badge-item">NFT</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body border-top">
                                    <div class=" fs-5">A decentralized autonomous organization that acts as a steward of the Bankless Movement progressing the world towards a future of greater freedom.</div>
                                    <div class="row mt-12">
                                        <div class="col-lg-6">
                                            <div class=" fs-5 text-primary mb-2">Social</div>
                                            <div class="list-social-media">
                                                <a class="list-social-media-item d-flex align-items-center" href="#" role="button">
                                                    <div class="avator d-flex justify-content-center align-items-center border rounded-circle me-6">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-bank.svg" height="16" />
                                                    </div>
                                                    <div class="text-dark  fs-5">bankless.community</div>
                                                </a>
                                                <a class="list-social-media-item d-flex align-items-center" href="#" role="button">
                                                    <div class="avator d-flex justify-content-center align-items-center border rounded-circle me-6">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-twitter.svg" height="16" />
                                                    </div>
                                                    <div class="text-dark  fs-5">@banklessDAO</div>
                                                </a>
                                                <a class="list-social-media-item d-flex align-items-center" href="#" role="button">
                                                    <div class="avator d-flex justify-content-center align-items-center border rounded-circle me-6">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-discord.svg" height="16" />
                                                    </div>
                                                    <div class="text-dark  fs-5">discord.gg/bankless</div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ps-lg-13">
                                            <div class=" fs-5 text-primary mb-2">Activity</div>
                                            <ul class="list-activity">
                                                <li class="list-activity-item  fs-5">4 Open Proposals</li>
                                                <li class="list-activity-item  fs-5">1,346 ended</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty message -->
                        <div class="card shadow d-none">
                            <div class="card-body text-center">
                                <img src="<?php echo app_cdn_path; ?>img/img-rewards.png" class="img-fluid rounded mt-16" alt=""/>
                                <div class="fs-1 fw-semibold mt-12">Rewards dropping soon! </div>
                                <div class="fs-5  mt-5 text-center">We’re working with communities to define <br>
                                    rewards for Lighthouse members. Sign up to stay tuned.</div>
                                <form class="row g-6 justify-content-md-center mt-23 mb-18">
                                    <div class="col-6">
                                        <label for="Email" class="visually-hidden">Email</label>
                                        <input type="password" class="form-control form-control-lg" id="Email" placeholder="Email">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary btn-lg px-20 text-uppercase">Get Notified</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Empty message END -->
                    </div>
                </div>

                <!-- Tab nav END -->


            </div>

            <div class="col-lg-3">

                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex w-100">
                            <div class="avator border rounded-circle me-6">
                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" />
                            </div>
                            <div class="w-80">
                                <div class="fs-3 text-truncate">Level 50 Rare NFT</div>
                                <div class="text-muted lh-1">GuildXYZ</div>
                            </div>
                        </div>
                        <div class="fs-5  mt-13">Reward Overview</div>
                        <div class="fs-5  text-muted mt-2">This NFT is awarded for crossing level 50 on GuildXYZ. <a href="#" class="text-reset text-decoration-underline">Read More</a></div>
                        <div class="fs-5  mt-10 mb-8">Eligibility criteria</div>
                        <div class="list-form-check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="HODLpoints">
                                <label class="form-check-label fs-5 text-fiord" for="HODLpoints">
                                    HODL points
                                </label>
                                <div class="ms-auto fs-5 text-fiord">500</div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="StakingPoints">
                                <label class="form-check-label fs-5 text-fiord" for="StakingPoints">
                                    Staking points
                                </label>
                                <div class="ms-auto fs-5 text-fiord">300</div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="Votes">
                                <label class="form-check-label fs-5 text-fiord" for="Votes">
                                    Votes
                                </label>
                                <div class="ms-auto fs-5 text-fiord">5</div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="Transactions">
                                <label class="form-check-label fs-5 text-fiord" for="Transactions">
                                    Transactions
                                </label>
                                <div class="ms-auto fs-5 text-fiord">20</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>
<!-- Modal BECOME A SCOUT -->
<div class="modal fade" id="BecomeScout" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body text-center pt-25">
                <img src="<?php echo app_cdn_path; ?>img/img-collect.png" class="img-fluid" alt=""/>
                <div class="fs-1 fw-semibold mt-22">Collect $LHT by validating high quality content</div>
                <div class="fs-5  mt-8">Lighthouse pipes in information in from various sources.</div>
                <div class="fs-5  mt-1">Scouts validate good content to begin collecting $LHT rewards.</div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary btn-lg px-25 text-uppercase">Let's go!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal BECOME A SCOUT END -->
<!-- Modal MINT NFT -->
<div class="modal fade" id="MintNft" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center pt-25">
                <img src="<?php echo app_cdn_path; ?>img/img-profile-lg.jpg" class="img-fluid border rounded" alt=""/>
                <div class="fs-1 fw-semibold mt-22">Profile NFTs dropping soon!</div>
                <form class="row g-6 justify-content-md-center mt-14 mb-10">
                    <div class="col-6">
                        <label for="Email" class="visually-hidden">Email</label>
                        <input type="password" class="form-control form-control-lg" id="Email" placeholder="Email">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg px-20 text-uppercase">Get Notified</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal MINT NFT END -->
<!-- Modal Welcome -->
<div class="modal fade" id="Welcome" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center pt-25">
                <img src="<?php echo app_cdn_path; ?>img/img-welcome.png" class="img-fluid border rounded" alt=""/>
                <div class="fs-1 fw-semibold mt-10">Welcome to Lighthouse!</div>
                <div class="fs-5  mt-8 text-center">Lighthouse is a community-run web3 activity <br>
                    tracker that lets you stay up to date with your favorite DAOs,<br>
                    crypto communities and projects.</div>
            </div>
            <div class="modal-footer justify-content-center mt-7 mb-18">
                <button id="btn-connect" type="button" class="btn btn-primary btn-lg px-25 text-uppercase">Connect Wallet</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Welcome END -->
<!-- Modal post -->
<div class="modal fade" id="ModalPost" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="mb-6 row">
                        <div class="col-lg-6">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>All DAOs</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-6">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="What did you find?"></textarea>
                    </div>
                    <div class="">
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="URL">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-lg px-20 text-decoration-none text-uppercase" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-lg px-20 text-uppercase">Post</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal post END -->
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {

        loading = 0;
        page = 1;

        $('#Welcome').modal('toggle');

        $('#search_coins').keyup(delay(function (e) {
            $('#community_list_items').html('');
            getFirstCoinsPage($('#search_coins').val());
        }, 500));

        $('.list-community').scroll(function() {
            if( loading == 0) {
                $("#loading").html("<img src='<?php echo app_cdn_path; ?>images/loading.gif' class='img-loader' width='100' height='100'>");
                //p_l_count += 1;
                loading = 1;
                $.ajax({
                    url:  'get-coins?user_key='+$('#user_key').val()+'&p='+page+'&search='+$('#search_coins').val(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success == true) {
                            $('#community_list_items').append(response.lines);
                            $("#loading").html('');
                            if(!response.end) {
                                loading = 0;
                                page++;
                            }
                        }
                    }
                });
            }
        });

        $(document).on("click",".pin_coin",function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href') ,
                dataType: 'json',
                success: function(response) {
                    if (response.success == true) {
                        $(this).children().append('<div class="ms-auto"><img src="<?php echo app_cdn_path; ?>img/icon-pin-fill.svg" width="25" height="25"></div>');
                    }
                }
            });
        });
    });

    function getFirstCoinsPage() {
        $.ajax({
            url: 'get-coins?user_key='+$('#user_key').val()+'&p=0&search='+$('#search_coins').val() ,
            dataType: 'json',
            success: function(response) {
                if (response.success == true) {
                    $('#community_list_items').append(response.lines);
                    $("#loading").html('');
                    if(!response.end) {
                        loading = 0;
                        page++;
                    }
                }
            }
        });
    }

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }
</script>