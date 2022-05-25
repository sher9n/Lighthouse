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
                    <div class="col-lg-7">
                        <div class="display-5 fw-medium mt-25">Take her for a spin</div>
                        <div class="text-muted mt-1">Send yourself some NTTs to test out Lighthouse</div>
                        <div class="mt-23">
                            <label class="form-label mb-4">Which wallet do you want to distribute NTTs to?</label>
                            <input type="hidden" class="form-control form-control-lg mb-6" name="wallet_address" id="wallet_address">
                            <div id="sel_wallet_address" class="fs-3 fw-semibold mb-3"></div>
                            <a role="button" id="add_wallet" onclick="addWallet()" class="btn btn-light" href="#">Add Wallet</a>
                        </div>
                        <div class="mt-16">
                            <label for="LHT" class="form-label">How many NTTs do you want to distribute?</label>
                            <input type="number" class="form-control form-control-lg mb-6" name="ntts" id="ntts" placeholder="100">
                            <div class="d-flex">
                                <div class="badge bg-white d-flex align-items-center">Score Impact: <span class="text-success ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-up.png" class="ms-1"></div>
                                <div class="badge bg-white d-flex align-items-center ms-3">Rank Impact: <span class="text-danger ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-bottom.png" class="ms-1"></div>
                            </div>
                        </div>
                        <div class="mt-16">
                            <label for="claimReason" class="form-label">What's the reason for this distribution?</label>
                            <textarea class="form-control form-control-lg" name="claim_reason" id="claim_reason" rows="3" placeholder="Helpful discussion on Discourse, URL tweet etc..."></textarea>
                        </div>
                        <div class="mt-16">
                            <label for="claimCategorize" class="form-label">Tag this distribution to query it later.</label>
                            <input type="text" class="form-control form-control-lg" name="claim_tags" id="claim_tags" placeholder="Marketing, Development, Strategy">
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
</main>
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">

    $(document).ready(function(){

        selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
        if(selectedAccount) {
            $("#sel_wallet_address").html(selectedAccount);
            $("#wallet_address").val(selectedAccount);
            $('#add_wallet').html('CHANGE WALLET')
        }

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
                    success: function(data){
                        if(data.success == true){
                            $("#body_section").html('');
                            Calendly.initPopupWidget({url: 'https://calendly.com/lighthouse_dao/onboarding'});
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
