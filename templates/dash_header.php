<div class="bg-we-peep alert-show">
    <div class="container-fluid">
        <div class="py-7 d-flex align-items-center">
            <img src="<?php echo app_cdn_path; ?>img/icon-info.svg" class="img-fluid" />
            <div class="ms-3">To use Lighthouse, please switch to the Ethereum network in your wallet.</div>
        </div>
    </div>
</div>
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white two-bg">
    <div class="container-fluid">
        <div class="d-flex align-items-center w-100">
            <div class="col d-xl-none">
                <a><img src="<?php echo app_cdn_path; ?>img/icon-search.svg" height="18" ></a>
            </div>
            <div class="col col-xl-5 col-xxxl">
                <div class="d-flex align-items-center justify-content-center justify-content-xl-start">
                    <a class="" href="drops">
                        <img src="<?php echo app_cdn_path; ?>img/logo.svg" class="main-logo" />
                    </a>
                    <ul class="navbar-nav top-navbar-nav-ms d-none d-lg-flex">
                        <li id="drops-menu" class="nav-item">
                            <a class="nav-link text-uppercase fw-medium active" href="drops">Drops</a>
                        </li>
                        <li id="claims-menu" class="nav-item">
                            <a class="nav-link text-uppercase fw-medium" href="claims">My Claims</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-xxxl d-none d-xl-flex">
                <input type="text" id="search_coins" class="form-control form-control-search rounded-pill border-0" placeholder="Search rewards...">
            </div>
            <div class="col col-xl-4 col-xxxl">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="form-check form-switch form-switch-start d-none">
                        <label class="form-check-label fs-5 fw-medium" for="UserSwitch">User View</label>
                        <input type="hidden" name="user_key" id="user_key">
                        <input type="hidden" name="coin_id" id="coin_id">
                        <input class="form-check-input" type="checkbox" id="UserSwitch">                
                    </div>
                    <div id="user_menu" class="dropdown d-flex align-items-center">
                        <div class="h-divider mx-12 d-none"></div>
                        <a class="nav-link dropdown-toggle mobile-dropdown-toggle d-flex align-items-center px-0 text-fiord" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div  id="user_avatar" class="d-none avator-md d-flex justify-content-center align-items-center rounded-circle border border-black bg-purple"></div>
                            <div  id="user_address" class="mx-4 h5 mb-0 d-none d-xl-flex"></div>
                        </a>
                        <ul id="wallet_addresses" class="dropdown-menu dropdown-menu-end list-wallet" aria-labelledby="navbarDropdown"></ul>
                    </div>
                    <button type="button" id="btn-connect" class="btn btn-primary btn-lg px-12 text-uppercase d-none d-xl-flex">Connect Wallet</button>
                </div>
            </div>
        </div>
    </div>
</nav>