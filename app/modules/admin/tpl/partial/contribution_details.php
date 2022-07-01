<?php use Core\Utils; ?>
<div class="card shadow">
    <form id="" method="post" action="" autocomplete="off" class="d-flex flex-column h-100">
        <div class="card-body p-xl-20">
            <div class="display-5 fw-medium mb-25">Review this contribution</div>
            <div class="row">
                <div class="col-8 offset-md-4">
                    <div class="text-muted fs-sm d-flex justify-content-between mb-3">
                        <div>Least</div>
                        <div>Most</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 align-self-center">
                    <div class="fw-medium fs-lg">Complexity</div>
                </div>
                <div class="col-8">
                    <div class="list-rating-scale">
                        <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="1" id="Complexityoption1" autocomplete="off">
                        <label class="btn btn-light ms-0" for="Complexityoption1">1</label>

                        <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="2" id="Complexityoption2" autocomplete="off">
                        <label class="btn btn-light" for="Complexityoption2">2</label>

                        <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="3" id="Complexityoption3" autocomplete="off">
                        <label class="btn btn-light" for="Complexityoption3">3</label>

                        <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="4" id="Complexityoption4" autocomplete="off">
                        <label class="btn btn-light" for="Complexityoption4">4</label>

                        <input type="radio" class="btn-check btn_complexity" name="ComplexityOptions" data-val="5" id="Complexityoption5" autocomplete="off">
                        <label class="btn btn-light me-0" for="Complexityoption5">5</label>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-4 align-self-center">
                    <div class="fw-medium fs-lg">Importance</div>
                </div>
                <div class="col-8">
                    <div class="list-rating-scale">
                        <input type="radio" class="btn-check btn_importance" name="ImportanceOptions" id="Importanceoption1" data-val="1"  autocomplete="off">
                        <label class="btn btn-light ms-0" for="Importanceoption1">1</label>

                        <input type="radio" class="btn-check btn_importance" name="ImportanceOptions" id="Importanceoption2" data-val="2"  autocomplete="off">
                        <label class="btn btn-light" for="Importanceoption2">2</label>

                        <input type="radio" class="btn-check btn_importance" name="ImportanceOptions" id="Importanceoption3" data-val="3"  autocomplete="off">
                        <label class="btn btn-light" for="Importanceoption3">3</label>

                        <input type="radio" class="btn-check btn_importance" name="ImportanceOptions" id="Importanceoption4" data-val="4"  autocomplete="off">
                        <label class="btn btn-light" for="Importanceoption4">4</label>

                        <input type="radio" class="btn-check btn_importance" name="ImportanceOptions" id="Importanceoption5" data-val="5"  autocomplete="off">
                        <label class="btn btn-light me-0" for="Importanceoption5">5</label>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-4 align-self-center">
                    <div class="fw-medium fs-lg">Quality</div>
                </div>
                <div class="col-8">
                    <div class="list-rating-scale">
                        <input type="radio" class="btn-check btn_quality" name="QualityOptions" id="Qualityoption1" data-val="1" autocomplete="off">
                        <label class="btn btn-light ms-0" for="Qualityoption1">1</label>

                        <input type="radio" class="btn-check btn_quality" name="QualityOptions" id="Qualityoption2" data-val="2"  autocomplete="off">
                        <label class="btn btn-light" for="Qualityoption2">2</label>

                        <input type="radio" class="btn-check btn_quality" name="QualityOptions" id="Qualityoption3" data-val="3"  autocomplete="off">
                        <label class="btn btn-light" for="Qualityoption3">3</label>

                        <input type="radio" class="btn-check btn_quality" name="QualityOptions" id="Qualityoption4" data-val="4" autocomplete="off">
                        <label class="btn btn-light" for="Qualityoption4">4</label>

                        <input type="radio" class="btn-check btn_quality" name="QualityOptions" id="Qualityoption5" data-val="5"  autocomplete="off">
                        <label class="btn btn-light me-0" for="Qualityoption5">5</label>
                    </div>
                </div>
            </div>
            <div class="row mt-10">
                <div class="col-8 offset-md-4 text-end">
                    <?php if($contribution->status == 1 || in_array($sel_wallet_adr, $approvals)) { ?>
                        <button id="btn_deny" disabled type="button" class="btn btn-white">Deny</button>
                        <button id="btn_approve" disabled type="button" class="btn btn-primary">Approve</button>
                    <?php }else{ ?>
                        <button id="btn_deny" type="button" class="btn btn-white">Deny</button>
                        <button id="btn_approve" type="button" class="btn btn-primary">Approve</button>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="card-body p-xl-20 border-top">
            <ul class="nav nav-pills" id="claim-tab" role="tablist">
                <li class="nav-item ps-0 pt-0" role="presentation">
                    <button class="tab_link nav-link active" id="claim-details-tab" data-bs-toggle="tab" data-bs-target="#claim-details" type="button" role="tab" aria-controls="claim-details" aria-selected="true">Details</button>
                </li>
                <li class="nav-item pt-0" role="presentation">
                    <button class="tab_link nav-link" id="claim-history-tab" data-bs-toggle="tab" data-bs-target="#claim-history" type="button" role="tab" aria-controls="claim-history" aria-selected="false">History</button>
                </li>
                <li class="nav-item pt-0" role="presentation">
                    <button class="tab_link nav-link" id="claim-approvals-tab" data-bs-toggle="tab" data-bs-target="#claim-approvals" type="button" role="tab" aria-controls="claim-approvals" aria-selected="false">Approvals (<?php echo count($approvals); ?>/<?php echo $com->approval_count; ?>)</button>
                </li>
                <li class="nav-item pt-0" role="presentation">
                    <button class="tab_link nav-link" id="claim-similar-tab" data-bs-toggle="tab" data-bs-target="#claim-similar" type="button" role="tab" aria-controls="claim-similar" aria-selected="false">Similar Contributions</button>
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
                    foreach ($elements as $element){
                        $ele_name =  trim($element['e_name'], "[]");
                        if($element['e_type'] == 'text' || $element['e_type'] == 'textarea') {
                            ?>
                            <div class="fw-semibold mt-12"><?php echo $element['e_label']; ?></div>
                            <?php if(isset($data[$ele_name])){ ?>
                                <div class="fw-medium fs-4 mt-1"><?php echo $data[$ele_name]; ?></div>
                            <?php
                            }
                        }
                        elseif ($element['e_type'] == 'tag_select') {

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
                    } ?>
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
                            $steward = $stewards[$stewd_adr]; ?>
                            <div class="fw-semibold"><?php echo $steward['name']; ?></div>
                            <div class="fw-medium fs-4 mt-1"><?php echo $steward['wallet_adr']; ?></div>
                            <a class="fw-medium mt-2 text-primary text-decoration-none" href="#">View Transaction</a>
                            <?php
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
    var c = 0;
    var i = 0;
    var q = 0;

    $(document).on("click", '.btn_complexity', function(event) {
        c = $(this).data('val');
        $.ajax({
            url: 'similar-contributions?c='+c+'&i='+i+'&q='+q,
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                $('#claim-similar').html(response.html);
            }
        });
    });

    $(document).on("click", '.btn_importance', function(event) {
        i = $(this).data('val');
        $.ajax({
            url: 'similar-contributions?c='+c+'&i='+i+'&q='+q,
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                $('#claim-similar').html(response.html);
            }
        });
    });

    $(document).on("click", '.btn_quality', function(event) {
        q = $(this).data('val');
        $.ajax({
            url: 'similar-contributions?c='+c+'&i='+i+'&q='+q,
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                $('#claim-similar').html(response.html);
            }
        });
    });

    $(document).on("click", '#btn_approve', function(event) {
        var c_id = '<?php echo $contribution->id; ?>';
        var data = {'con_id': c_id,'status':1,'c':c,'i':i,'q':q};
        $.ajax({
            url: 'contribution-status',
            dataType: 'json',
            data: data,
            type: 'POST',
            beforeSend: function () {
                showMessage('success', 10000, 'Your contribution are being sent.');
                $('#btn_deny').prop('disabled', false);
                $('#btn_approve').prop('disabled', false);
            },
            success: function (response) {
                if (response.success == true) {
                    showMessage('success',10000,'Success! Your changes have been saved.');
                    $('#claim-approvals').html(response.steward_html);
                    if($('#cq_item_'+c_id).parent().parent().find("li").length == 1) {

                        //$('#claim_details').html('');
                        $('#cq_item_'+c_id).parent().parent().html('<div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
                            '   <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">\n' +
                            '   <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a contribution,<br>it will show up here</div>' +
                            '</div>');

                    }
                    /*else {

                        $('#claim_details').html('<div class="card shadow h-100">\n' +
                            '                        <div class="card-body">\n' +
                            '                            <div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
                            '                                <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">\n' +
                            '                            </div>\n' +
                            '                        </div>\n' +
                            '                    </div>');
                    }*/

                    $('#cq_item_'+c_id).remove();
                }
            }
        });
    });

    $(document).on("click", '#btn_deny', function(event) {
        var c_id = '<?php echo $contribution->id; ?>';
        var data = {'con_id': c_id,'status':2};
        $.ajax({
            url: 'contribution-status',
            dataType: 'json',
            data: data,
            type: 'POST',
            beforeSend: function() {
                showMessage('success',10000,'Your contribution are being sent.');
                $('#btn_deny').prop('disabled', false);
                $('#btn_approve').prop('disabled', false);
            },
            success: function (response) {
                if (response.success == true) {

                    showMessage('success',10000,'Success! Your changes have been saved.');

                    if($('#cq_item_'+c_id).parent().parent().find("li").length == 1) {

                      //  $('#claim_details').html('');
                        $('#cq_item_'+c_id).parent().parent().html('<div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
                            '   <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">\n' +
                            '   <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a contribution,<br>it will show up here</div>' +
                            '</div>');

                    }
/*                    else {

                        $('#claim_details').html('<div class="card shadow h-100">\n' +
                            '                        <div class="card-body">\n' +
                            '                            <div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
                            '                                <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">\n' +
                            '                            </div>\n' +
                            '                        </div>\n' +
                            '                    </div>');
                    }*/

                    $('#cq_item_'+c_id).remove();
                }
            }
        });
    });

    $(document).ready(function() {

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
                        showMessage('success',10000,'Your contribution are being sent.');
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