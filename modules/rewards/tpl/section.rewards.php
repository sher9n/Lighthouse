<main class="main-wrapper">
    <div class="container d-none">
        <div class="row align-items-center">
            <div class="col mt-30">
                <div class="text-center">
                    <img src="<?php echo app_cdn_path; ?>img/img-claim.svg" >
                </div>
                <div class="fs-1 fw-semibold text-center mt-20">Let's go!</div>
                <div class="fs-5 fw-medium text-center text-muted mt-6">Connect your wallet to see your claims here.</div>
                <div class="text-center mt-18">
                    <button type="submit" onclick="onConnect()" class="btn_connect btn btn-primary btn-lg px-18 text-uppercase">Connect Wallet</button>
                </div>
            </div>
        </div>
    </div>
    <div id="connected_claims" class="container wallet_connected"></div>
    <div id="dis_connected_claims" class="container wallet_disconnected">
        <div class="row">
            <img src="<?php echo app_cdn_path ?>img/img-placeholder.png" class="img-fluid">
        </div>
    </div>
    <div id="Skeleton_claims" class="container d-none">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12 loading">
                    <div class="card-body overflow-hidden pt-18">
                        <div class="text-center">
                            <div class="card-logo m-auto d-flex justify-content-center">
                                <div class="round-lg img-overlap z-index-inherit"></div>
                            </div>
                            <div class="text-content-xxxl mt-10 mb-3 w-70 m-auto"></div>
                            <div class="rounded-pill text-content-xxxxl w-50 m-auto"></div>
                            <div class="card-hr-line">
                                <hr class="my-13 mx-5">
                            </div>
                            <div class="text-content-xxxxxl mb-6 m-auto w-70"></div>
                            <div class="text-content-xxl m-auto w-90"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12 loading">
                    <div class="card-body overflow-hidden pt-18">
                        <div class="text-center">
                            <div class="card-logo m-auto d-flex justify-content-center">
                                <div class="round-lg img-overlap z-index-inherit"></div>
                            </div>
                            <div class="text-content-xxxl mt-10 mb-3 w-70 m-auto"></div>
                            <div class="rounded-pill text-content-xxxxl w-50 m-auto"></div>
                            <div class="card-hr-line">
                                <hr class="my-13 mx-5">
                            </div>
                            <div class="text-content-xxxxxl mb-6 m-auto w-70"></div>
                            <div class="text-content-xxl m-auto w-90"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12 loading">
                    <div class="card-body overflow-hidden pt-18">
                        <div class="text-center">
                            <div class="card-logo m-auto d-flex justify-content-center">
                                <div class="round-lg img-overlap z-index-inherit"></div>
                            </div>
                            <div class="text-content-xxxl mt-10 mb-3 w-70 m-auto"></div>
                            <div class="rounded-pill text-content-xxxxl w-50 m-auto"></div>
                            <div class="card-hr-line">
                                <hr class="my-13 mx-5">
                            </div>
                            <div class="text-content-xxxxxl mb-6 m-auto w-70"></div>
                            <div class="text-content-xxl m-auto w-90"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12 loading">
                    <div class="card-body overflow-hidden pt-18">
                        <div class="text-center">
                            <div class="card-logo m-auto d-flex justify-content-center">
                                <div class="round-lg img-overlap z-index-inherit"></div>
                            </div>
                            <div class="text-content-xxxl mt-10 mb-3 w-70 m-auto"></div>
                            <div class="rounded-pill text-content-xxxxl w-50 m-auto"></div>
                            <div class="card-hr-line">
                                <hr class="my-13 mx-5">
                            </div>
                            <div class="text-content-xxxxxl mb-6 m-auto w-70"></div>
                            <div class="text-content-xxl m-auto w-90"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Claim Modal -->
<div class="modal fade" id="ClaimModal" tabindex="-1" aria-labelledby="ClaimModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body py-30">
                <div class="text-center">
                    <img src="<?php echo app_cdn_path; ?>img/img-claim-popup.svg" >
                </div>
                <div class="fs-1 fw-semibold text-center mt-20">Claim successful!</div>
                <div class="fs-5 fw-medium text-center text-muted mt-6">This reward will be airdropped to you soon</div>
                <div class="text-center mt-18">
                    <button type="button" id="claim_continue" class="btn btn-primary btn-lg px-18 text-uppercase">COntinue</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        if (sessionStorage.getItem('claim_success') && sessionStorage.getItem('claim_success') == 1) {
            sessionStorage.setItem("claim_success", 0);
            $('#ClaimModal').modal('toggle');
        }

        checkAccountData();

        $(document).on("click","#claim_continue",function (e) {
            $('#ClaimModal').modal('toggle');
        });

        $(document).on("keyup","#search_coins",delay(function (e) {
            e.preventDefault();
            var search = $(this).val();
            getClaims(search);
        }));
    });
</script>