<main class="main-wrapper">
    <div class="container">
        <div class="d-lg-none text-center mb-8">
            <button type="button" id="btn-connect" class="btn btn-primary btn-lg text-uppercase btn-m-block ">Connect Wallet</button>
        </div>
        <!-- Skeleton loader -->
        <div id="drop_skelton" class="row">
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
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        checkAccountData();
    });

    $(document).on("keyup","#search_coins",delay(function (e) {
        e.preventDefault();
        var search = $(this).val();
        getDrops(false,search);
    }));

    $(document).on("click",".drop_details",function (e) {
        e.preventDefault();
        $('#drops_cards').html('<div class="row justify-content-md-center"><div class="col-lg-6"><div class="card shadow mb-12 loading position-relative"><div class="card-body pt-18"><div class="d-flex align-items-center justify-content-center"><div class="card-logo d-flex me-6"><div class="round-lg"></div></div><div><div class="text-content-xxxl mb-6 mw-180"></div><div class="rounded-pill text-content-xxxxl w-70"></div></div></div><div class="my-17 three-line-text-content"></div><div class="text-content-xxxxxl m-auto w-80"></div><div class="mt-2 text-content-xxl m-auto w-20"></div><div class="text-content-xs m-8"></div><div class="text-content-xxl m-auto w-30 mb-10"></div><div class="mt-12"><div class="text-content-xxxl mb-5"></div><div class="text-content-xxxl mb-5"></div></div></div><div class="dash-divider"></div><div class="card-body text-center pt-6 pb-18"><div class="mb-10 text-content-lg w-20 m-auto"></div><div class="btn-content-lg m-auto w-30 rounded"></div></div></div></div></div>');

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

    $(document).on("click","#claim_airdrop",function (e){
       e.preventDefault();
       var drop_id = $(this).data('drop_id');
       var wallet_adr = sessionStorage.getItem('lh_sel_wallet_add');
        var data = {'drop_id': drop_id, 'wallet_adr': wallet_adr};

        $.ajax({
            url: 'claims',
            type: 'POST',
            data:data,
            dataType: 'json',
            success: function (response) {
                if (response.success != true)
                    sessionStorage.setItem("claim_success", 1);
                window.location.replace("claims");
            }
        });
    });


    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });

</script>