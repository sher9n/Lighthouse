<!-- wallet Modal -->
<div class="modal fade" id="admin_wallet" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content p-2">
            <a class="text-center link-modal" href="#" onclick="changeToEth()">
                <img src="<?php echo app_cdn_path; ?>img/metamast-logo.svg" height="42">
                <div class="modal-provider-name">MetaMask</div>
                <div type="button" class="modal-provider-description">Connect to your MetaMask Wallet</div>
            </a>
            <hr class="dropdown-divider">
            <a class="text-center link-modal" href="#" onclick="changeToWCEth()">
                <img src="<?php echo app_cdn_path; ?>img/walletconnect-logo.svg" height="42">
                <div class="modal-provider-name">WalletConnect</div>
                <div type="button" class="modal-provider-description">Scan with WalletConnect to connect</div>
            </a>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://unpkg.com/feather-icons"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/js-snackbar.js"></script>
<!--Wallet connect JS-->
<script type="text/javascript" src="https://unpkg.com/@solana/web3.js@latest/lib/index.iife.js"></script>
<script type="text/javascript" src="https://unpkg.com/@walletconnect/web3-provider@1.7.1/dist/umd/index.min.js"></script>
<script src="https://cdn.ethers.io/lib/ethers-5.2.umd.min.js" type="application/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/web3/3.0.0-rc.5/web3.min.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/wallet.connect.js"></script>
<script type="text/javascript" src="<?php echo app_cdn_path; ?>js/connect-solana.js"></script>
<?php
foreach ($__page->js as $page_js) { ?>
    <script type="text/javascript" src="<?php echo $page_js; ?>"></script>
    <?php
}
?>
<script>

    function showMessage(status,time,message) {
        SnackBar({
            status: status,
            position: "bl",
            icon: "	 ",
            timeout: time,
            message: message
        });
    }

    $(document).ready(function() {

        $(document).on("click", '#disconnect_wallet', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'disconnect_wallet',
                dataType: 'json',
                type: 'GET',
                success: function (response) {
                    if (response.success == true) {
                        if(response.solana == true)
                            disconnectAccount();
                        else
                            onDisconnect();
                        window.location = 'admin';
                    }
                }
            });
        });
    });
</script>
