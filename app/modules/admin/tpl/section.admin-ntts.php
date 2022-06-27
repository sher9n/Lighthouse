<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="col h-100">
                <div class="card shadow h-100">                    
                    <div class="card-body p-xl-20">
                        <div class="display-5 fw-medium">Submit a contribution</div>
                        <div class="text-muted mt-1">Request attestations for completed activity</div>
                        <div class="row mt-12">
                            <div class="col-xl-5">
                                <div class="card border rounded-3 mb-12 mb-lg-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-7">
                                        <div class="card-logo me-8">
                                            <img src="<?php echo app_cdn_path; ?>img/company-logo/icon-simple.png">
                                        </div>
                                        <div class="fs-4 fw-semibold">Simple claim form</div>                                        
                                    </div>
                                    <div class="fw-medium lh-lg two-lines-wrap text-gray-700">Use this form to request an attestation for completed activity. </div>
                                    <a href="#" class="btn btn-primary mt-8">View Form</a>
                                </div>                                
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="card border rounded-3 mb-12 mb-lg-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-7">
                                        <div class="card-logo me-8">
                                            <img src="<?php echo app_cdn_path; ?>img/company-logo/icob-grants.png">
                                        </div>
                                        <div class="fs-4 fw-semibold">Grants request form</div>                                        
                                    </div>
                                    <div class="fw-medium lh-lg two-lines-wrap text-gray-700">Use this form to request attestations for  contributions related to grants. </div>
                                    <a href="#" class="btn btn-primary mt-8">View Form</a>
                                </div>                                
                                </div>
                            </div>
                        </div>
                    </div>                    
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
<?php include_once app_root . '/templates/admin-foot.php'; ?>
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
                        $('#btn_submit').prop('disabled', true);
                        showMessage('success',10000,'Your NTTs are being sent.');
                    },
                    success: function(data){
                        $('#btn_submit').prop('disabled', false);
                        if(data.success == true){
                            showMessage('success', 10000, data.message);
                            $('#wallet_address').val('');
                            $('#ntts').val('');
                            $('#claim_reason').val('');
                            $("#claim_tags").val(null).trigger('change');
                        }
                        else{
                            if(data.message) {
                                showMessage('danger', 10000, data.message);
                                $('#wallet_address').val('');
                                $('#ntts').val('');
                                $('#claim_reason').val('');
                                $("#claim_tags").val(null).trigger('change');
                            }
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