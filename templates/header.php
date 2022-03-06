<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white two-bg">
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
                <ul id="wallet_addresses" class="dropdown-menu dropdown-menu-end list-wallet" aria-labelledby="navbarDropdown">

                </ul>
            </div>
        </div>
    </div>
</nav>