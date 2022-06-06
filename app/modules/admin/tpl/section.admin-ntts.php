<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="col">
                <div class="card shadow">
                    <form id="nttsForm" method="post" action="send-ntts" autocomplete="off" class="d-flex flex-column h-100">
                        <div class="card-body p-xl-20">
                            <div class="display-5 fw-medium">Recognize community participation</div>
                            <div class="text-muted mt-1">Send NTTs to anyone in your community</div>
                            <div class="col-xl-7">
                            <label class="form-label mt-20">Which wallet do you want to distribute NTTs to?</label>
                            <input type="text" name="wallet_address" id="wallet_address" class="form-control form-control-lg">
                            <div class="fs-3 fw-semibold mb-3 text-break"></div>
                            <?php if($__page->solana == true){ ?>
                                <a role="button" id="add_wallet" onclick="changeSolanaAccount()" class="btn btn-light" href="#">Add Wallet</a>
                            <?php }else{ ?>
                                <a role="button" id="add_wallet" class="add_wallet btn btn-light" href="#">Change Wallet</a>
                            <?php } ?>                            
                                <div class="mt-16">
                                    <label for="LHT" class="form-label">How many NTTs do you want to distribute?</label>
                                    <input type="text" class="form-control form-control-lg mb-6 fs-3" name="ntts" id="ntts"  placeholder="100">
                                    <div class="d-flex">
                                        <div class="badge bg-light d-flex align-items-center">Score Impact: <span class="text-success ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-up.png"></div>
                                        <div class="badge bg-light d-flex align-items-center ms-3">Rank Impact: <span class="text-danger ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-bottom.png"></div>
                                    </div>
                                </div>
                                <label class="form-label fw-medium mt-18 mb-3">What's the reason for this distribution?</label>
                                <textarea class="form-control form-control-lg fs-3" name="claim_reason" id="claim_reason" rows="2" placeholder="Helpful discussion on Discourse, URL tweet etc..."></textarea>
                                <label class="fw-medium mt-18 mb-3">Tag this distribution to query it later.</label>
                                <select style="width: width: 100px !important;" class="form-control form-control-lg" multiple="multiple" name="claim_tags[]" id="claim_tags" placeholder="Marketing, Development, Strategy"></select>
                            </div>
                        </div>
                        <div class="card-body border-top d-flex justify-content-end gap-3">
                            <button type="submit" class="btn btn-primary">send reward </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<div class="modal fade" id="NttsGetting" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pb-16 text-center">
            <img src="<?php echo app_cdn_path; ?>img/anim-delivery.gif"  width="180" height="180" class="align-self-center">
            <div class="fs-2 fw-semibold text-center">Sending your NTTs...</div>
        </div>
    </div>
</div>
<?php include_once app_root . '/templates/foot.php'; ?>
<script>
    feather.replace();

    $(document).on("click", '.add_wallet', function(event) {
        $("#sendNewNttPop").modal('hide');
        $('#admin_wallet').modal('show');
    });

    $(document).ready(function() {
        selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
        if (selectedAccount) {
            $("#wallet_address").val(selectedAccount);
        }

        $("#claim_tags").select2({
            tags: true,
            tokenSeparators: [','],
            selectOnClose: true,
            closeOnSelect: false
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
                        showMessage('success',10000,'Your NTTs are being sent.');
                    },
                    success: function(data){
                        if(data.success == true){
                            showMessage('success', 10000, data.message);
                        }
                        else{
                            if(data.message)
                                showMessage('danger',10000,data.message);
                            else {
                                $('#' + data.element).addClass('form-control-lg error');
                                $('<label class="error">' + data.msg + '</label>').insertAfter('#' + data.element);
                            }
                        }
                    }
                });
            }
        });
    });
</script>