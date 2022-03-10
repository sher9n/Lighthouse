<div class="bg-we-peep alert-show">
    <div class="container">
        <div class="py-7 d-flex align-items-center">
            <img src="<?php echo app_cdn_path; ?>img/icon-info.svg" class="img-fluid" />
            <div class="ms-3">To use Lighthouse, please switch to the Ethereum network in your wallet.</div>
        </div>
    </div>
</div>
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white two-bg">
    <div class="container">
        <div class="dropdown dropdown-mobile-nav d-lg-none">
            <button class="btn btn-link dropdown-toggle mobile-dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">All Communities</a></li>
                <li><a class="dropdown-item" href="#">Rewards</a></li>
            </ul>
        </div>
        <div class="text-lg-center w-lg-24">
            <a class="" href="#">
                <img src="<?php echo app_cdn_path; ?>img/logo.svg" class="img-fluid" />
            </a>
        </div>
        <div id="user_menu" class="ms-lg-auto dropdown">
            <a class="nav-link dropdown-toggle mobile-dropdown-toggle d-flex align-items-center pe-0 text-fiord" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avator-md d-flex justify-content-center align-items-center rounded-circle border border-black bg-purple"></div>
                <div class="mx-4 h5 mb-0 d-none d-lg-flex" id="user_address"></div>
            </a>
            <ul id="wallet_addresses" class="dropdown-menu dropdown-menu-end list-wallet" aria-labelledby="navbarDropdown"></ul>
        </div>
    </div>
</nav>