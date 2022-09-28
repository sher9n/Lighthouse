<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid">
            <?php
            if($__page->user->ntt_consent_bar != 1){ ?>
            <div id="consent_div" class="col">
                <div class="card shadow mb-12">
                    <div class="card-body px-xl-20">
                        <div class="d-flex align-items-center">
                            <div class="fs-4 fw-medium">I consent to receiving non-transferrable reputation tokens ($rep<?php echo $__page->ticker; ?>).</div>
                            <div class="ms-auto">
                                <button type="button" data-consent="0" id="i_do_not_consent" class="btn btn-white me-2 btn_consent">I do not consent</button>
                                <button type="button" data-consent="1" id="i_consent" class="btn btn-blue-stone btn_consent">I consent</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col">
                <div class="card shadow" style="min-height: calc(100vh - 60px);">                    
                    <div class="card-body p-xl-20">
                        <div class="display-5 fw-medium">Contribute to <?php echo $__page->community_name; ?><img src="<?php echo app_cdn_path; ?>img/fire.png"></div>
                        <div class="text-muted mt-1">Request $rep<?php echo $__page->community->ticker; ?> for your contributions.</div>
                        <div class="row mt-12">
                            <?php foreach ($__page->forms as $form){ ?>
                                <div class="col-12">
                                    <div class="card border rounded-3 mb-12">
                                        <div class="card-body p-10">
                                            <div class="d-flex align-items-center">
                                                <div class="me-auto">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fs-4 fw-semibold"><?php echo $form->form_title; ?></div>
                                                        <?php if($__page->is_admin != false){ ?>
                                                        <a class="fw-medium text-decoration-none text-primary ms-3" href="integrations-form?form_id=<?php echo $form->id; ?>">Edit > </a>
                                                        <?php } ?>
                                                    </div>
                                                    <?php if($form->scoring ==1){ ?>
                                                        <div class="fw-medium">Max <?php echo number_format($form->max_point); ?> $rep<?php echo $__page->community->ticker; ?></div>
                                                    <?php }else{ ?>
                                                        <div class="fw-medium">No score</div>
                                                    <?php } ?>
                                                </div>
                                                <a href="contribution?form=<?php echo $form->id; ?>" class="btn btn-primary">Submit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($__page->is_admin != false){ ?>
                            <div class="col-12">
                                <a class="card border-dashed rounded-3 text-decoration-none justify-content-center" role="button" href="integrations-form">
                                    <div class="d-flex align-items-center flex-column p-9">
                                        <img src="cdn/img/icon-add.png" width="60" height="60">
                                    </div>                               
                                </a>
                            </div>
                            <?php } ?>
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
<!-- Welcome Modal -->
<div class="modal show" id="WelcomeModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-02">
      <div class="modal-content">
        <div class="modal-body px-25 py-16 text-center">
          <img src="<?php echo app_cdn_path; ?>img/icon-logo.png"  width="80" height="80" class="">
          <div class="fs-2 fw-semibold mb-22 mt-3 text-center mt-12">Welcome to Lighthouse!</div>
          <div class="fs-4 fw-medium text-center"><?php echo $__page->community_name; ?> uses Lighthouse to capture contributions like governance, bounties, work and participation across your community. </div>
          <button data-bs-dismiss="modal" type="button" class="btn btn-primary mt-12">Let’s go!</button>
        </div>
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
    <?php if($__page->new_user != 0){ ?>
        $("#WelcomeModal").modal('show');
    <?php } ?>

    <?php if(strlen($__page->wallet_adr) > 0){ ?>
            sessionStorage.setItem("lh_sel_wallet_add", '<?php echo $__page->wallet_adr; ?>');
            sessionStorage.setItem("lh_wallet_adds", JSON.stringify(['<?php echo $__page->wallet_adr; ?>']));
            <?php if(strlen($__page->view_contract) > 0) { ?>
                showMessage('success',10000,'Success! Your community has been created. '+'<a class="text-white ms-1" target="_blank" href="<?php echo $__page->view_contract; ?>"> VIEW CONTRACT</a>');
            <?php } ?>
        <?php } ?>

        selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
        if (selectedAccount) {
            $("#wallet_address").val(selectedAccount);
        }
    });
</script>