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
            <div class="ms-lg-auto dropdown">
                <a class="nav-link dropdown-toggle mobile-dropdown-toggle d-flex align-items-center pe-0 text-fiord" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avator-md d-flex justify-content-center align-items-center rounded-circle border border-black bg-purple"></div>
                    <div class="mx-4 h5 mb-0 d-none d-lg-flex" id="user_address"></div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end list-wallet" aria-labelledby="navbarDropdown">
                    <li class="list-wallet-item active">
                        <div class="dropdown-item d-flex">
                            <a href="#" class="nav-item text-decoration-none d-flex align-items-center">
                                <span class="">0x2347...5539</span>
                                <img src="<?php echo app_cdn_path; ?>img/icon-01.png" class="ms-2" />
                            </a>
                            <a href="#" class="ms-auto text-decoration-none link-icon-del">
                                <svg class="feather feather-md">
                                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#trash"/>
                                </svg>
                            </a>
                        </div>
                    </li>
                    <li class="list-wallet-item">
                        <div class="dropdown-item d-flex">
                            <a href="#" class="nav-item text-decoration-none d-flex align-items-center">
                                <span class="">0x2347...4786</span>
                                <img src="<?php echo app_cdn_path; ?>img/icon-02.png" class="ms-2" />
                            </a>
                            <a href="#" class="ms-auto text-decoration-none link-icon-del">
                                <svg class="feather feather-md">
                                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#trash"/>
                                </svg>
                            </a>
                        </div>
                    </li>
                    <li class="list-wallet-item">
                        <div class="dropdown-item d-flex align-items-center">
                            <a href="#" class="text-primary text-decoration-none">
                                Add a Wallet
                            </a>
                            <a href="#" class="ms-auto text-danger text-decoration-none d-flex align-items-center">
                                <svg class="feather feather-md">
                                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#power"/>
                                </svg>
                                <div id="btn-disconnect" class="ms-3 lh-1">Exit</div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

    </div>
</nav>