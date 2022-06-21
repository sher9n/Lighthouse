<main id="body_section">
    <aside class="left-aside">
        <div>
            <img src="<?php echo app_cdn_path; ?>img/logo.png" >
        </div>
        <div class="steps-wrapper">
            <ul class="nav-steps">
                <li class="nav-steps-item">
                    <a href="#" class="nav-steps-link">Create Your NTTs</a>
                </li>
                <li class="nav-steps-item">
                    <a href="#" class="nav-steps-link">Become the First Member</a>
                </li>
                <li class="nav-steps-item active">
                    <a href="#" class="nav-steps-link">Your First Distribution</a>
                </li>
            </ul>
        </div>
    </aside>
    <section class="body-section">
        <a role="button" class="btn btn-back mt-3 ms-3" href="step-2.html"><img src="<?php echo app_cdn_path; ?>img/arrow-left.png"></a>
        <form id="nttsForm" method="post" action="distribution" autocomplete="off">
            <div class="container-fluid">
                <div class="row justify-content-lg-center">
                    <div class="col-xl-7">
                        <div class="display-5 fw-medium mt-25">Take her for a spin</div>
                        <div class="text-muted mt-1">Send yourself some NTTs to test out Lighthouse</div>
                        <div class="mt-23">
                            <label class="form-label mb-4">Which wallet do you want to distribute NTTs to?</label>
                            <input type="text" class="form-control form-control-lg mb-6" name="wallet_address" id="wallet_address">
                            <?php if($__page->solana == true){ ?>
                                <a role="button" id="add_wallet" onclick="getSolanaAccount()" class="btn btn-light mt-6" href="#">Add Wallet</a>
                            <?php }else{ ?>
                                <a role="button" id="add_wallet" class="add_wallet btn btn-light mt-6" href="#">Add Wallet</a>
                            <?php } ?>
                        </div>
                        <div class="mt-16">
                            <label for="LHT" class="form-label">How many NTTs do you want to distribute?</label>
                            <input type="number" class="form-control form-control-lg" name="ntts" id="ntts" placeholder="100">
                            <div class="d-flex flex-column flex-lg-row mt-6">
                                <div class="badge bg-white d-flex align-items-center">Score Impact: <span class="text-success ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-up.png" class="ms-1"></div>
                                <div class="badge bg-white d-flex align-items-center ms-lg-3 mt-3 mt-lg-0">Rank Impact: <span class="text-danger ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-bottom.png" class="ms-1"></div>
                            </div>
                        </div>
                        <div class="mt-16">
                            <label for="claimReason" class="form-label">What's the reason for this distribution?</label>
                            <textarea class="form-control form-control-lg" name="claim_reason" id="claim_reason" rows="3" placeholder="Helpful discussion on Discourse, URL tweet etc..."></textarea>
                        </div>
                        <div class="mt-16">
                            <label for="claimCategorize" class="form-label">Tag this distribution to query it later.</label>
                            <select class="form-control form-control-lg" multiple="multiple" name="claim_tags[]" id="claim_tags" placeholder="Marketing, Development, Strategy"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-bar-bottom">
                <div class="d-flex justify-content-between">
                    <a id="onboard_skip" role="button" class="btn btn-white">Skip</a>
                    <button type="submit" class="btn btn-primary">FINISh</button>
                </div>
            </div>
        </form>
    </section>
    <div class="modal fade" id="NttsGetting" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content pb-16 text-center">
                <img src="<?php echo app_cdn_path; ?>img/anim-delivery.gif"  width="180" height="180" class="align-self-center">
                <div class="fs-2 fw-semibold text-center">Sending your NTTs...</div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="NttsSccess" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content pb-16 text-center">
                <img src="<?php echo app_cdn_path; ?>img/anim-delivery.gif"  width="180" height="180" class="align-self-center">
                <div class="fs-2 fw-semibold text-center">Your NTTs have been sent</div>
                <div class="mt-16 d-flex justify-content-center gap-3">
                    <button type="button" id="go_to_admin" class="btn btn-dark px-10">Go TO Admin Center</button>
                    <button type="button" data-tr_id="" id="view_transaction" class="btn btn-primary px-10">View Transaction</button>
                </div>

            </div>
        </div>
    </div>
</main>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">

    $(document).ready(function(){

        selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
        if(selectedAccount) {
            //$("#sel_wallet_address").html(selectedAccount);
            $("#wallet_address").val(selectedAccount);
            $('.add_wallet').html('CHANGE WALLET');
        }

        $(document).on("click", '.add_wallet', function(event) {
            $('#wallet').modal('show');
        });

        $("#claim_tags").select2({
            tags: true,
            tokenSeparators: [','],
            selectOnClose: true,
            closeOnSelect: false
        });

        $(document).on("click", '#go_to_admin', function(event) {
            event.preventDefault();
            window.location = '<?php echo $__page->admin_page; ?>';
        });

        $(document).on("click", '#view_transaction', function(event) {
            event.preventDefault();
            <?php if($__page->blockchain == GNOSIS_CHAIN || $__page->blockchain == OPTIMISM ){ ?>
                window.open('<?php echo $__page->view_transaction_link; ?>'+$(this).data('tr_id'), '_blank');
            <?php }else{ ?>
                window.open('<?php echo $__page->view_transaction_link; ?>'+$(this).data('tr_id')+'?cluster=devnet', '_blank');
            <?php } ?>
        });

        $(document).on("click", '#onboard_skip', function(event) {

            $.ajax({
                url: 'skip-onboard',
                dataType: 'json',
                success: function(data) {
                    $("#body_section").html('');
                    Calendly.initPopupWidget({url: 'https://calendly.com/lighthouse_dao/onboarding'});
                }
            });
        });

        $('#nttsForm').validate({
            rules: {
                ntts:{
                    required: true
                },
                wallet_address:{
                    required: true
                }
            },
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    beforeSend: function() {
                        $('#NttsGetting').modal('show');
                    },
                    success: function(data){
                        $('#NttsGetting').modal('hide');
                        if(data.success == true){
                            $('#view_transaction').data('tr_id',data.txHash);
                            $('#NttsSccess').modal('show');
                            //Calendly.initPopupWidget({url: 'https://calendly.com/lighthouse_dao/onboarding'});
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
