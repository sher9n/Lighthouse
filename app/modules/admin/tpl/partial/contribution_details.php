<?php
    use Core\Utils;
    use lighthouse\Form;
?>
<div class="card shadow">
    <form id="" method="post" action="" autocomplete="off" class="d-flex flex-column h-100">
        <div class="card-body p-xxl-20">
            <div class="display-5 fw-medium mb-25">Review this contribution</div>
            <?php
            if(count($user_arrovals) > 0 ){
                if($contribution->approval_type == 2){
                    $ratings = $contribution->rating_categories;
                    $ratings = json_decode($ratings);
                    ?>
                    <div class="row">
                        <div class="col-8 offset-md-4">
                            <div class="text-muted fs-sm d-flex justify-content-between mb-3">
                                <div>Least</div>
                                <div>Most</div>
                            </div>
                        </div>
                    </div>
                    <?php
                    foreach ($ratings as $rating){
                    $category = strtolower(preg_replace("/\s+/", "-", $rating));
                    ?>
                    <div class="row">
                        <div class="col-4 align-self-center">
                            <div class="fw-medium fs-lg"><?php echo ucfirst(strtolower($rating));?></div>
                        </div>
                        <div class="col-8">
                            <div class="list-rating-scale">
                                <input type="radio" class="btn-check" name="<?php echo $category; ?>" data-name="<?php echo $category; ?>" data-val="1" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> <?php echo (isset($user_arrovals[$category]) && $user_arrovals[$category]==1)?'checked':'';?> id="<?php echo $category; ?>1" autocomplete="off">
                                <label class="btn btn-light ms-0" for="<?php echo $category; ?>1">1</label>

                                <input type="radio" class="btn-check" name="<?php echo $category; ?>" data-name="<?php echo $category; ?>" data-val="2" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> <?php echo (isset($user_arrovals[$category]) && $user_arrovals[$category]==2)?'checked':'';?> id="<?php echo $category; ?>2" autocomplete="off">
                                <label class="btn btn-light" for="<?php echo $category; ?>2">2</label>

                                <input type="radio" class="btn-check" name="<?php echo $category; ?>" data-name="<?php echo $category; ?>" data-val="3" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> <?php echo (isset($user_arrovals[$category]) && $user_arrovals[$category]==3)?'checked':'';?> id="<?php echo $category; ?>3" autocomplete="off">
                                <label class="btn btn-light" for="<?php echo $category; ?>3">3</label>

                                <input type="radio" class="btn-check" name="<?php echo $category; ?>" data-name="<?php echo $category; ?>" data-val="4" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> <?php echo (isset($user_arrovals[$category]) && $user_arrovals[$category]==4)?'checked':'';?> id="<?php echo $category; ?>4" autocomplete="off">
                                <label class="btn btn-light" for="<?php echo $category; ?>4">4</label>

                                <input type="radio" class="btn-check" name="<?php echo $category; ?>" data-name="<?php echo $category; ?>" data-val="5" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> <?php echo (isset($user_arrovals[$category]) && $user_arrovals[$category]==5)?'checked':'';?> id="<?php echo $category; ?>5" autocomplete="off">
                                <label class="btn btn-light me-0" for="<?php echo $category; ?>5">5</label>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                }
            }
            else{
                if($contribution->approval_type == 2){
                    ?>
                    <div class="row">
                        <div class="col-8 offset-md-4">
                            <div class="text-muted fs-sm d-flex justify-content-between mb-3">
                                <div>Least</div>
                                <div>Most</div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $ratings = $contribution->rating_categories;
                    $ratings = json_decode($ratings);
                    foreach ($ratings as $rating){
                        $category = strtolower(preg_replace("/\s+/", "-", $rating));
                        ?>
                        <div class="row">
                            <div class="col-4 align-self-center">
                                <div class="fw-medium fs-lg"><?php echo ucfirst(strtolower($rating));?></div>
                            </div>
                            <div class="col-8">
                                <div class="list-rating-scale">
                                    <input type="radio" class="btn-check" name="<?php echo $category; ?>" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> data-name="<?php echo $category; ?>" data-val="1" id="<?php echo $category; ?>1" autocomplete="off">
                                    <label class="btn btn-light ms-0" for="<?php echo $category; ?>1">1</label>

                                    <input type="radio" class="btn-check" name="<?php echo $category; ?>" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> data-name="<?php echo $category; ?>" data-val="2" id="<?php echo $category; ?>2" autocomplete="off">
                                    <label class="btn btn-light" for="<?php echo $category; ?>2">2</label>

                                    <input type="radio" class="btn-check" name="<?php echo $category; ?>" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> data-name="<?php echo $category; ?>" data-val="3" id="<?php echo $category; ?>3" autocomplete="off">
                                    <label class="btn btn-light" for="<?php echo $category; ?>3">3</label>

                                    <input type="radio" class="btn-check" name="<?php echo $category; ?>" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> data-name="<?php echo $category; ?>" data-val="4" id="<?php echo $category; ?>4" autocomplete="off">
                                    <label class="btn btn-light" for="<?php echo $category; ?>4">4</label>

                                    <input type="radio" class="btn-check" name="<?php echo $category; ?>" <?php echo ($contribution->status == 1 || $contribution->status == 2 )?'disabled':''; ?> data-name="<?php echo $category; ?>" data-val="5" id="<?php echo $category; ?>5" autocomplete="off">
                                    <label class="btn btn-light me-0" for="<?php echo $category; ?>5">5</label>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            } ?>
            <div class="row mt-10">
                <div id="btn_row" class="col-8 offset-md-4 text-end">
                    <?php if($contribution->status == 1 ) { ?>
                        <a target="_blank" href="<?php echo $view_transaction_link ; ?>" type="button" class="btn btn-secondary">View Transaction</a>
                    <?php }else{
                        if($contribution->status != 2 ){ ?>
                            <button id="btn_deny" type="button" class="btn btn-secondary">Deny</button>
                            <button id="btn_approve" type="button" class="btn btn-primary">Attest</button>
                            <?php
                        }
                    }?>
                </div>
            </div>
        </div>
        <div class="card-body p-xxl-20 border-top">
            <ul class="nav nav-pills" id="claim-tab" role="tablist">
                <li class="nav-item ps-0 pt-0" role="presentation">
                    <button class="tab_link nav-link active" id="claim-details-tab" data-bs-toggle="tab" data-bs-target="#claim-details" type="button" role="tab" aria-controls="claim-details" aria-selected="true">Details</button>
                </li>
                <li class="nav-item pt-0" role="presentation">
                    <button class="tab_link nav-link" id="claim-history-tab" data-bs-toggle="tab" data-bs-target="#claim-history" type="button" role="tab" aria-controls="claim-history" aria-selected="false">History</button>
                </li>
                <li class="nav-item pt-0" role="presentation">
                    <button class="tab_link nav-link" id="claim-approvals-tab" data-bs-toggle="tab" data-bs-target="#claim-approvals" type="button" role="tab" aria-controls="claim-approvals" aria-selected="false">Attestors (<?php echo count($approvals); ?>/<?php echo $contribution->approval_count; ?>)</button>
                </li>
                <li class="nav-item pt-0" role="presentation">
                    <button class="tab_link nav-link" id="claim-similar-tab" data-bs-toggle="tab" data-bs-target="#claim-similar" type="button" role="tab" aria-controls="claim-similar" aria-selected="false">Similar Claims</button>
                </li>
            </ul>
            <div class="tab-content mt-6" id="claim-tabContent">
                <div class="tab-pane fade show active" id="claim-details" role="tabpanel" aria-labelledby="claim-details-tab" tabindex="0">
                    <div class="fw-semibold">Wallet or SNS</div>
                    <div class="fw-medium fs-4 mt-1"><?php echo $contribution->wallet_to; ?></div>
                    <div class="fw-semibold mt-12">Reason</div>
                    <div class="fw-medium fs-4 mt-1"><?php echo $contribution->contribution_reason; ?></div>
                    <?php
                    $data = (array)json_decode($contribution->form_data);
                    foreach ($elements as $index => $element){
                        if($index != 0){
                            //$ele_name =  trim($element['e_name'], "[]");
                            $ele_name = strtolower(preg_replace("/\s+/", "_", $element['e_name']));
                            if($element['e_type'] == Form::QT_SHORT_ANSWER || $element['e_type'] == Form::QT_PARAGRAPH || $element['e_type'] == Form::QT_DROPDOWN || $element['e_type'] == Form::QT_CHECKBOXES || $element['e_type'] == Form::QT_MULTIPLE_CHOICE) {
                                ?>
                                <div class="fw-semibold mt-12"><?php echo $element['e_label']; ?></div>
                                <?php if(isset($data[$ele_name])){ ?>
                                    <div class="fw-medium fs-4 mt-1"><?php echo $data[$ele_name]; ?></div>
                                <?php
                                }
                            }
                            elseif ($element['e_type'] == Form::QT_TAGS) {

                                ?>
                                <div class="fw-semibold mt-12"><?php echo $element['e_label']; ?></div>
                                <?php if(isset($data[$ele_name])){ ?>
                                    <ul class="select2-selection__rendered d-flex gap-3 mt-1">
                                        <?php
                                        if(count($data[$ele_name]) > 0){
                                            $tags_arry = $data[$ele_name];
                                            foreach ($tags_arry as $tag){ ?>
                                                <li class="select2-selection__choice" title="<?php echo $tag; ?>" data-select2-id="141"><?php echo $tag; ?></li>
                                                <?php
                                            }
                                        } ?>
                                    </ul>
                                <?php
                                }
                            }
                        }
                    } ?>
                    <div class="fw-semibold mt-12">Tags</div>
                    <ul class="select2-selection__rendered d-flex gap-3 mt-1">
                        <?php
                        if(strlen($form->tags) > 0){
                            $tags_arry = explode(",",$form->tags);
                            foreach ($tags_arry as $tag){ ?>
                                <li class="select2-selection__choice" title="<?php echo $tag; ?>" data-select2-id="141"><?php echo $tag; ?></li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="claim-history" role="tabpanel" aria-labelledby="claim-history-tab" tabindex="0">
                    <?php
                    if($contributions->num_rows > 0){
                        foreach ($contributions as $con){ ?>
                        <div class="p-8 bg-lighter rounded-1 mb-6">
                            <div class="text-muted fs-sm"><?php echo Utils::time_elapsed_string($con['c_at'],false,true); ?></div>
                            <div class="fw-medium mt-1"><?php echo $con['contribution_reason']; ?></div>
                        </div>
                        <?php }
                    }else{ ?>
                        <div class="d-flex flex-column align-items-center justify-content-center py-25">
                            <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                            <div class="fw-medium mt-4">No data found.</div>
                        </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade" id="claim-approvals" role="tabpanel" aria-labelledby="claim-approvals-tab" tabindex="0">
                    <?php
                    if(count($approvals) > 0){
                        foreach ($approvals as $stewd_adr) {
                            $stewd_adr = strtolower($stewd_adr);
                            if(isset($stewards[$stewd_adr])) {
                                $steward = $stewards[$stewd_adr]; ?>

                                    <div class="fw-semibold mt-12"><?php echo $steward['name']; ?></div>
                                    <div class="fw-medium fs-4 mt-1"><?php echo $steward['wallet_adr']; ?></div>

                                <?php
                            }
                        }
                    }
                    else {
                        ?>
                        <div class="d-flex flex-column align-items-center justify-content-center py-25">
                            <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                            <div class="fw-medium mt-4">No data found.</div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="tab-pane fade" id="claim-similar" role="tabpanel" aria-labelledby="claim-similar-tab" tabindex="0">
                    <div class="d-flex flex-column align-items-center justify-content-center py-25">
                        <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                        <div class="fw-medium mt-4">No data found.</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var review_data = {};

    $(document).ready(function(){

        $('#btn_approve').click(function (e){
            var c_id = '<?php echo $contribution->id; ?>';
            review_data['con_id'] = c_id;
            review_data['status'] = 1;
            <?php if(count($user_appproval_ids) > 0){ ?>
                review_data['approval_id'] = '<?php echo array_pop($user_appproval_ids); ?>';
            <?php } ?>

            $.ajax({
                url: 'contribution-status',
                dataType: 'json',
                data: review_data,
                type: 'POST',
                beforeSend: function () {
                    $('#btn_deny').prop('disabled', true);
                    $('#btn_approve').prop('disabled', true);
                },
                success: function (response) {
                    if (response.success == true) {
                        if(response.update == false) {
                            if ($('#cq_item_' + c_id).parent().parent().find("li").length == 2) {
                                $('#cq_item_' + c_id).parent().parent().html('<div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
                                    '   <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">\n' +
                                    '   <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a contribution,<br>it will show up here</div>' +
                                    '</div>');

                            }
                            $('#cq_item_' + c_id).remove();
                            $('#claim-approvals').html(response.steward_html);
                            $('#claim_details').html('');
                        }
                        $('#btn_deny').prop('disabled', false);
                        $('#btn_approve').prop('disabled', false);
                        showMessage('success',10000,response.message);
                    }
                }
            });
        });

        $('#btn_deny').click(function (e){
            var c_id = '<?php echo $contribution->id; ?>';
            var data = {'con_id': c_id,'status':2};
            $.ajax({
                url: 'contribution-status',
                dataType: 'json',
                data: data,
                type: 'POST',
                beforeSend: function() {
                    //showMessage('success',10000,'Submitting your claim...');
                    $('#btn_deny').prop('disabled', true);
                    $('#btn_approve').prop('disabled', true);
                },
                success: function (response) {
                    if (response.success == true) {

                        showMessage('success',10000,'Success! Your attestation has been recorded');

                        if($('#cq_item_'+c_id).parent().parent().find("li").length == 2) {
                            $('#cq_item_'+c_id).parent().parent().html('<div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
                                '   <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">\n' +
                                '   <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a contribution,<br>it will show up here</div>' +
                                '</div>');

                        }
                        $('#claim_details').html('');
                        $('#cq_item_'+c_id).remove();
                    }
                }
            });
        });
    });

    /* $(document).on("click", '.btn_complexity', function(event) {
         c = $(this).data('val');
         $.ajax({
             url: 'similar-contributions?c='+c+'&i='+i+'&q='+q,
             dataType: 'json',
             type: 'GET',
             success: function (response) {
                 $('#claim-similar').html(response.html);
             }
         });
     });*/

</script>