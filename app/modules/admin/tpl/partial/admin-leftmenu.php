<aside class="admin-left-aside">
    <div class="ms-3">
        <img src="<?php echo app_cdn_path; ?>img/logo.png" >
    </div>
    <div class="main-nav">
        <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo __ROUTER_PATH=='/admin-dashboard'?'active':'';?>" aria-current="page" href="admin-dashboard">
                <i data-feather="layers"></i>
                <div class="ms-12">Dashboard</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo __ROUTER_PATH=='/admin-approvals'?'active':'';?>" href="admin-approvals">                
                <i data-feather="check-circle"></i>
                <div class="ms-12">Contribution Stream</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo __ROUTER_PATH=='/admin-ntts'?'active':'';?>" href="admin-ntts">                
                <i data-feather="send"></i>
                <div class="ms-12">Submit Contribution</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo __ROUTER_PATH=='/admin-stewards'?'active':'';?>" href="admin-stewards">               
                <i data-feather="user"></i>
                <div class="ms-12">Stewards</div>
            </a>
        </li>
        <li class="nav-item tree-toggle">
            <a class="nav-link <?php echo __ROUTER_PATH=='/admin-integrations'?'active':'';?>"  href="admin-integrations">
                <!-- <img src="img/icon-integrations.svg">  -->                
                <i data-feather="terminal"></i>
                <div class="ms-12">Integrations</div>
            </a>
            <ul class="nav-sub tree" style="display: none;">
                <li class="nav-item"><a class="nav-link" href="#Forms">> Forms</a></li>
                <li class="nav-item"><a class="nav-link" href="#Interactions">> Interactions</a></li>
                <li class="nav-item"><a class="nav-link" href="#Identity">> Identity</a></li>
                <li class="nav-item"><a class="nav-link" href="#Apps">> Apps</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo __ROUTER_PATH=='/admin-settings'?'active':'';?>" href="admin-settings">                
                <i data-feather="settings"></i>
                <div class="ms-12">Settings</div>
            </a>
        </li>
    </ul>
    </div>
    <div class="user-nav dropup">
        <div class="dropdown">
            <button class="btn btn-white dropdown-toggle d-flex align-items-center p-0 border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="non-avator me-3"></div>
                <div class="me-2"><?php echo \Core\Utils::WalletAddressFormat($__page->sel_wallet_adr); ?></div>
            </button>
            <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a class="dropdown-item" id="disconnect_wallet" href="#">
                        <i data-feather="log-out"></i>
                        <div class="ms-12">Disconnect</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

<!-- skeleton loader -->
<aside class="admin-left-aside d-none">
    <div class="ms-3">
        <div class="skeleton-logo loading rounded"></div>
    </div>
    <div class="main-nav">
        <ul class="nav flex-column loading">
            <li class="nav-item">
                <div class="nav-link">
                    <div class="skeleton-nav-icon rounded-circle"></div>
                    <div class="skeleton-nav-text rounded ms-12"></div>
                </div>                
            </li>
            <li class="nav-item">
                <div class="nav-link">
                    <div class="skeleton-nav-icon rounded-circle"></div>
                    <div class="skeleton-nav-text rounded ms-12"></div>
                </div>                
            </li>
            <li class="nav-item">
                <div class="nav-link">
                    <div class="skeleton-nav-icon rounded-circle"></div>
                    <div class="skeleton-nav-text rounded ms-12"></div>
                </div>                
            </li>
            <li class="nav-item">
                <div class="nav-link">
                    <div class="skeleton-nav-icon rounded-circle"></div>
                    <div class="skeleton-nav-text rounded ms-12"></div>
                </div>                
            </li>
            <li class="nav-item">
                <div class="nav-link">
                    <div class="skeleton-nav-icon rounded-circle"></div>
                    <div class="skeleton-nav-text rounded ms-12"></div>
                </div>                
            </li>
            <li class="nav-item">
                <div class="nav-link">
                    <div class="skeleton-nav-icon rounded-circle"></div>
                    <div class="skeleton-nav-text rounded ms-12"></div>
                </div>                
            </li>
        </ul>
    </div>
    <div class="user-nav">
        <div class="d-flex align-items-center">
            <div class="skeleton-nav-icon-lg rounded-circle"></div>
            <div class="skeleton-nav-text-lg rounded ms-12"></div>
        </div>
    </div>
</aside>
<!-- skeleton loader END -->