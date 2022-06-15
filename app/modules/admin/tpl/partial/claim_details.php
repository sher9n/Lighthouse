<div class="card shadow">
    <form id="nttsForm" method="post" action="claim-status" autocomplete="off" class="d-flex flex-column h-100">
        <div class="card-body p-xl-20 mb-xl-20">
            <div class="display-5 fw-medium">Claim details</div>
            <label for="" class="form-label mt-20">Wallet or SNS</label>
            <div class="fs-3 fw-semibold"><?php echo $claim->wallet_adr; ?></div>
            <label for="" class="form-label mt-18 mb-3">Claim amount </label>
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="claim_id" value="<?php echo $claim->id; ?>">
            <div>
                <div class="row g-6">
                    <div class="col-xl-3">
                        <input type="number" name="ntts" class="form-control rounded-3 py-9 px-7 fs-3 h-100" <?php echo ($claim->status != 0)?'readonly':'' ?> value="<?php echo $claim->ntts; ?>" placeholder="120">
                    </div>
                    <div class="col-xl">
                        <div class="bg-light rounded-3 py-3 px-7">
                            <div class="fs-3">4.5K</div>
                            <div class="d-flex align-items-center">Score Impact: <span class="text-success ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-up.png"></div>
                        </div>
                    </div>
                    <div class="col-xl">
                        <div class="bg-light rounded-3 py-3 px-7">
                            <div class="fs-3">2.32K</div>
                            <div class="d-flex align-items-center">Rank Impact: <span class="text-danger ms-2">N/A</span><img src="<?php echo app_cdn_path; ?>img/arrow-bottom.png"></div>
                        </div>
                    </div>
                </div>
            </div>
            <label for="" class="form-label mt-18 mb-3">Reason</label>
            <textarea name="claim_reason" class="form-control form-control-lg fs-3" <?php echo ($claim->status != 0)?'readonly':'' ?> rows="2" placeholder=""><?php echo $claim->clm_reason; ?></textarea>
            <label for="" class="form-label mt-18 mb-3">Tags</label>
            <!--<textarea class="form-control form-control-lg" id="" rows="2" placeholder=""><?php /*echo $claim->clm_tags; */?></textarea>-->
            <select class="form-control form-control-lg" multiple="multiple" name="claim_tags[]" id="claim_tags" placeholder="Marketing, Development, Strategy">
                <?php
                if(strlen($claim->clm_tags) > 0){
                    $tags_arry = explode(",",$claim->clm_tags);
                    foreach ($tags_arry as $tag){?>
                        <option selected="selected"><?php echo $tag;?></option>
                    <?php }
                } ?>
            </select>
        </div>
        <?php if($claim->status == 0){ ?>
        <div class="action_buttons card-body border-top d-flex justify-content-end gap-3">
            <button type="button" data-claim_id="<?php echo $claim_id; ?>" class="btn btn-white claim_deny">Deny</button>
            <button type="submit" data-claim_id="<?php echo $claim_id; ?>" class="btn btn-primary claim_approve">Approve</button>
        </div>
        <?php } ?>
    </form>
</div>
<script>
    $(document).ready(function() {

        $("#claim_tags").select2({
            <?php if($claim->status != 0){?>
            disabled:'readonly',
            <?php } ?>
            tags: true,
            tokenSeparators: [','],
            selectOnClose: true,
            closeOnSelect: false
        });

        $('#nttsForm').validate({
            rules: {
                ntts:{
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

                            if($('#cq_item_'+data.c_id).parent().parent().find("li").length == 1) {
                                $('#cq_item_'+data.c_id).parent().parent().html('<div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
                                    '   <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">\n' +
                                    '   <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a claim,<br>it will show up here</div>' +
                                    '</div>');
                                $('#claim_details').html('');
                            }
                            else {
                                $('#claim_details').html('<div class="card shadow h-100">\n' +
                                    '                        <div class="card-body">\n' +
                                    '                            <div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
                                    '                                <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">\n' +
                                    '                            </div>\n' +
                                    '                        </div>\n' +
                                    '                    </div>');
                            }
                            $('#cq_item_'+data.c_id).remove();
                        }
                        else{
                            if(data.message) {
                                showMessage('danger', 10000, data.message);
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