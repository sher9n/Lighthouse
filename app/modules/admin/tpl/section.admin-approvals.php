<?php use Core\Utils; ?>
<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-xl-6 mb-6 mb-xl-0">
                    <div  id="claim_item" class="card shadow h-100 d-none">
                        <div class="card-header border-bottom">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="tab_link nav-link active" id="pills-queue-tab" data-bs-toggle="pill" data-bs-target="#pills-queue" type="button" role="tab" aria-controls="pills-queue" aria-selected="true">Queue</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="tab_link nav-link" id="pills-approved-tab" data-bs-toggle="pill" data-bs-target="#pills-approved" type="button" role="tab" aria-controls="pills-approved" aria-selected="false">Approved</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="tab_link nav-link" id="pills-reviewed-tab" data-bs-toggle="pill" data-bs-target="#pills-reviewed" type="button" role="tab" aria-controls="pills-reviewed" aria-selected="false">Reviewed</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="tab_link nav-link" id="pills-denied-tab" data-bs-toggle="pill" data-bs-target="#pills-denied" type="button" role="tab" aria-controls="pills-denied" aria-selected="false">Denied</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content h-100" id="pills-tabContent">
                            <div class="tab-pane fade h-100 show active" id="pills-queue" role="tabpanel" aria-labelledby="pills-queue-tab">
                                <ul class="list-approvals">
                                    <li class="list-approvals-item-two active">
                                    <a class="text-decoration-none" href="#"> 
                                        <div class="d-flex align-items-center">                   
                                            <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                                                <div>Simple claim form </div>
                                            </div>
                                            <div class="ms-auto fw-medium text-muted">2h 30m ago</div>
                                        </div>
                                        <div class="fw-medium text-truncate text-muted my-1">Completed the Twitter automation bot for marketing.</div>
                                        <ul class="select2-selection__rendered d-flex gap-3">
                                            <li class="select2-selection__choice" title="dfddsfsdf" data-select2-id="141">
                                                <span class="select2-selection__choice__remove" role="presentation">×</span>dfddsfsdf</li>
                                            <li class="select2-selection__choice" title="dfdsfdsf" data-select2-id="142">
                                                <span class="select2-selection__choice__remove" role="presentation">×</span>dfdsfdsf</li>
                                        </ul>
                                    </a>
                                    </li>
                                </ul>
                                   <?php
                                   if(count($__page->claims) > 0) {
                                       ?>
                                        <ul class="list-approvals">
                                       <?php
                                       foreach ($__page->claims as $claim) { ?>
                                            <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item c_items" id="cq_item_<?php echo $claim['c_id']; ?>">
                                                <a class="d-flex text-decoration-none" href="#">
                                                    <div class="d-flex align-items-center px-xl-4 gap-3">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-like.svg" width="40" height="40">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-dislike.svg" width="40" height="40">
                                                    </div>
                                                    <div class="ms-8 col-7">
                                                        <div class="fs-4 fw-semibold text-truncate"><?php echo $claim['ntts']; ?> nt<?php echo $claim['ticker']; ?></div>
                                                        <div class="fw-medium text-truncate"><?php echo $claim['wallet_adr']; ?></div>
                                                        <div class="fw-medium text-muted mt-1">Last claim <?php echo Utils::time_elapsed_string($__page->claim_adrs[$claim['wallet_adr']]); ?></div>
                                                    </div>
                                                    <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                                                </a>
                                            </li>
                                        <?php
                                       }
                                       ?>
                                        </ul>
                                     <?php
                                   }
                                   else{
                                       ?>
                                       <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                           <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                                           <div class="fs-2 fw-semibold mt-20 text-center">Hurray, there's nothing in your queue!</div>
                                           <div class="fw-medium text-muted mt-4">When someone makes a claim, it will show up here. </div>
                                       </div>
                                        <?php
                                   } ?>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-approved" role="tabpanel" aria-labelledby="pills-approved-tab">
                                    <?php
                                    if(count($__page->a_claims) > 0) {
                                        ?>
                                        <ul class="list-approvals">
                                        <?php
                                        foreach ($__page->a_claims as $claim) { ?>
                                            <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item c_items ca_item_<?php echo $claim['c_id']; ?>">
                                                <a class="d-flex text-decoration-none" href="#">
                                                    <div class="d-flex align-items-center px-xl-4 gap-3">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-like.svg" width="40" height="40">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-dislike.svg" width="40" height="40">
                                                    </div>
                                                    <div class="ms-8 col-7">
                                                        <div class="fs-4 fw-semibold text-truncate"><?php echo $claim['ntts']; ?> nt<?php echo $claim['ticker']; ?></div>
                                                        <div class="fw-medium text-truncate"><?php echo $claim['wallet_adr']; ?></div>
                                                        <div class="fw-medium text-muted mt-1">Last claim <?php echo Utils::time_elapsed_string($__page->claim_adrs[$claim['wallet_adr']]); ?></div>
                                                    </div>
                                                    <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        </ul>
                                      <?php
                                    }
                                    else{
                                        ?>
                                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                            <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                                            <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a claim,<br>it will show up here</div>
                                        </div>
                                        <?php
                                    } ?>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-reviewed" role="tabpanel" aria-labelledby="pills-reviewed-tab">
                                    <?php
                                    if($__page->all_claims->num_rows > 0) {
                                        ?>
                                        <ul class="list-approvals">
                                        <?php
                                        foreach ($__page->all_claims as $claim) { ?>
                                            <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item c_items ca_item_<?php echo $claim['c_id']; ?>">
                                                <a class="d-flex text-decoration-none" href="#">
                                                    <div class="d-flex align-items-center px-xl-4 gap-3">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-like.svg" width="40" height="40">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-dislike.svg" width="40" height="40">
                                                    </div>
                                                    <div class="ms-8 col-7">
                                                        <div class="fs-4 fw-semibold text-truncate"><?php echo $claim['ntts']; ?> nt<?php echo $claim['ticker']; ?></div>
                                                        <div class="fw-medium text-truncate"><?php echo $claim['wallet_adr']; ?></div>
                                                        <div class="fw-medium text-muted mt-1">Last claim <?php echo Utils::time_elapsed_string($__page->claim_adrs[$claim['wallet_adr']]); ?></div>
                                                    </div>
                                                    <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                         ?>
                                        </ul>
                                       <?php
                                    }
                                    else{
                                        ?>
                                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                            <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                                            <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a claim,<br>
                                                it will show up here</div>
                                        </div>
                                        <?php
                                    } ?>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-denied" role="tabpanel" aria-labelledby="pills-denied-tab">
                                    <?php
                                    if(count($__page->r_claims) > 0) {
                                        ?>
                                        <ul class="list-approvals">
                                        <?php
                                        foreach ($__page->r_claims as $claim) { ?>
                                            <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item c_items ca_item_<?php echo $claim['c_id']; ?>">
                                                <a class="d-flex text-decoration-none" href="#">
                                                    <div class="d-flex align-items-center px-xl-4 gap-3">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-like.svg" width="40" height="40">
                                                        <img src="<?php echo app_cdn_path; ?>img/icon-dislike.svg" width="40" height="40">
                                                    </div>
                                                    <div class="ms-8 col-7">
                                                        <div class="fs-4 fw-semibold text-truncate"><?php echo $claim['ntts']; ?> nt<?php echo $claim['ticker']; ?></div>
                                                        <div class="fw-medium text-truncate"><?php echo $claim['wallet_adr']; ?></div>
                                                        <div class="fw-medium text-muted mt-1">Last claim <?php echo Utils::time_elapsed_string($__page->claim_adrs[$claim['wallet_adr']]); ?></div>
                                                    </div>
                                                    <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        </ul>
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                            <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                                            <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a claim,<br>
                                                it will show up here</div>
                                        </div>
                                        <?php
                                    } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6" id="claim_details">
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
                                            <input type="radio" class="btn-check" name="ComplexityOptions" id="Complexityoption1" autocomplete="off">
                                            <label class="btn btn-light ms-0" for="Complexityoption1">1</label>

                                            <input type="radio" class="btn-check" name="ComplexityOptions" id="Complexityoption2" autocomplete="off">
                                            <label class="btn btn-light" for="Complexityoption2">2</label>

                                            <input type="radio" class="btn-check" name="ComplexityOptions" id="Complexityoption3" autocomplete="off">
                                            <label class="btn btn-light" for="Complexityoption3">3</label>

                                            <input type="radio" class="btn-check" name="ComplexityOptions" id="Complexityoption4" autocomplete="off">
                                            <label class="btn btn-light" for="Complexityoption4">4</label>

                                            <input type="radio" class="btn-check" name="ComplexityOptions" id="Complexityoption5" autocomplete="off">
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
                                            <input type="radio" class="btn-check" name="ImportanceOptions" id="Importanceoption1" autocomplete="off">
                                            <label class="btn btn-light ms-0" for="Importanceoption1">1</label>

                                            <input type="radio" class="btn-check" name="ImportanceOptions" id="Importanceoption2" autocomplete="off">
                                            <label class="btn btn-light" for="Importanceoption2">2</label>

                                            <input type="radio" class="btn-check" name="ImportanceOptions" id="Importanceoption3" autocomplete="off">
                                            <label class="btn btn-light" for="Importanceoption3">3</label>

                                            <input type="radio" class="btn-check" name="ImportanceOptions" id="Importanceoption4" autocomplete="off">
                                            <label class="btn btn-light" for="Importanceoption4">4</label>

                                            <input type="radio" class="btn-check" name="ImportanceOptions" id="Importanceoption5" autocomplete="off">
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
                                            <input type="radio" class="btn-check" name="QualityOptions" id="Qualityoption1" autocomplete="off">
                                            <label class="btn btn-light ms-0" for="Qualityoption1">1</label>

                                            <input type="radio" class="btn-check" name="QualityOptions" id="Qualityoption2" autocomplete="off">
                                            <label class="btn btn-light" for="Qualityoption2">2</label>

                                            <input type="radio" class="btn-check" name="QualityOptions" id="Qualityoption3" autocomplete="off">
                                            <label class="btn btn-light" for="Qualityoption3">3</label>

                                            <input type="radio" class="btn-check" name="QualityOptions" id="Qualityoption4" autocomplete="off">
                                            <label class="btn btn-light" for="Qualityoption4">4</label>

                                            <input type="radio" class="btn-check" name="QualityOptions" id="Qualityoption5" autocomplete="off">
                                            <label class="btn btn-light me-0" for="Qualityoption5">5</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-10">
                                    <div class="col-8 offset-md-4 text-end">
                                        <button type="button" class="btn btn-white">Deny</button>
                                        <button type="button" class="btn btn-primary">Approve</button>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body p-xl-20 border-top">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item ps-0 pt-0" role="presentation">
                                        <button class="tab_link nav-link active" id="pills-details-tab" data-bs-toggle="pill" data-bs-target="#pills-details" type="button" role="tab" aria-controls="pills-details" aria-selected="true">Details</button>
                                    </li>
                                    <li class="nav-item pt-0" role="presentation">
                                        <button class="tab_link nav-link" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history" type="button" role="tab" aria-controls="pills-history" aria-selected="false">History</button>
                                    </li>
                                    <li class="nav-item pt-0" role="presentation">
                                        <button class="tab_link nav-link" id="pills-approvals-tab" data-bs-toggle="pill" data-bs-target="#pills-approvals" type="button" role="tab" aria-controls="pills-approvals" aria-selected="false">Approvals (2/3)</button>
                                    </li>
                                    <li class="nav-item pt-0" role="presentation">
                                        <button class="tab_link nav-link" id="pills-similar-tab" data-bs-toggle="pill" data-bs-target="#pills-similar" type="button" role="tab" aria-controls="pills-similar" aria-selected="false">Similar Contributions</button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-6" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-details" role="tabpanel" aria-labelledby="pills-details-tab" tabindex="0">
                                        <div class="fw-semibold">Wallet or SNS</div>
                                        <div class="fw-medium fs-4 mt-1">E9kzRXFCiA19gfqFgr8raVygrPra5L2KzPJM5J5Amv2E</div>
                                        <div class="fw-semibold mt-12">Reason</div>
                                        <div class="fw-medium fs-4 mt-1">Grant application to develop an extension to the Mee6 bot on
Discord to auto calculate reputation and provide gated access
to different areas in the server.</div>
                                        <div class="fw-semibold mt-12">Tags</div>
                                        <ul class="select2-selection__rendered d-flex gap-3 mt-1">
                                            <li class="select2-selection__choice" title="dfddsfsdf" data-select2-id="141">
                                                <span class="select2-selection__choice__remove" role="presentation">×</span>dfddsfsdf</li>
                                            <li class="select2-selection__choice" title="dfdsfdsf" data-select2-id="142">
                                                <span class="select2-selection__choice__remove" role="presentation">×</span>dfdsfdsf</li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab" tabindex="0">
                                        <div class="p-8 bg-lighter rounded-1 mb-6">
                                            <div class="text-muted fs-sm">5m ago</div>
                                            <div class="fw-medium mt-1">Completed the Twitter automation bot for marketing.</div>
                                        </div>
                                        <div class="p-8 bg-lighter rounded-1 mb-6">
                                            <div class="text-muted fs-sm">45m ago</div>
                                            <div class="fw-medium mt-1">Submitted proposal for new reputation NFT design.</div>
                                        </div>
                                        <div class="p-8 bg-lighter rounded-1 mb-6">
                                            <div class="text-muted fs-sm">2h 30m ago</div>
                                            <div class="fw-medium mt-1">Grant application to develop an extension to the Mee6 bot
on Discord to auto calculate reputation and provide gated
access to different areas in the server.</div>
                                        </div>
                                        <div class="p-8 bg-lighter rounded-1">
                                            <div class="text-muted fs-sm">5h 15m ago</div>
                                            <div class="fw-medium mt-1">Submitted proposal for new emissions cycle.</div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-approvals" role="tabpanel" aria-labelledby="pills-approvals-tab" tabindex="0">
                                        <div class="fw-semibold">Sheran</div>
                                        <div class="fw-medium fs-4 mt-1">0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507</div>
                                        <a class="fw-medium mt-2 text-primary text-decoration-none" href="#">View Transaction</a>
                                        <div class="fw-semibold mt-12">Potrock</div>
                                        <div class="fw-medium fs-4 mt-1">0xF87cF86F3F0031cB27A1539eAfA4Bd3DBes281752</div>
                                        <a class="fw-medium mt-2 text-primary text-decoration-none" href="#">View Transaction</a>
                                    </div>
                                    <div class="tab-pane fade" id="pills-similar" role="tabpanel" aria-labelledby="pills-similar-tab" tabindex="0">
                                        <div class="d-flex flex-column align-items-center justify-content-center py-25">
                                           <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">                                           
                                           <div class="fw-medium mt-4">No data found.</div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Modal -->
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
    $("#claim_item").removeClass('d-none');
    $("#skeleton_claim").addClass('d-none');

    $(document).on('shown.bs.tab', function (e) {
        $('#claim_details').html('');
    });

    $(document).ready(function() {

        $(document).on("click", '.c_items', function(event) {
            var item = $(this);
            var data = {'claim_id': item.data('item_id')};

            $(".c_items").removeClass('active');
            item.addClass('active');

            $.ajax({
                url: 'claim-details',
                dataType: 'json',
                data: data,
                type: 'POST',
                success: function (response) {
                    if (response.success == true) {
                        $('#claim_details').html(response.html);
                    }
                }
            });
        });

        $(document).on("click", '.claim_deny', function(event) {
            var item = $(this);
            var c_id = item.data('claim_id');
            var data = {'claim_id': item.data('claim_id'),'status':0};

            $.ajax({
                url: 'claim-status',
                dataType: 'json',
                data: data,
                type: 'POST',
                beforeSend: function() {
                    showMessage('success',10000,'Your NTTs are being sent.');
                },
                success: function (response) {
                    if (response.success == true) {

                        showMessage('success',10000,'Success! Your changes have been saved.');

                        if($('#cq_item_'+c_id).parent().parent().find("li").length == 1) {

                            $('#claim_details').html('');
                            $('#cq_item_'+c_id).parent().parent().html('<div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
                            '   <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">\n' +
                            '   <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a claim,<br>it will show up here</div>' +
                            '</div>');

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

                        $('#cq_item_'+c_id).remove();
                    }
                }
            });
        });
    });
</script>