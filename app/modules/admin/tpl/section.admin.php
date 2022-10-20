<main>
    <!-- Modal backbround image -->
    <div class="modal-background"></div>
    <!-- Modal backbround image END -->
</main>
<!-- Phantom Modal -->
<div class="modal show" id="AdminPhantom" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-01">
      <div class="modal-content">
        <div class="modal-body p-10">
          <div class="fs-2 fw-semibold mb-22 mt-3">Connect your wallet</div>
            <ui class="list-wallet">
              <li class="list-wallet-item rounded border">
                  <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" onclick="getSolanaAccount()"  href="#">
                      <span class="fs-3">Phantom</span>
                      <img src="<?php echo app_cdn_path; ?>img/phantom-logo.svg"  width="40" height="40" class="">
                  </a>
              </li>
                <li class="list-wallet-item rounded border">
                    <a class="list-wallet-item-link d-flex justify-content-between align-items-center text-decoration-none" onclick="getSolanaAccount(true)"  href="#">
                        <span class="fs-3">Solflare</span>
                        <img src="<?php echo app_cdn_path; ?>img/solflare-logo.svg"  width="40" height="40" class="">
                    </a>
                </li>
            </ui>
        </div>
      </div>
    </div>
</div>
<?php include_once app_root . '/templates/admin-foot.php'; ?>
<script>
    $(window).on('load', function() {
        <?php if($__page->blockchain == SOLANA){ ?>
            addSolanaWallet();
        <?php }else{ ?>
            $('#wallet').modal('show');
        <?php } ?>
    });
</script>