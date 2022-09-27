<aside class="admin-left-aside">
    <div class="ms-3">
        <img src="<?php echo $__page->logo_url; ?>" >
    </div>
    <div class="main-nav">
        <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo __ROUTER_PATH=='/contribution'?'active':'';?>" href="contribution">
                <!-- <i data-feather="layers"></i> -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <div class="ms-12">Home</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo __ROUTER_PATH=='/leaderboard'?'active':'';?>" aria-current="page" href="leaderboard">
                <!-- <i data-feather="layers"></i> -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                <div class="ms-12">Leaderboard</div>
            </a>
        </li>

            <li class="nav-item">
                <a class="nav-link <?php echo __ROUTER_PATH=='/approvals'?'active':'';?>" href="approvals">
                    <!-- <i data-feather="check-circle"></i> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <div class="ms-12">Approve Claims</div>
                </a>
            </li>           
            <li class="nav-item">
                <a class="nav-link <?php echo __ROUTER_PATH=='/stewards'?'active':'';?>" href="stewards">
                    <!-- <i data-feather="user"></i> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <div class="ms-12">Stewards</div>
                </a>
            </li>
            <?php if($__page->is_admin){ ?>
            <li class="nav-item tree-toggle">
                <a class="nav-link <?php echo __ROUTER_PATH=='/integrations'?'active':'';?>"  href="integrations">
                    <!-- <img src="img/icon-integrations.svg">  
                    <i data-feather="terminal"></i>-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-terminal"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
                    <div class="ms-12">Integrations</div>
                </a>
                <ul class="nav-sub tree" style="display: none;">
                    <li class="nav-item"><a class="nav-link" href="#Interactions">> Interactions</a></li>
                    <li class="nav-item"><a class="nav-link" href="#Identity">> Identity</a></li>
                    <li class="nav-item"><a class="nav-link" href="#Apps">> Apps</a></li>
                </ul>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link <?php echo __ROUTER_PATH=='/settings'?'active':'';?>" href="settings">
                    <!-- <i data-feather="settings"></i> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <div class="ms-12">Settings</div>
                </a>
            </li>

    </ul>
    </div>
    <div class="user-nav dropup">
        <div class="dropdown">
            <button class="btn btn-white dropdown-toggle d-flex align-items-center p-0 border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="non-avator me-3"></div>
                <div id="login_wallet_adr" class="me-2"><?php echo \Core\Utils::WalletAddressFormat($__page->sel_wallet_adr); ?></div>
            </button>
            <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalConsent">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                        <div class="ms-11">Consent to NTTs</div>
                    </a>
                </li>
<!--                <li>
                    <a class="dropdown-item border-top border-bottom" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                        <div class="ms-11">Change Wallet</div>
                    </a>
                </li>-->
                <li>
                    <a class="dropdown-item" id="disconnect_wallet" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <div class="ms-11">Disconnect</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

<!-- Modal Consent -->
<div class="modal fade" id="ModalConsent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-size-02">
    <div class="modal-content">
      <div class="modal-body">
        <div class="fs-2 fw-semibold mb-9">Your community has activated Governance NTTs</div>
        <div class="fs-4 fw-medium">I consent to receiving non-transferrable governance tokens,
govTOKEN and delegating them to the govTOKEN program on the
Solana blockchain. <br><br>

These tokens are based on a 1,000,000 token supply and rebalance in real-time to reflect the proportional contribution of each community member relative to all contributions.</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white" data-bs-dismiss="modal">I do not consent</button>
        <button type="button" class="btn btn-primary">I consent</button>
      </div>
    </div>
  </div>
</div>

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