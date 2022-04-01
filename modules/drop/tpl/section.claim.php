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
    <div class="container">
        <!-- Skeleton loader Your claims -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-12 loading position-relative">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="text-content-xxxxxl w-50 m-auto"></div>
                            <div class="mt-4 text-content-xxl w-70 m-auto"></div>
                            <form  class="row g-3 justify-content-center mt-2"id="notifyForm" method="post" action="notify" autocomplete="off" novalidate="novalidate">
                                <div class="col-4">
                                    <div class="input-lg rounded"></div>
                                </div>
                                <div class="col-md-auto">
                                    <div class="btn-content-lg mw-180 rounded"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Skeleton loader Your claims END -->

        <!-- Skeleton loader Your claims Cards -->
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
         <!-- Skeleton loader Your claims Cards END -->

    </div>
</main>
<?php include_once app_root . '/templates/dash_foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        checkAccountData();
    });
</script>