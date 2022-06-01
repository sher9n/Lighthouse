
<div class="container-fluid g-0 h-100">
    <div class="row g-0 h-100">
        <div class="col-lg-6 bg-white">
            
                <form id="claimForm" method="post" action="claim-reason" autocomplete="off" class="d-flex flex-column h-100">
                    <div class="px-26">
                        <div class="display-5 fw-medium mt-25">Your claim has been
successfully submitted!</div>
                        <div class="fs-3 mt-12">To view ntMyDAO in your wallet, add the contract below.</div>
                            <div class="mt-12">
                                <button type="submit" class="btn btn-primary d-flex align-items-center"><img src="<?php echo app_cdn_path; ?>img/logo-fox.png" class="me-2">Add to Metamask</button>
                            </div>
                            <div class="mt-16">
                                <label for="claimCategorize" class="form-label">Or add ntMyDAO manually:</label>
                                <div class="d-flex align-items-center"><span class="fw-medium fs-3 text-break">0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507</span><i data-feather="copy" class="ms-3 text-primary"></i></div>
                            </div>                            
                    </div>
                    <div class="mt-auto border-top py-5 px-26">
                        <div class="d-flex justify-content-end">                            
                            <button type="submit" class="btn btn-dark">Submit NEW Claim</button>
                        </div>
                    </div>
                </form>

        </div>
        <div class="col-lg-6 h-100 d-flex justify-content-center">
            <div class="bg-claim-image"></div> <!-- Full width image -->
            <div class="site-badge d-flex align-items-center">
                <div class="opacity-75 text-white fw-medium">Powered by</div> <img src="<?php echo app_cdn_path; ?>img/logo-text.png" class="ms-2">
            </div>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">
    feather.replace();
    $(document).ready(function() {

    });
</script>