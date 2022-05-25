<main>
    <!-- Modal backbround image -->
    <div class="modal-background"></div>
    <!-- Modal backbround image END -->
</main>
<!-- Modal -->
<div class="modal show" id="AdminCenter" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="<?php echo app_cdn_path; ?>img/logo-circle.svg" height="90">
                <div class="fs-2 fw-semibold mt-15">MyDAO Admin Center</div>
                <div class="fw-medium mt-3">To get started please connect a whitelisted wallet</div>
                <button type="button" id="add_wallet" onclick="addWallet()" class="btn btn-primary mt-20 px-10">Connect Wallet</button>
                <!--<div class="text-danger fw-medium mt-20">This wallet does not have access to MyDAO. <br>
                    Please connect with a whitelisted wallet.</div>-->
            </div>
        </div>
    </div>
</div>
<!-- Phantom Modal -->
<div class="modal show" id="AdminPhantom" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content p-2">
            <a class="text-center link-modal" href="#">
                <img src="<?php echo app_cdn_path; ?>img/phantom-logo.svg" height="42">
                <div class="modal-provider-name">Phantom</div>
                <button type="button" onclick="getSolanaAccount()" class="modal-provider-description">Connect to your Phantom Wallet</button>
            </a>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace();

    $(window).on('load', function() {
        <?php if($__page->solana == true){ ?>
            $('#AdminPhantom').modal('show');
        <?php }else{ ?>
            $('#AdminCenter').modal('show');
        <?php } ?>
    });
</script>