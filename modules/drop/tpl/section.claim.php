<main class="main-wrapper">
    <div class="container wallet_disconnected d-none">
        <div class="row align-items-center">
            <div class="col mt-30">
                <div class="text-center">
                    <img src="<?php echo app_cdn_path; ?>img/img-claim.svg" >
                </div>
                <div class="fs-1 fw-semibold text-center mt-20">Hold up!</div>
                <div class="fs-5 fw-medium text-center text-muted mt-6">Connect your wallet to see your claims here.</div>
                <div class="text-center mt-18">
                    <button type="submit" onclick="onConnect()" class="btn_connect btn btn-primary btn-lg px-18 text-uppercase">Connect Wallet</button>
                </div>
            </div>
        </div>
    </div>
    <div id="connected_claims" class="container wallet_connected d-none"></div>
</main>
<?php include_once app_root . '/templates/dash_foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        checkAccountData();
    });
</script>