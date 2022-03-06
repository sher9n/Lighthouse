<?php
foreach ($adds as $add) { ?>
    <li class="list-wallet-item active">
        <div class="dropdown-item d-flex">
            <a href="#" class="nav-item text-decoration-none d-flex align-items-center">
                <span class=""><?php echo \Core\Utils::coinAddressFormat($add); ?></span>
                <img src="<?php echo app_cdn_path; ?>img/icon-01.png" class="ms-2" />
            </a>
            <a href="#" class="ms-auto text-decoration-none link-icon-del">
                <svg class="feather feather-md">
                    <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#trash"/>
                </svg>
            </a>
        </div>
    </li>
<?php } ?>
<li class="list-wallet-item">
    <div class="dropdown-item d-flex align-items-center">
        <a href="#" id="add_wallet" onclick="addWallet()" class="text-primary text-decoration-none">
            Add a Wallet
        </a>
        <a href="#" class="ms-auto text-danger text-decoration-none d-flex align-items-center">
            <svg class="feather feather-md">
                <use href="<?php echo app_cdn_path; ?>icons/feather-sprite.svg#power"/>
            </svg>
            <div id="btn-disconnect" onclick="onDisconnect()" class="ms-3 lh-1">Exit</div>
        </a>
    </div>
</li>
