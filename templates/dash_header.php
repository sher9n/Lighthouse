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
        <div class="row align-items-center w-100">
            <div class="col-xxl-4">
                <div class="d-flex align-items-center">
                    <a class="" href="dashboard">
                        <img src="<?php echo app_cdn_path; ?>img/logo.svg" class="" />
                    </a>
                    <ul class="navbar-nav top-navbar-nav-ms">
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fw-medium active" href="drop">Drops</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fw-medium" href="claim">My Claims</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fw-medium" href="settings">Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xxl-4">
                <input type="text" id="search_coins" class="form-control form-control-search rounded-pill border-0" placeholder="Search for communities...">
            </div>
            <div class="col-xxl-4">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="form-check form-switch form-switch-start">
                        <label class="form-check-label fs-5 fw-medium" for="UserSwitch">User View</label>
                        <input class="form-check-input" type="checkbox" id="UserSwitch">                
                    </div>
                    <div id="user_menu" class="dropdown d-flex align-items-center">
                        <div class="h-divider mx-12"></div>
                        <a class="nav-link dropdown-toggle mobile-dropdown-toggle d-flex align-items-center px-0 text-fiord" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avator-md d-flex justify-content-center align-items-center rounded-circle border border-black bg-purple"></div>
                            <div class="mx-4 h5 mb-0 d-none d-lg-flex" id="user_address"></div>
                        </a>
                        <ul id="wallet_addresses" class="dropdown-menu dropdown-menu-end list-wallet" aria-labelledby="navbarDropdown"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>