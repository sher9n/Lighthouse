<div class="container-fluid g-0 h-100">
    <div class="row g-0 h-100">
        <div class="col-lg-6 bg-white">

                <form id="claimForm" method="post" action="claim" autocomplete="off" class="d-flex flex-column h-100">
                    <div class="px-26">
                        <div class="display-5 fw-medium mt-25">Submit a claim for <?php echo $__page->site['site_name']; ?></div>
                        <div class="text-muted mt-1">Fill out the details of your contribution</div>
                        <div class="mt-23">
                            <label for="DAOName" class="form-label">Which wallet do you want to distribute NTTs to?</label>
                            <input type="text" name="w_addr_text" id="w_addr_text" class="form-control form-control-lg" placeholder="0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507">
                            <div id="sel_wallet_address" class="fs-3 fw-semibold mb-3"></div>
                            <input type="hidden" class="form-control form-control-lg mb-6" name="wallet_address" id="wallet_address">
                            <a role="button" id="add_wallet" onclick="addWallet()" class="btn btn-light" href="#">Add Wallet</a>
                        </div>
                        <div class="mt-16">
                            <label for="LHT" class="form-label">How many NTTs do you want to distribute?</label>
                            <input type="number" class="form-control form-control-lg mb-6"  name="ntts" id="ntts" placeholder="100">
                            <div class="d-flex">
                                <div class="badge bg-light d-flex align-items-center">Score Impact: <span class="text-success ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-up.png" class="ms-1"></div>
                                <div class="badge bg-light d-flex align-items-center ms-3">Rank Impact: <span class="text-danger ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-bottom.png" class="ms-1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto border-top py-5 px-26">
                        <div class="d-flex justify-content-between">
                            <div></div><!-- Empty div for button algnment -->
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </div>
                </form>

        </div>
        <div class="col-lg-6 bg-cod-gray h-100 d-flex justify-content-center">
            <div class="align-self-center">
                <img src="<?php echo app_cdn_path; ?>img/img-claims-01.png" >
            </div>
            <div class="site-badge d-flex align-items-center">
                <div class="opacity-50 text-white fw-medium">Powered by</div> <img src="<?php echo app_cdn_path; ?>img/logo-text.png" class="ms-2">
            </div>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">

    $(document).ready(function() {

        selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
        if (selectedAccount) {
            $("#wallet_address").val(selectedAccount);
            $("#sel_wallet_address").html(selectedAccount);
            $("#w_addr_text").remove();
            $("#w_addr_text-error").remove();
            $('#add_wallet').html('CHANGE WALLET');
        }

        $('#claimForm').validate({
            rules: {
                wallet_address:{
                    required: true
                },
                ntts:{
                    required: true
                },
                w_addr_text:{
                    required: true
                }
            },
            messages: {
                w_addr_text : "Please connect the wallet"
            },
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    success: function(data){
                        if(data.success == true){
                            window.location = data.url;
                        }
                        else{
                            $('#'+data.element).addClass('form-control-lg error');
                            $('<label class="error">'+data.msg+'</label>').insertAfter('#'+data.element);
                        }
                    }
                });
            }
        });
    });
</script>