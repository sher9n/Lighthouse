<?php use Core\Utils; ?>
<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-xl-6 mb-6 mb-xl-0">
                    <div class="card shadow h-100">
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
                                   <?php
                                   if(count($__page->claims) > 0) {
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
                                </ul>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-approved" role="tabpanel" aria-labelledby="pills-approved-tab">
                                <ul class="list-approvals">
                                    <?php
                                    if(count($__page->a_claims) > 0) {
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
                                    }
                                    else{
                                        ?>
                                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                            <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                                            <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a claim,<br>it will show up here</div>
                                        </div>
                                        <?php
                                    } ?>
                                </ul>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-reviewed" role="tabpanel" aria-labelledby="pills-reviewed-tab">
                                <ul class="list-approvals">
                                    <?php
                                    if($__page->all_claims->num_rows > 0) {
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
                                </ul>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-denied" role="tabpanel" aria-labelledby="pills-denied-tab">
                                <ul class="list-approvals">
                                    <?php
                                    if(count($__page->r_claims) > 0) {
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
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- skeleton loader -->
                    <div class="card shadow h-100 d-none">
                        <div class="card-header border-bottom">
                            <div class="d-flex loading">
                                <div class="nav-link"><div class="text-content mw-80"></div></div>                                
                                <div class="nav-link"><div class="text-content mw-80"></div></div>
                                <div class="nav-link"><div class="text-content mw-80"></div></div>
                                <div class="nav-link"><div class="text-content mw-80"></div></div>
                            </div>
                        </div>
                        <div>
                            <ul class="list-approvals">
                                <li class="list-approvals-item">
                                    <a class="d-flex text-decoration-none loading" href="#">
                                        <div class="d-flex align-items-center px-xl-4 gap-3">
                                            <div class="icon-content rounded-circle"></div>
                                            <div class="icon-content rounded-circle"></div>
                                        </div>
                                        <div class="ms-8 col-7">
                                            <div class="fs-4-text-content w-60"></div>
                                            <div class="text-content mt-2 w-100"></div>
                                            <div class="text-content mt-1 w-30"></div>
                                        </div>
                                        <div class="ms-auto"><div class="text-content mw-40"></div></div>
                                    </a>
                                </li>
                                <li class="list-approvals-item">
                                    <a class="d-flex text-decoration-none loading" href="#">
                                        <div class="d-flex align-items-center px-xl-4 gap-3">
                                            <div class="icon-content rounded-circle"></div>
                                            <div class="icon-content rounded-circle"></div>
                                        </div>
                                        <div class="ms-8 col-7">
                                            <div class="fs-4-text-content w-60"></div>
                                            <div class="text-content mt-2 w-100"></div>
                                            <div class="text-content mt-1 w-30"></div>
                                        </div>
                                        <div class="ms-auto"><div class="text-content mw-40"></div></div>
                                    </a>
                                </li>
                                <li class="list-approvals-item">
                                    <a class="d-flex text-decoration-none loading" href="#">
                                        <div class="d-flex align-items-center px-xl-4 gap-3">
                                            <div class="icon-content rounded-circle"></div>
                                            <div class="icon-content rounded-circle"></div>
                                        </div>
                                        <div class="ms-8 col-7">
                                            <div class="fs-4-text-content w-60"></div>
                                            <div class="text-content mt-2 w-100"></div>
                                            <div class="text-content mt-1 w-30"></div>
                                        </div>
                                        <div class="ms-auto"><div class="text-content mw-40"></div></div>
                                    </a>
                                </li>
                                <li class="list-approvals-item">
                                    <a class="d-flex text-decoration-none loading" href="#">
                                        <div class="d-flex align-items-center px-xl-4 gap-3">
                                            <div class="icon-content rounded-circle"></div>
                                            <div class="icon-content rounded-circle"></div>
                                        </div>
                                        <div class="ms-8 col-7">
                                            <div class="fs-4-text-content w-60"></div>
                                            <div class="text-content mt-2 w-100"></div>
                                            <div class="text-content mt-1 w-30"></div>
                                        </div>
                                        <div class="ms-auto"><div class="text-content mw-40"></div></div>
                                    </a>
                                </li>
                                <li class="list-approvals-item">
                                    <a class="d-flex text-decoration-none loading" href="#">
                                        <div class="d-flex align-items-center px-xl-4 gap-3">
                                            <div class="icon-content rounded-circle"></div>
                                            <div class="icon-content rounded-circle"></div>
                                        </div>
                                        <div class="ms-8 col-7">
                                            <div class="fs-4-text-content w-60"></div>
                                            <div class="text-content mt-2 w-100"></div>
                                            <div class="text-content mt-1 w-30"></div>
                                        </div>
                                        <div class="ms-auto"><div class="text-content mw-40"></div></div>
                                    </a>
                                </li>
                                <li class="list-approvals-item">
                                    <a class="d-flex text-decoration-none loading" href="#">
                                        <div class="d-flex align-items-center px-xl-4 gap-3">
                                            <div class="icon-content rounded-circle"></div>
                                            <div class="icon-content rounded-circle"></div>
                                        </div>
                                        <div class="ms-8 col-7">
                                            <div class="fs-4-text-content w-60"></div>
                                            <div class="text-content mt-2 w-100"></div>
                                            <div class="text-content mt-1 w-30"></div>
                                        </div>
                                        <div class="ms-auto"><div class="text-content mw-40"></div></div>
                                    </a>
                                </li>
                                <li class="list-approvals-item">
                                    <a class="d-flex text-decoration-none loading" href="#">
                                        <div class="d-flex align-items-center px-xl-4 gap-3">
                                            <div class="icon-content rounded-circle"></div>
                                            <div class="icon-content rounded-circle"></div>
                                        </div>
                                        <div class="ms-8 col-7">
                                            <div class="fs-4-text-content w-60"></div>
                                            <div class="text-content mt-2 w-100"></div>
                                            <div class="text-content mt-1 w-30"></div>
                                        </div>
                                        <div class="ms-auto"><div class="text-content mw-40"></div></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- skeleton loader END -->

                </div>
                <div class="col-xl-6" id="claim_details">
                    <!-- skeleton loader -->
                    <div class="card shadow d-none">
                        <div class="card-body p-xl-20 mb-xl-20">
                            <div class="display-5-text-content w-30 loading"></div>
                            <div class="text-content w-20 mt-20 mb-3 loading"></div>                            
                            <div class="fs-3-text-content w-40 loading"></div>
                            <div class="text-content w-20 mt-18 mb-3 loading"></div>                            
                            <div>
                                <div class="row g-6 loading">
                                    <div class="col-xl-3">
                                        <div class="input-form-lg rounded-3"></div>                                        
                                    </div>
                                    <div class="col-xl">
                                        <div class="input-form-lg rounded-3"></div>
                                    </div>
                                    <div class="col-xl">
                                        <div class="input-form-lg rounded-3"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-content w-20 mt-18 mb-3 loading"></div>
                            <div class="input-form-xl rounded-3 loading"></div>
                            <div class="text-content w-20 mt-18 mb-3 loading"></div>
                            <div class="input-form-xxl rounded-3 loading"></div>
                        </div>
                       
                        <div class="action_buttons card-body border-top d-flex justify-content-end gap-3">
                            <div class="skeleton-btn-gray rounded loading"></div>
                            <div class="skeleton-btn-gray rounded loading"></div>
                        </div>
                       
                    </div>
                    <!-- skeleton loader END -->
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

    $(document).on('shown.bs.tab', function (e) {
        $('#claim_details').html('');
    });

    $(document).ready(function() {

        $(document).on("click", '.c_items', function(event) {
            var item = $(this);
            $(".c_items").removeClass('active');
            item.addClass('active');
            var data = {'claim_id': item.data('item_id')};

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

        $(document).on("click", '.claim_approve', function(event) {
            var item = $(this);
            var c_id = item.data('claim_id');
            var data = {'claim_id': item.data('claim_id'),'status':1};

            $.ajax({
                url: 'claim-status',
                dataType: 'json',
                data: data,
                type: 'POST',
                beforeSend: function() {
                    showMessage('success',10000,'Your NTTs are being sent.');
                },
                success: function (data) {
                    if (data.success == true) {

                        showMessage('success', 10000, data.message);

                        if($('#cq_item_'+c_id).parent().parent().find("li").length == 1) {
                            $('#cq_item_'+c_id).parent().parent().html('<div class="d-flex flex-column align-items-center justify-content-center h-100">\n' +
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
                        $('#cq_item_'+c_id).remove();
                    }
                    else
                        showMessage('danger',1000,data.message);
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