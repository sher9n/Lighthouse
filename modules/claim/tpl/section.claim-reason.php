<style>
    .bg-claim-image {
        background-image: url(<?php echo app_cdn_path. $__page->img_url; ?>);
    }
</style>
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
                                <input type="text" class="form-control form-control-lg" name="claim_tags" id="claim_tags"placeholder="Marketing, Development, Strategy">
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
<?php include_once app_root . '/templates/foot.php'; ?>
<script type="text/javascript">

    $(document).ready(function() {

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