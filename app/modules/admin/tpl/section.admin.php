<main>
    <!-- Modal backbround image -->
    <div class="modal-background"></div>
    <!-- Modal backbround image END -->
</main>
<!-- Modal -->
<div class="modal show" id="AdminCenter" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="<?php echo app_cdn_path; ?>img/anim-lighthouse-circle.gif"  width="100" height="100" class="align-self-center">
                <div class="fs-2 fw-semibold mt-15">MyDAO Admin Center</div>
                <div class="fw-medium mt-3">To get started please connect a whitelisted wallet</div>
                <?php if($__page->solana != true){ ?>
                    <button type="button" id="add_wallet" class="add_wallet btn btn-primary mt-20 px-10">Connect Wallet</button>
                <?php }else{ ?>
                    <button type="button" id="add_wallet" onclick="addSolanaWallet()"  class="btn btn-primary mt-20 px-10">Connect Wallet</button>
                <?php } ?>
                <div id="whitelist_error" class="text-danger fw-medium mt-20 d-none">This wallet does not have access to MyDAO. <br>
                    Please connect with a whitelisted wallet.</div>
            </div>
        </div>
    </div>
</div>

<!-- Phantom Modal -->
<div class="modal show" id="AdminPhantom" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content p-2">
            <a class="text-center link-modal" href="#" onclick="getSolanaAccount()">
                <img src="<?php echo app_cdn_path; ?>img/phantom-logo.svg" height="42">
                <div class="modal-provider-name">Phantom</div>
                <div type="button"  class="modal-provider-description">Connect to your Phantom Wallet</div>
            </a>
        </div>
    </div>
</div>
<!-- Modal Send some NTTs -->
<div class="modal fade" id="SendNTT" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="display-5 fw-medium">Send some NTTs</div>
        <div class="fs-5 fw-medium mt-20">Which wallet do you want to distribute NTTs to?</div>
        <div class="fs-3 fw-semibold mt-3">0x9aBbegiow923h9ig2nioopg24380b</div>
        <div class="fs-5 fw-medium mt-18 mb-3">How many NTTs do you want to send?</div>
        <div class="container-fluid">
          <div class="row gap-3">
            <div class="col border rounded-3 py-3 px-7 fs-3 d-flex align-items-center">120</div>
            <div class="col bg-light rounded-3 py-3 px-7">
              <div class="fs-3">4.5K</div>
              <div class="d-flex align-items-center">Score Impact: <span class="text-success ms-2">24</span><img src="img/arrow-up.png"></div>
            </div>
            <div class="col bg-light rounded-3 py-3 px-7">
              <div class="fs-3">2.32K</div>
              <div class="d-flex align-items-center">Rank Impact: <span class="text-danger ms-2">2</span><img src="img/arrow-bottom.png"></div>
            </div>
          </div>
        </div>
        <div class="fs-5 fw-medium mt-18 mb-3">What's the reason for this distribution?</div>
        <textarea class="form-control form-control-lg fs-3 fw-medium" id="" rows="2" placeholder=""></textarea>
        <div class="fs-5 fw-medium mt-18 mb-3">Tag this distribution to query it later.</div>
        <textarea class="form-control form-control-lg" id="" rows="2" placeholder=""></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white" data-bs-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace();

    $(document).on("click", '.add_wallet', function(event) {
        $("#AdminCenter").modal('hide');
        $('#wallet').modal('show');
    });

    $(window).on('load', function() {
        $('#AdminCenter').modal('show');
    });
</script>