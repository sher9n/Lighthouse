<style>
    .bg-claim-image {
        background-image: url(<?php echo app_cdn_path. $__page->img_url; ?>);
    }
</style>
<link rel="stylesheet" href="<?php echo app_cdn_path; ?>css/js-snackbar.css" />
<div class="container-fluid g-0 h-100">
    <div class="row g-0 h-100">
        <div class="col-lg-6 bg-white">

                <form id="claimForm" method="post" action="claim-reason" autocomplete="off" class="d-flex flex-column h-100">
                    <div class="px-26">
                        <div class="display-5 fw-medium mt-25">Submit a claim for <?php echo $__page->site['site_name']; ?></div>
                        <div class="text-muted mt-1">Fill out the details of your contribution</div>
                            <div class="mt-23">
                                <label for="claimReason" class="form-label">Give a reason for this claim</label>
                                <textarea class="form-control form-control-lg" name="claim_reason" id="claim_reason" rows="2" placeholder="Helpful discussion on Discourse, URL tweet etc..."></textarea>
                            </div>
                            <div class="mt-16">
                                <label for="claimCategorize" class="form-label">Add tags to categorize this claim</label>
                                <select class="form-control form-control-lg" multiple="multiple" name="claim_tags[]" id="claim_tags" placeholder="Marketing, Development, Strategy"></select>
                            </div>                            
                    </div>                   

                    <div class="mt-auto border-top py-5 px-26">
                        <div class="d-flex justify-content-between">
                            <a role="button" class="btn btn-white" href="claim">Back</a>
                            <button type="submit" class="btn btn-primary">Submit Claim</button>
                        </div>
                    </div>
                </form>
                

        </div>
        <div class="col-lg-6 h-100 d-flex justify-content-center">
            <div class="bg-claim-image"></div> <!-- Full width image -->
            <div class="site-badge d-flex align-items-center">
                <div class="opacity-75 text-white fw-medium">Powered by</div> <img src="<?php echo app_cdn_path; ?>img/logo-text.png" class="ms-2">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="NttsGetting" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pb-16 text-center">
            <img src="<?php echo app_cdn_path; ?>img/anim-ntts-create.gif"  width="180" height="180" class="align-self-center">
            <div class="fs-2 fw-semibold text-center">Creating your NTT contracts...</div>
        </div>
    </div>
</div>
<!-- Creating your NTT contracts... Modal -->
<!--<div class="modal fade" id="creatingNTT" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content pb-16 text-center">
            <img src="<?php /*echo app_cdn_path; */?>img/anim-ntts-create.gif" width="180" height="180" class="align-self-center">
            <div class="fs-2 fw-semibold text-center">Creating your NTT contracts...</div>            
        </div>
    </div>
</div>-->

<!-- Contracts created Modal -->
<!--<div class="modal fade" id="contractsCreated" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content pb-16 text-center">
            <img src="<?php /*echo app_cdn_path; */?>img/anim-please-wait.gif" width="180" height="180" class="align-self-center">
            <div class="fs-2 fw-semibold text-center">Contracts created</div>
            <div class="d-flex align-items-center justify-content-center mt-3">
                <div class="">0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507</div>
                <i data-feather="copy" class="ms-3 text-primary"></i>
            </div>
            <div class="mt-16 d-flex justify-content-center gap-3">
                <button type="button" id="btn_next" class="btn btn-dark px-10">NEXT</button>
                <button type="submit" class="btn btn-primary d-flex align-items-center"><img src="<?php /*echo app_cdn_path; */?>img/logo-fox.png" class="me-2">Add to Metamask</button>
            </div>
        </div>
    </div>
</div>-->
<!-- Sheran or Patrick will help Modal 
<div class="modal fade" id="helpCall" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-16 text-center">
            <img src="<?php echo app_cdn_path; ?>img/anim-lighthouse-circle.gif"  width="100" height="100" class="align-self-center">
            <div class="fs-2 fw-semibold text-center mt-6">Sheran or Patrick will help<br>
you get setup!</div>
            <div class="mt-16 d-flex justify-content-center gap-3">
                <button type="button" id="" class="btn btn-dark px-10">Schedule a call</button>
                <button type="button" id="" class="btn btn-primary px-10">Chat on Telegram</button>
            </div>            
        </div>
    </div>
</div>-->

<!-- Let's schedule a call Modal 
<div class="modal fade" id="scheduleCall" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-16 text-center">
            <img src="<?php echo app_cdn_path; ?>img/anim-lighthouse-circle.gif"  width="100" height="100" class="align-self-center">
            <div class="fs-2 fw-semibold text-center mt-6">Let's schedule a call to<br>
get you set up!</div>
            <div class="mt-16 "><button type="button" id="" class="btn btn-primary px-10">Schedule</button></div>            
        </div>
    </div>
</div>-->

<!-- Congratulations! Modal 
<div class="modal fade" id="Congratulations" data-bs-backdrop="static" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pb-16 text-center">
            <img src="<?php echo app_cdn_path; ?>img/anim-delivery.gif"  width="180" height="180" class="align-self-center">
            <div class="fs-2 fw-semibold text-center">Congratulations!</div>
            <div class="fw-medium mt-3 text-center">Your claim has been successfully submitted.</div>
            <div><button type="button" id="" class="btn btn-primary mt-16 px-10">Okay</button></div>
        </div>
    </div>
</div>-->
<?php include_once app_root . '/templates/claim-foot.php'; ?>
<script type="text/javascript">

    $(document).ready(function() {

        $("#claim_tags").select2({
            tags: true,
            tokenSeparators: [','],
            selectOnClose: true,
            closeOnSelect: false
        });

        $('#claimForm').validate({
            rules: {
                claim_reason:{
                    required: true
                },
                claim_tags:{
                    required: true
                }
            },
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    dataType:'json',
                    success: function(data){
                        if(data.success == true){
                            var claim_id = data.claim_id;
                            sessionStorage.setItem("lh_claim_send", '1');
                            window.location = 'claim-success?id='+claim_id;
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