<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <div class="text-lg-center w-lg-24">
            <a class="" href="#">
                <img src="<?php echo app_cdn_path; ?>img/logo.svg" class="img-fluid" />
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse fade" id="navbarMain">
            <div class="ms-auto dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center pe-0 text-fiord" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avator-md d-flex justify-content-center align-items-center rounded-circle border border-black bg-purple"></div>
                    <div class="mx-4 h5 mb-0" id="user_address"></div>
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
    </div>
</nav>