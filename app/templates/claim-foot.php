<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/js-snackbar.js"></script>
<!--Wallet connect JS-->
<script type="text/javascript" src="https://unpkg.com/@solana/web3.js@latest/lib/index.iife.js"></script>
<script type="text/javascript" src="https://unpkg.com/@walletconnect/web3-provider@1.7.1/dist/umd/index.min.js"></script>
<script src="https://cdn.ethers.io/lib/ethers-5.2.umd.min.js" type="application/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/web3/3.0.0-rc.5/web3.min.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/wallet.connect.js"></script>
<script type="text/javascript" src="<?php echo local_cdn_path; ?>js/connect-solana.claim.js"></script>
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
            position: "br",
            icon: "	 ",
            timeout: time,
            message: message
        });
    }
</script>
