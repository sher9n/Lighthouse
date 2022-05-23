<aside class="left-aside">
    <div class="ms-3">
        <img src="<?php echo app_cdn_path; ?>img/logo.svg" >
    </div>
    <div class="main-nav">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="admin">
                <svg class="feather">
                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#layers"/>
                </svg>
                <div class="ms-12">Dashboard</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin-approvals">
                <svg class="feather">
                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#check-circle"/>
                </svg>
                <div class="ms-12">Approvals</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin-ntts">
                <svg class="feather">
                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#move"/>
                </svg>
                <div class="ms-12">Send NTTs</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin-stewards">
                <svg class="feather">
                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#user"/>
                </svg>
                <div class="ms-12">Stewards</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin-integrations">
                <!-- <img src="img/icon-integrations.svg">  -->
                <svg class="feather">
                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#terminal"/>
                </svg>
                <div class="ms-12">Integrations</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin-settings">
                <svg class="feather">
                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#settings"/>
                </svg>
                <div class="ms-12">Settings</div>
            </a>
        </li>
    </ul>
</div>
    <div class="user-nav dropup">
        <div class="dropdown">
            <button class="btn btn-white dropdown-toggle d-flex align-items-center p-0 border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="non-avator me-3"></div>
                <div class="me-2">0xd91c...4507</div>
            </button>
            <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a class="dropdown-item" href="#">
                        <svg class="feather">
                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#refresh-ccw"/>
                        </svg>
                        <div class="ms-12">Disconnect</div>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#">
                        <svg class="feather">
                            <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#log-out"/>
                        </svg>
                        <div class="ms-12">Change Wallet</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>