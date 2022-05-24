<div class="dropdown">
    <button class="btn btn-white dropdown-toggle d-flex align-items-center p-0 border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="non-avator me-3"></div>
        <div class="me-2"><?php echo $format_adr; ?></div>
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