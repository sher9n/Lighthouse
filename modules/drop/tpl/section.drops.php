<main class="main-wrapper">
    <div class="container">
        <div class="d-lg-none text-center mb-8">
            <button type="button" id="btn-connect" class="btn btn-primary btn-lg text-uppercase btn-m-block ">Connect Wallet</button>
        </div>
        <!-- Skeleton loader -->
        <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12 loading position-relative">
                    <div class="card-body py-18">
                        <div class="text-center">
                            <div class="card-logo m-auto d-flex justify-content-center">
                                <div class="round-lg img-overlap z-index-inherit"></div>
                                <div class="round-lg img-overlap z-index-inherit"></div>
                            </div>
                            <div class="mt-10 mb-3 text-content-xxxl"></div>

                            <div class="rounded-pill mb-10 text-content-xxxxl w-50 m-auto"></div>
                            <div class="mb-3 text-content-xxxxxl w-70 m-auto"></div>
                            <div class="mb-10 text-content-lg w-30 m-auto"></div>
                            <div class="text-content-xs m-8"></div>
                            <div class="mb-10 text-content-sm w-20 m-auto"></div>
                            <div class="btn-content-lg m-auto w-70 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12 loading position-relative">
                    <div class="card-body py-18">
                        <div class="text-center">
                            <div class="card-logo m-auto d-flex justify-content-center">
                                <div class="round-lg img-overlap z-index-inherit"></div>
                                <div class="round-lg img-overlap z-index-inherit"></div>
                            </div>
                            <div class="mt-10 mb-3 text-content-xxxl"></div>

                            <div class="rounded-pill mb-10 text-content-xxxxl w-50 m-auto"></div>
                            <div class="mb-3 text-content-xxxxxl w-70 m-auto"></div>
                            <div class="mb-10 text-content-lg w-30 m-auto"></div>
                            <div class="text-content-xs m-8"></div>
                            <div class="mb-10 text-content-sm w-20 m-auto"></div>
                            <div class="btn-content-lg m-auto w-70 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12 loading position-relative">
                    <div class="card-body py-18">
                        <div class="text-center">
                            <div class="card-logo m-auto d-flex justify-content-center">
                                <div class="round-lg img-overlap z-index-inherit"></div>
                                <div class="round-lg img-overlap z-index-inherit"></div>
                            </div>
                            <div class="mt-10 mb-3 text-content-xxxl"></div>

                            <div class="rounded-pill mb-10 text-content-xxxxl w-50 m-auto"></div>
                            <div class="mb-3 text-content-xxxxxl w-70 m-auto"></div>
                            <div class="mb-10 text-content-lg w-30 m-auto"></div>
                            <div class="text-content-xs m-8"></div>
                            <div class="mb-10 text-content-sm w-20 m-auto"></div>
                            <div class="btn-content-lg m-auto w-70 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow mb-12 loading position-relative">
                    <div class="card-body py-18">
                        <div class="text-center">
                            <div class="card-logo m-auto d-flex justify-content-center">
                                <div class="round-lg img-overlap z-index-inherit"></div>
                                <div class="round-lg img-overlap z-index-inherit"></div>
                            </div>
                            <div class="mt-10 mb-3 text-content-xxxl"></div>

                            <div class="rounded-pill mb-10 text-content-xxxxl w-50 m-auto"></div>
                            <div class="mb-3 text-content-xxxxxl w-70 m-auto"></div>
                            <div class="mb-10 text-content-lg w-30 m-auto"></div>
                            <div class="text-content-xs m-8"></div>
                            <div class="mb-10 text-content-sm w-20 m-auto"></div>
                            <div class="btn-content-lg m-auto w-70 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Skeleton loader END -->

        <div id="drops_cards" class="row"></div>
    </div>
</main>
<?php include_once app_root . '/templates/dash_foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        checkAccountData();
    });

    $(document).on("click",".drop_details",function (e) {
        e.preventDefault();
        var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
        var sel_wallet_add = sessionStorage.getItem('lh_sel_wallet_add');
        var data = {'adds': lh_wallet_adds, 'sel_add': sel_wallet_add};

        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            data:data,
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    $('#drops_cards').html(response.html);
                }
            }
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });

</script>