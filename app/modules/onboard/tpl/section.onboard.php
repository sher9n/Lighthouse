<main>
    <!-- Modal backbround image -->
    <div class="modal-background"></div>
    <!-- Modal backbround image END -->
</main>

<!-- Modal Select Chain-->
<div class="modal fade" id="selectChain" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-size-01">
    <div class="modal-content">        
      <div class="modal-body p-10">
        <!-- <div class="d-flex justify-content-between"> -->
            <div class="fs-2 fw-semibold mb-22 mt-3">Select the chain you want<br> to launch on</div>
            <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> -->
        <ui class="list-wallet">
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" href="#">
                    <span class="fs-3">Solana</span>
                    <img src="<?php echo app_cdn_path; ?>img/solana-sol-logo.png"  width="40" height="40" class="">
                </a>
            </li>
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" href="#">
                    <span class="fs-3">Gnosis</span>
                    <img src="<?php echo app_cdn_path; ?>img/gnosis-chain-logo.png"  width="40" height="40" class="">
                </a>
            </li>
        </ui>       
      </div>
    </div>
  </div>
</div>

<!-- Modal Connect Wallet-->
<div class="modal fade" id="connectWallet" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-size-01">
    <div class="modal-content">        
      <div class="modal-body p-10">
        <!--<div class="d-flex justify-content-between"> -->
            <div class="fs-2 fw-semibold mb-22 mt-3">Connect your wallet</div>
            <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>  -->
        <ui class="list-wallet">
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" href="#">
                    <span class="fs-3">MetaMask</span>
                    <img src="<?php echo app_cdn_path; ?>img/metamast-logo.svg"  width="40" height="40" class="">
                </a>
            </li>
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" href="#">
                    <span class="fs-3">WalletConnect</span>
                    <img src="<?php echo app_cdn_path; ?>img/walletconnect-logo.svg"  width="40" height="40" class="">
                </a>
            </li>
        </ui>       
      </div>
    </div>
  </div>
</div>

<!-- Modal Connect Wallet Phantom -->
<div class="modal fade" id="connectWalletPhantom" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-size-01">
    <div class="modal-content">        
      <div class="modal-body p-10">
        <!--<div class="d-flex justify-content-between"> -->
            <div class="fs-2 fw-semibold mb-22 mt-3">Connect your wallet</div>
            <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> --> 
        <ui class="list-wallet">
            <li class="list-wallet-item rounded border">
                <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" href="#">
                    <span class="fs-3">Phantom</span>
                    <img src="<?php echo app_cdn_path; ?>img/phantom-logo.svg"  width="40" height="40" class="">
                </a>
            </li>
        </ui>       
      </div>
    </div>
  </div>
</div>

<!-- Modal Setup community -->
<div class="modal fade" id="setupCommunity" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-size-02">
    <div class="modal-content">        
      <div class="modal-body p-10">
        <!--<div class="d-flex justify-content-between"> -->
            <div class="fs-2 fw-semibold mb-22 mt-3">Setup your community</div>
            <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> --> 
        <form>
            <div class="mb-16">
                <label for="" class="form-label">Community name?</label>
                <input type="text" class="form-control form-control-lg" id="" placeholder="MyDAO">
            </div>
            <div class="mb-16">
                <label for="DAOName" class="form-label">Subdomain</label>
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control form-control-lg" name="" id="" placeholder="MyDAO">
                        <span class="input-group-text fw-medium" id="">.lighthouse.xyz</span>
                 </div>                
            </div>
        </form>     
      </div>
      <div class="modal-footer pe-10">
        <button type="button" class="btn btn-success m-0">Create</button>
      </div>
    </div>
  </div>
</div>

<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>
    $(window).on('load', function() {
        $('#setupCommunity').modal('show');
    });
</script>