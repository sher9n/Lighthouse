<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid">
            <div class="col">
                <div class="card shadow" style="min-height: calc(100vh - 60px);">                    
                    <div class="card-body p-xl-20">
                        <div class="display-5 fw-medium">Contribute to <?php echo $__page->community_name; ?><img src="<?php echo app_cdn_path; ?>img/fire.png"></div>
                        <div class="text-muted mt-1">Request $rep<?php echo $__page->community->ticker; ?> for your contributions.</div>
                        <div class="row mt-12">
                            <?php if($__page->simple_claim_form==1){ ?>
                            <div class="col-12">
                                <div class="card border rounded-3 mb-12">
                                <div class="card-body p-10">
                                    <div class="d-flex align-items-center">  
                                        <div class="me-auto">                                      
                                            <div class="fs-4 fw-semibold">Simple claim</div>
                                            <!--<a class="fw-medium text-decoration-none text-primary" href="integrations-form?form_id=1">Edit > </a>-->
                                        </div>
                                        <img src="<?php echo app_cdn_path; ?>img/coins.png">
                                        <div class="fs-4 fw-semibold mx-10">100 $rep<?php echo $__page->community->ticker; ?></div>
                                        <a href="contribution?form=1" class="btn btn-primary">Submit</a>
                                    </div>                                    
                                </div>                                
                                </div>
                            </div>
                            <?php } ?>
                            <?php foreach ($__page->forms as $form){ ?>
                                <div class="col-12">
                                    <div class="card border rounded-3 mb-12">
                                        <div class="card-body p-10">
                                            <div class="d-flex align-items-center">
                                                <div class="me-auto">                                      
                                                    <div class="fs-4 fw-semibold"><?php echo $form->form_title; ?></div>
                                                    <a class="fw-medium text-decoration-none text-primary" href="integrations-form?form_id=<?php echo $form->id; ?>">Edit > </a>
                                                </div>
                                                <img src="<?php echo app_cdn_path; ?>img/coins.png">
                                                <?php if($form->scoring ==1){ ?>
                                                    <div class="fs-4 fw-semibold mx-10">Fixed score, upto <?php echo number_format($form->max_point); ?> $rep<?php echo $__page->community->ticker; ?></div>
                                                <?php }else{ ?>
                                                    <div class="fs-4 fw-semibold mx-10">No score</div>
                                                <?php } ?>
                                                <a href="contribution?form=<?php echo $form->id; ?>" class="btn btn-primary">Submit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-12">
                                <a class="card border-dashed rounded-3 text-decoration-none justify-content-center" role="button" href="integrations-form">
                                    <div class="d-flex align-items-center flex-column p-9">
                                        <img src="cdn/img/icon-add.png" width="60" height="60">
                                    </div>                               
                                </a>
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

    $(document).on("click", '.add_wallet', function(event) {
        $("#sendNewNttPop").modal('hide');
        $('#admin_wallet').modal('show');
    });

    $(document).ready(function() {

        <?php if(strlen($__page->wallet_adr) > 0){ ?>
            sessionStorage.setItem("lh_sel_wallet_add", '<?php echo $__page->wallet_adr; ?>');
            sessionStorage.setItem("lh_wallet_adds", JSON.stringify(['<?php echo $__page->wallet_adr; ?>']));
            <?php if(strlen($__page->view_contract) > 0) { ?>
                showMessage('success',10000,'Success! Your community has been created. '+'<a class="text-white ms-1" target="_blank" href="<?php echo $__page->view_contract; ?>"> VIEW TRANSACTION</a>');
            <?php } ?>
        <?php } ?>

        selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
        if (selectedAccount) {
            $("#wallet_address").val(selectedAccount);
        }
    });
</script>