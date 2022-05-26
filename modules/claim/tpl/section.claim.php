<style>
    .bg-claim-image {
        background-image: url(<?php echo app_cdn_path. $__page->img_url; ?>);
    }
</style>
<div class="container-fluid g-0 h-100">
    <div class="row g-0 h-100">
        <div class="col-md-6 bg-white">

                <form id="claimForm" method="post" action="claim" autocomplete="off" class="d-flex flex-column h-100">
                    <div class="px-6 px-xl-26">
                        <div class="display-5 fw-medium mt-25">Submit a claim for <?php echo $__page->site['site_name']; ?></div>
                        <div class="text-muted mt-1">Fill out the details of your contribution</div>
                        <div class="mt-23">
                            <label for="DAOName" class="form-label">Which wallet do you want to distribute NTTs to?</label>
                            <input type="text" name="wallet_address" id="wallet_address" class="form-control form-control-lg">
                            <div class="fs-3 fw-semibold mb-3 text-break"></div>
                            <?php if($__page->solana == true){ ?>
                                <a role="button" id="add_wallet" onclick="getSolanaAccount()" class="btn btn-light" href="#">Add Wallet</a>
                            <?php }else{ ?>
                                <a role="button" id="add_wallet" onclick="addWallet()" class="btn btn-light" href="#">Add Wallet</a>
                            <?php } ?>
                        </div>
                        <div class="mt-16">
                            <label for="LHT" class="form-label">How many NTTs do you want to distribute?</label>
                            <input type="number" class="form-control form-control-lg"  name="ntts" id="ntts" placeholder="100">
                            <div class="d-flex flex-column flex-lg-row mt-6">
                                <div class="badge bg-light d-flex align-items-center">Score Impact: <span class="text-success ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-up.png" class="ms-1"></div>
                                <div class="badge bg-light d-flex align-items-center ms-lg-3 mt-3 mt-lg-0">Rank Impact: <span class="text-danger ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-bottom.png" class="ms-1"></div>
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
        <div class="col-md-6 h-100 d-flex justify-content-center">
            <div class="bg-claim-image"></div> <!-- Full width image -->
            <div class="site-badge d-flex align-items-center">
                <div class="opacity-75 text-white fw-medium">Powered by</div> <img src="<?php echo app_cdn_path; ?>img/logo-text.png" class="ms-2">
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