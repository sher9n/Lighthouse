<main class="main-wrapper">
    <div class="container p-0">
        <div class="row">
            <div class="col-lg-3 mobile-hidden">
                <div class="section-sticky">
                    <div class="card shadow">
                        <div class="card-body border-bottom">
                            <input type="text" id="search_coins" class="form-control form-control-search rounded-pill border-0" id="" placeholder="Search for communities...">
                        </div>
                        <div class="scroll multiple">
                            <div class="scrollDiv">
                                <div class="scroll-section scrollContent">
                                    <ul id="community_list_items" class="list-community">
                                        <div class="py-8 px-13 border-bottom list_item_skeleton"><div class="d-flex align-items-center loading"><div class="round-md me-4"></div><div class="d-flex flex-column"><div class="text-content-xl mw-160 mb-3"></div><div class="text-content w-50"></div></div></div></div>
                                    </ul>
                                    <div id="loading"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="fixed-content ">
                    <div class="card shadow">
                        <div class="card-body card-body-md">
                            <!-- user details and bank bank details -->
                            <div class="user_details_skelton card shadow loading">
                                <div class="card-body card-body-md">
                                    <div class="d-flex align-items-start mb-13">
                                        <div class="d-flex align-items-center">
                                            <div class="round-md me-4"></div>
                                            <div class="d-flex flex-column">
                                                <div class="text-content-xl mw-160 mb-3"></div>
                                                <div class="text-content w-50"></div>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="d-flex flex-column align-items-end mw-220">
                                                <div class="text-content mw-180 mb-3"></div>
                                                <div class="text-content-lg w-30 mb-3"></div>
                                                <div class="text-content-lg w-50"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-around">
                                        <div class="d-flex flex-column align-items-center px-6">
                                            <div class="text-content mw-100 mb-3"></div>
                                            <div class="text-content-lg w-70 mb-3"></div>
                                        </div>
                                        <div class="d-flex flex-column align-items-center px-6">
                                            <div class="text-content mw-100 mb-3"></div>
                                            <div class="text-content-lg w-70 mb-3"></div>
                                        </div>
                                        <div class="d-flex flex-column align-items-center px-6">
                                            <div class="text-content mw-100 mb-3"></div>
                                            <div class="text-content-lg w-70 mb-3"></div>
                                        </div>
                                        <div class="d-flex flex-column align-items-center px-6">
                                            <div class="text-content mw-100 mb-3"></div>
                                            <div class="text-content-lg w-70 mb-3"></div>
                                        </div>
                                        <div class="d-flex flex-column align-items-center px-6">
                                            <div class="text-content mw-100 mb-3"></div>
                                            <div class="text-content-lg w-70 mb-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="user_details d-flex d-none align-items-start">
                                <div class=" d-flex align-items-center w-60">
                                    <div id="overall_avt" class="avator d-flex justify-content-center align-items-center me-5">
                                        <img id="overall_logo" src="<?php echo app_cdn_path; ?>img/company-overall.png" class="rounded-circle bg-white" width="48" height="48">
                                    </div>
                                    <div id="communities_avt" class="d-none avator d-flex justify-content-center align-items-center border border-black bg-purple rounded-circle me-5">
                                        <div class="select-company-logo">
                                            <img id="coin_logo" src="<?php echo app_cdn_path; ?>img/company-overall.png" class="rounded-circle border border-white" width="30" height="30" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column w-70">
                                        <div class="fs-3 text-truncate"><span id="network-name">Overall Stats</span></div>
                                        <div class="text-muted lh-1"><span id="selected-account">Aggregate</div>
                                        <input type="hidden" name="user_key" id="user_key">
                                        <input type="hidden" name="coin_id" id="coin_id">
                                    </div>
                                </div>
                                <div id="overall_stats" class="ms-auto d-none">
                                    <div class="d-flex d-lg-flex flex-column text-end mw-220">
                                        <div id="platform_name" class="text-muted address"></div>
                                        <div id="coin_values_skelton" class="loading d-flex flex-column align-items-end text-end">
                                            <div class="text-content-lg w-70 mb-3"></div>
                                            <div class="text-content-lg w-50"></div>
                                        </div>
                                        <div id="coin_values" class="d-none">
                                            <div id="coin_val" class="fs-lg symbol"></div>
                                            <div id="coin_eth_val" class="fs-lg balance"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="user_details d-none grid-container">
                                <main class="grid-item main">
                                    <div class="items">
                                        <div class="item">
                                            <div id="rs" class="fs-3">0</div>
                                            <div class="text-muted text-uppercase">Reputation Score</div>
                                        </div>
                                        <div class="item">
                                            <div id="inv" class="fs-3">$0</div>
                                            <div class="text-muted text-uppercase">Investment</div>
                                        </div>
                                        <div class="item">
                                            <div id="hod" class="fs-3">$0</div>
                                            <div class="text-muted text-uppercase">HODL</div>
                                        </div>
                                        <div class="item">
                                            <div id="stk" class="fs-3">$0</div>
                                            <div class="text-muted text-uppercase">Stake</div>
                                        </div>
                                        <div class="item">
                                            <div id="liq" class="fs-3">$0</div>
                                            <div class="text-muted text-uppercase">Liquidity</div>
                                        </div>
                                        <div class="item">
                                            <div id="vot" class="fs-3">0</div>
                                            <div class="text-muted text-uppercase">Votes</div>
                                        </div>
                                        <div class="item">
                                            <div id="nft" class="fs-3">0</div>
                                            <div class="text-muted text-uppercase">NFT</div>
                                        </div>
                                    </div>
                                </main>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column-reverse flex-lg-row align-items-center my-7">
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
                        <select class="form-select w-22 bg-white ms-lg-auto" aria-label="">
                            <option selected>Filter by: All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="fixed-content-view">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="Reputation" role="tabpanel" aria-labelledby="Reputation-tab">
                            <div class="my-12">
                                <div class="d-flex align-items-center text-fiord mb-4 ms-8 ms-lg-0">
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
                                                    <img src="<?php echo app_cdn_path; ?>img/company-dao.png" class="rounded-circle" width="48" height="48" />
                                                </div>
                                                <div class="w-80">
                                                    <div class="fs-3 text-truncate">HODLing 38.76 BANK</div>
                                                    <div class="text-muted lh-1">Governance</div>
                                                </div>
                                            </div>
                                            <div class="ms-auto text-end">
                                                <div class="mw-200">
                                                    <div>Daily reputation gain</div>
                                                    <div class=" text-muted fs-sm">+14 points</div>
                                                </div>
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
                                <div class="d-flex align-items-center text-fiord mb-4 ms-8 ms-lg-0">
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
                                                <div class="avator rounded-circle border me-6">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-dao.png" class="rounded-circle" width="48" height="48" />
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
                            <!-- skeloton Reputation -->
                            <div class="my-12 d-none">
                                <div class="d-flex mb-4">
                                    <div class="text-content mw-10 me-4"></div>
                                    <div class="text-content mw-30 me-4"></div>
                                    <div class="text-content mw-30 me-4"></div>
                                    <div class="text-content mw-40 me-4"></div>
                                </div>
                                <div class="card shadow loading">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="d-flex align-items-center">
                                                <div class="round-md me-4"></div>
                                                <div class="d-flex flex-column">
                                                    <div class="text-content-xl mw-160 mb-3"></div>
                                                    <div class="text-content w-50"></div>
                                                </div>
                                            </div>
                                            <div class="ms-auto">
                                                <div class="d-flex flex-column align-items-end mw-220">
                                                    <div class="text-content mw-180 mb-3"></div>
                                                    <div class="text-content-lg w-30 mb-3"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body py-4 border-top">
                                    <div class="text-content-xl w-10"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-12 d-none">
                                <div class="d-flex mb-4">
                                    <div class="text-content mw-10 me-4"></div>
                                    <div class="text-content mw-30 me-4"></div>
                                    <div class="text-content mw-30 me-4"></div>
                                    <div class="text-content mw-40 me-4"></div>
                                </div>
                                <div class="card shadow loading">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="d-flex align-items-center">
                                                <div class="round-md me-4"></div>
                                                <div class="d-flex flex-column">
                                                    <div class="text-content-xl mw-160 mb-3"></div>
                                                    <div class="text-content w-50"></div>
                                                </div>
                                            </div>
                                            <div class="ms-auto">
                                                <div class="d-flex flex-column align-items-end mw-220">
                                                    <div class="text-content mw-180 mb-3"></div>
                                                    <div class="text-content-lg w-30 mb-3"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body py-4 border-top">
                                    <div class="text-content-xl w-10"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- skeloton Reputation END -->
                        </div>
                        <div class="tab-pane fade" id="Updates" role="tabpanel" aria-labelledby="Updates-tab">
                            <div class="card shadow">
                                <div class="card-body text-center">
                                    <img src="<?php echo app_cdn_path; ?>img/img-myactivity.png" class="img-fluid rounded mt-16" alt=""/>
                                    <div class="fs-1 fw-semibold mt-12">No contributions yet!</div>
                                    <div class="fs-5  mt-5 text-center">Post an article link or announcement <br>
                                        from a DAO to start contributing</div>
                                    <button type="button" class="btn btn-primary btn-lg px-25 text-uppercase mt-23 mb-18">Post Now</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Governance" role="tabpanel" aria-labelledby="Governance-tab">
                            <div class="my-12">
                                <div class="d-flex align-items-center mb-4 ms-8 ms-lg-0">
                                    <div>January 27, 2022</div>
                                </div>
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="d-flex w-70">
                                                <div class="avator border rounded-circle me-6">
                                                    <img src="<?php echo app_cdn_path; ?>img/company-dao.png" class="rounded-circle" width="48" height="48" />
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
                            <div class="card shadow">
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
                        </div>
                    </div>
                </div>
                <!-- Tab nav END -->
            </div>
            <div class="col-lg-3 mobile-hidden">
                <div class="section-sticky">
                    <div class="scroll-lg multiple">
                        <div class="scrollDiv">
                            <div class="scrollContent">

                                <!-- skeloton Review -->
                                    <div class="card shadow loading mb-12 d-none">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="round-xl"></div>
                                                <div class="text-content-xl w-50 my-12"></div>
                                                <div class="text-content w-70 mb-2"></div>
                                                <div class="text-content w-80 mb-2"></div>
                                                <div class="text-content w-40"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card shadow loading mb-12 d-none">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                <div class="d-flex align-items-center">
                                                    <div class="round-md me-4"></div>
                                                    <div class="d-flex flex-column">
                                                        <div class="text-content-xl mw-160 mb-3"></div>
                                                        <div class="text-content w-50"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-content-xl mt-13 w-20"></div>
                                            <div class="text-content-xl mt-3"></div>
                                            <div class="text-content-xl mt-3 mb-8 w-50"></div>

                                            <div class="text-content-xl mt-10 mb-8 w-30"></div>
                                            <div class="text-content-xl mt-3"></div>
                                            <div class="text-content-xl mt-3"></div>
                                            <div class="text-content-xl mt-3"></div>
                                            <div class="text-content-xl mt-3"></div>
                                        </div>
                                    </div>
                                <!-- skeloton Review END -->

                                <div id="notify_form" class="card shadow mb-12">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <form id="notifyForm" method="post" action="notify" autocomplete="off">
                                                <div class="avator-lg d-flex justify-content-center align-items-center border bg-alabaster rounded-circle m-auto">
                                                    <img src="<?php echo app_cdn_path; ?>img/rewards-drop.png" class="rounded-circle" width="auto" height="75" />
                                                </div>
                                                <div class="my-12">
                                                    <div class="fs-4 text-truncate fw-medium">Rewards dropping soon! </div>
                                                    <div class="text-muted mt-3">We’re working with communities<br>
                                                        to design personalized rewards for you.</div>
                                                </div>
                                                <div class="mb-6">
                                                    <input type="email" name="email" class="form-control form-control-lg border-0" id="" placeholder="Email">
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary btn-lg px-13 text-uppercase">Get Notified</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="notify_complete" class="card shadow mb-12 d-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="m-auto">
                                                <img src="<?php echo app_cdn_path; ?>img/icon-ok.svg" class="rounded-circle" width="80" height="80" />
                                            </div>
                                            <div class="my-12">
                                                <div class="fs-4 text-truncate fw-medium">Your first rewards are coming soon.</div>
                                                <div class="text-muted mt-3">We’ll send you a message when the first drops.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow mb-12 d-none">
                                    <div class="card-body">
                                        <div class="d-flex w-100">
                                            <div class="avator border rounded-circle me-6">
                                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" class="rounded-circle" width="48" height="48" />
                                            </div>
                                            <div class="w-80">
                                                <div class="fs-3 text-truncate">Level 50 Rare NFT</div>
                                                <div class="text-muted lh-1">GuildXYZ</div>
                                            </div>
                                        </div>
                                        <div class="fs-5 mt-13">Reward Overview</div>
                                        <div class="fs-5 text-muted mt-2">This NFT is awarded for crossing level 50 on GuildXYZ. <a href="#" class="text-reset text-decoration-underline">Read More</a></div>
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
                                <div class="card shadow mb-12 d-none">
                                    <div class="card-body">
                                        <div class="d-flex w-100">
                                            <div class="avator border rounded-circle me-6">
                                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" class="rounded-circle" width="48" height="48" />
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
                                <div class="card shadow mb-12 d-none">
                                    <div class="card-body">
                                        <div class="d-flex w-100">
                                            <div class="avator border rounded-circle me-6">
                                                <img src="<?php echo app_cdn_path; ?>img/company-dao.png" class="rounded-circle" width="48" height="48" />
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
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal Welcome -->
<div class="modal fade" id="Welcome" tabindex="-1" aria-labelledby="" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div id="network_check" class="bg-we-peep rounded-3 mb-13 fade">
                    <div class="container">
                        <div class="py-7 d-flex align-items-center">
                            <img src="<?php echo app_cdn_path; ?>img/icon-info.svg" class="img-fluid" />
                            <div class="ms-3">To use Lighthouse, please switch to the Ethereum network in your wallet.</div>
                        </div>
                    </div>
                </div>
                <img src="<?php echo app_cdn_path; ?>img/img-welcome.png" class="img-fluid" alt=""/>
                <div class="fs-1 fw-medium mt-10">Welcome to Lighthouse!</div>
                <div class="fs-5  mt-8 text-center">Get recognized for the value you create in web3</div>
            </div>
            <div class="d-flex justify-content-center mt-7 mb-18">
                <button type="button" id="btn-connect" class="btn btn-primary btn-lg px-25 text-uppercase">Connect Wallet</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="wl_con_success" tabindex="-1" aria-labelledby="" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center pt-25">
                <img src="<?php echo app_cdn_path; ?>img/img-wallet-connect.png" class="img-fluid" alt=""/>
                <div class="fs-1 fw-medium mt-10">Wallet connection successful!</div>
                <div class="fs-5  mt-8 text-center"><span id="connected_wl_id"></span> has been successfully added to your wallet list.</div>
            </div>
            <div class="d-flex justify-content-center mt-7 mb-18">
                <button id="btn_go" type="button" class="btn btn-primary btn-lg px-25 text-uppercase">Continue</button>
            </div>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        //getFirstCoinsPage();
        var timer = 0;
        checkAccountData();

        $(function () {
            setInterval(ohlcv_updates, 30000);
        });

        if(!sessionStorage.getItem('lh_wallet_adds'))
            $('#Welcome').modal('toggle');

        $('#search_coins').keyup(delay(function (e) {
            $('#community_list_items').html('<div class="py-8 px-13 border-bottom"><div class="d-flex align-items-center loading"><div class="round-md me-4"></div><div class="d-flex flex-column"><div class="text-content-xl mw-160 mb-3"></div><div class="text-content w-50"></div></div></div></div>');
            getFirstCoinsPage($('#search_coins').val());
        }, 500));

        $('.scrollDiv').scroll(function() {
            if( loading == 0) {
                $("#loading").html('<div class="py-8 px-13 border-bottom"><div class="d-flex align-items-center loading"><div class="round-md me-4"></div><div class="d-flex flex-column"><div class="text-content-xl mw-160 mb-3"></div><div class="text-content w-50"></div></div></div></div>');
                loading = 1;
                $.ajax({
                    url:  'get-coins?user_key='+$('#user_key').val()+'&p='+page+'&search='+$('#search_coins').val(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success == true) {
                            $('.list_item_skeleton').addClass('d-none');
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

        $('#notifyForm').validate({
            rules: {
                email:{
                    required: true
                }
            },
            submitHandler: function(form){
                $('#notify_form').html('<div class="card shadow loading mb-12"><div class="card-body"><div class="d-flex flex-column align-items-center"><div class="round-xl"></div><div class="text-content-xl w-50 my-12"></div><div class="text-content w-70 mb-2"></div><div class="text-content w-80 mb-2"></div><div class="text-content w-40"></div></div></div></div> ');
                $(form).ajaxSubmit({
                    url: 'notify?user_key='+$('#user_key').val(),
                    type:'post',
                    dataType:'json',
                    success: function(data){
                        if(data.success == true){
                            $('#notify_form').addClass('d-none');
                            $('#notify_complete').removeClass('d-none');
                        }
                    }
                });
            }
        });

        $(document).on("click","#btn_go",function (e){
            e.preventDefault();
            $('#wl_con_success').modal('toggle');
        });

        $(document).on("click",".coin_details",function (e){
            e.preventDefault();
            clearTimeout(timer);
            var ele = $(this);
            var n   = ele.data('n');
            $('#Updates').html('<div class="my-12"><div class="card shadow loading"><div class="card-body"><div class="d-flex align-items-start"><div class="d-flex align-items-center"><div class="round-md me-4"></div><div class="d-flex flex-column"><div class="text-content-xl mw-160 mb-3"></div><div class="text-content w-50"></div></div></div></div></div><div class="card-body border-top"><div class="text-content-xl mb-3"></div><div class="text-content-xl mb-15 w-50"></div><div class="bg-content rounded h-150"></div></div></div></div>')
            $('.list-community-item').removeClass('active');
            $('#coin_values').addClass('d-none');
            $('#coin_values_skelton').removeClass('d-none');

            if(!(n == 'Lighthouse DAO' || n == 'Overall stats')) {

                $('#network-name').html('You + ' + n);
                $('#overall_stats').removeClass('d-none');
                $('#rs').html(Math.floor(Math.random() * 10000) + 1);
                $('#inv').html('$'+(Math.floor(Math.random() * 10)+ 1 +'K'));
                $('#hod').html('$'+(Math.floor(Math.random() * 100)+ 1 +'K'));
                $('#stk').html('$'+(Math.floor(Math.random() * 100)+ 1 +'K'));
                $('#liq').html('$'+(Math.floor(Math.random() * 100)+ 1 +'K'));
                $('#vot').html(Math.floor(Math.random() * 100) + 1);
                $('#nft').html(Math.floor(Math.random() * 10) + 1);

                if (ele.data('s'))
                    $('#platform_name').html(ele.data('n') + ' (' + ele.data('s') + ')');
                else
                    $('#platform_name').html(ele.data('n'));

                $('#coin_logo').attr('src', ele.data('l'));
                $('#coin_data').removeClass('d-none');
                $('#communities_avt').removeClass('d-none');
                $('#overall_avt').addClass('d-none');
                ele.parent().parent().addClass('active');

                var coin_id = ele.data('coin_id');
                $('#coin_id').val(coin_id);

                var tw_data = {'n': ele.data('n'), 'l': ele.data('l'), 't': ele.data('t')};
                var c_data = {'id': ele.data('id')};

                timer = setTimeout(function () {
                    $.ajax({
                        url: 'get-profile',
                        type: 'POST',
                        data: c_data,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success == true) {
                                $('#Profile').html(response.profile);
                            }
                        }
                    });

                    $.ajax({
                        url: 'get-tweets',
                        type: 'POST',
                        data: tw_data,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success == true) {
                                $('#Updates').html(response.updates);
                            }
                        }
                    });

                    ohlcv_updates();

                }, 1000);
            }
            else {
                $('#network-name').html(n);
                $('#overall_logo').attr('src', ele.data('l'));
                $('#overall_stats').addClass('d-none');
                $('#rs').html('0');
                $('#inv').html('$0');
                $('#hod').html('$0');
                $('#stk').html('$0');
                $('#liq').html('$0');
                $('#vot').html('0');
                $('#nft').html('0');
                $('#selected-account').html('Aggregate');
                $('#overall_avt').removeClass('d-none');
                $('#communities_avt').addClass('d-none');
                ele.parent().parent().addClass('active');
            }
        });

        $(document).on("click",".pin_coin",function(e) {
            e.preventDefault();
            var ele = $(this);
            ele.html('<img src="<?php echo app_cdn_path; ?>img/rolling.gif" width="25" height="25">');
            $.ajax({
                url: ele.attr('href') ,
                dataType: 'json',
                success: function(response) {
                    if (response.success == true) {
                        if(response.action == 'pin') {
                            ele.attr('href',response.href);
                            ele.html('<img src="<?php echo app_cdn_path; ?>img/icon-pin-fill.svg" width="25" height="25">');
                        }
                        else {
                            ele.attr('href',response.href);
                            ele.html('<img src="<?php echo app_cdn_path; ?>img/icon-pin.svg" width="25" height="25">');
                        }
                    }
                }
            });
        });

        $(document).on("click",".delete_wallet",function(e) {
            e.preventDefault();
            var ele = $(this);
            var w_id = ele.data("w_id");
            var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));

            if(jQuery.inArray(w_id, lh_wallet_adds) != -1){
                lh_wallet_adds = jQuery.grep(lh_wallet_adds, function(value) {
                    return value != w_id;
                });
                if(lh_wallet_adds.length == 0) {
                    onDisconnect();
                }
                else {
                    sessionStorage.setItem("lh_sel_wallet_add", lh_wallet_adds[0]);
                    sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
                    selectedAccount = null;
                }
                updateWalletMenu();
            }
        });
    });

    function getFirstCoinsPage() {
        loading = 1;
        $('#community_list_items').html('<div class="py-8 px-13 border-bottom list_item_skeleton"><div class="d-flex align-items-center loading"><div class="round-md me-4"></div><div class="d-flex flex-column"><div class="text-content-xl mw-160 mb-3"></div><div class="text-content w-50"></div></div></div></div>');
        $.ajax({
            url: 'get-coins?user_key='+$('#user_key').val()+'&p=0&search='+$('#search_coins').val() ,
            dataType: 'json',
            success: function(response) {
                if (response.success == true) {
                    $('.list_item_skeleton').addClass('d-none');
                    $('#community_list_items').append(response.lines);
                    $("#loading").html('');
                    if(!response.end) {
                        loading = 0;
                        page++;
                        rsMultiple.refresh();
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

    function ohlcv_updates() {
        var coin_id = $('#coin_id').val();

        if(coin_id) {
            $('#coin_values').addClass('d-none');
            $('#coin_values_skelton').removeClass('d-none');

            $.ajax({
                url: 'ohlcv-updates?coin_id='+ coin_id,
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        $('#coin_val').html(response.c_val);
                        $('#coin_eth_val').html(response.eth_val);
                        $('#coin_values').removeClass('d-none');
                        $('#coin_values_skelton').addClass('d-none');
                    }
                }
            });
        }

    }
</script>