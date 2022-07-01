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
                                   <?php
                                   if(count($__page->claims) > 0) {
                                       ?>
                                        <ul class="list-approvals">
                                       <?php
                                       foreach ($__page->claims as $claim) { ?>
                                           <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item-two c_items" id="cq_item_<?php echo $claim['c_id']; ?>">
                                               <a class="text-decoration-none" href="#">
                                                   <div class="d-flex align-items-center">
                                                       <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                                                           <div><?php echo $claim['form_title']; ?></div>
                                                       </div>
                                                       <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                                                   </div>
                                                   <div class="fw-medium text-truncate text-muted my-1"><?php echo $claim['contribution_reason']; ?></div>
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
                                            <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item-two c_items" id="ca_item_<?php echo $claim['c_id']; ?>">
                                                <a class="text-decoration-none" href="#">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                                                            <div><?php echo $claim['form_title']; ?></div>
                                                        </div>
                                                        <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                                                    </div>
                                                    <div class="fw-medium text-truncate text-muted my-1"><?php echo $claim['contribution_reason']; ?></div>
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
                            <?php if(count($__page->r_claims) > 0) { ?>
                                <ul class="list-approvals">
                                <?php foreach ($__page->r_claims as $claim) { ?>
                                    <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item-two c_items" id="ca_item_<?php echo $claim['c_id']; ?>">
                                        <a class="text-decoration-none" href="#">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                                                    <div><?php echo $claim['form_title']; ?></div>
                                                </div>
                                                <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                                            </div>
                                            <div class="fw-medium text-truncate text-muted my-1"><?php echo $claim['contribution_reason']; ?></div>
                                        </a>
                                    </li>
                                <?php } ?>
                                </ul>
                            <?php }else{ ?>
                                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                    <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
                                    <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a claim,<br>
                                        it will show up here</div>
                                </div>
                            <?php } ?>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-denied" role="tabpanel" aria-labelledby="pills-denied-tab">
                                    <?php
                                    if(count($__page->d_claims) > 0) {
                                        ?>
                                        <ul class="list-approvals">
                                        <?php
                                        foreach ($__page->d_claims as $claim) { ?>
                                            <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item-two c_items" id="ca_item_<?php echo $claim['c_id']; ?>">
                                                <a class="text-decoration-none" href="#">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                                                            <div><?php echo $claim['form_title']; ?></div>
                                                        </div>
                                                        <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                                                    </div>
                                                    <div class="fw-medium text-truncate text-muted my-1"><?php echo $claim['contribution_reason']; ?>/div>
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
        var t = $(e.target).text();
        if(t=='Approved' || t=='Reviewed' || t=='Denied' || t=='Queue')
            $('#claim_details').html('');
    });

    $(document).ready(function() {

        $(document).on("click", '.c_items', function(event) {
            var item = $(this);
            var data = {'con_id': item.data('item_id')};

            $(".c_items").removeClass('active');
            item.addClass('active');

            $.ajax({
                url: 'contribution-details',
                dataType: 'json',
                data: data,
                type: 'POST',
                beforeSend: function () {
                    $("#claim_details").html('<div class="card shadow loading">\n' +
                        '                        <div class="d-flex flex-column h-100">\n' +
                        '                            <div class="card-body p-xl-20">\n' +
                        '                                <div class="display-5-text-content mb-25 w-70"></div>\n' +
                        '                                <div class="row">\n' +
                        '                                    <div class="col-8 offset-md-4">\n' +
                        '                                        <div class="d-flex justify-content-between mb-3">\n' +
                        '                                            <div class="text-content w-20"></div>\n' +
                        '                                            <div class="text-content w-20"></div>\n' +
                        '                                        </div>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                                <div class="row">\n' +
                        '                                    <div class="col-4 align-self-center">\n' +
                        '                                        <div class="fs-lg-text-content w-60"></div>\n' +
                        '                                    </div>\n' +
                        '                                    <div class="col-8">\n' +
                        '                                        <div class="list-rating-scale">\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                        </div>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                                <div class="row mt-4">\n' +
                        '                                    <div class="col-4 align-self-center">\n' +
                        '                                        <div class="fs-lg-text-content w-60"></div>\n' +
                        '                                    </div>\n' +
                        '                                    <div class="col-8">\n' +
                        '                                        <div class="list-rating-scale">\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                        </div>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                                <div class="row mt-4">\n' +
                        '                                    <div class="col-4 align-self-center">\n' +
                        '                                        <div class="fs-lg-text-content w-60"></div>\n' +
                        '                                    </div>\n' +
                        '                                    <div class="col-8">\n' +
                        '                                        <div class="list-rating-scale">\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                            <div class="btn btn-content"></div>\n' +
                        '                                        </div>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                                <div class="row mt-10">\n' +
                        '                                    <div class="col-8 offset-md-4 text-end">\n' +
                        '                                        <div class="btn btn-content w-20"></div>\n' +
                        '                                        <div class="btn btn-content w-20"></div>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                            </div>\n' +
                        '                            <div class="card-body p-xl-20 border-top">\n' +
                        '                                <ul class="nav nav-pills" role="tablist">\n' +
                        '                                    <li class="nav-item ps-0 pt-0" role="presentation">\n' +
                        '                                        <div class="skeleton-tab-nav"></div>\n' +
                        '                                    </li>\n' +
                        '                                    <li class="nav-item pt-0" role="presentation">\n' +
                        '                                        <div class="skeleton-tab-nav"></div>\n' +
                        '                                    </li>\n' +
                        '                                    <li class="nav-item pt-0" role="presentation">\n' +
                        '                                        <div class="skeleton-tab-nav"></div>\n' +
                        '                                    </li>\n' +
                        '                                    <li class="nav-item pt-0" role="presentation">\n' +
                        '                                        <div class="skeleton-tab-nav"></div>\n' +
                        '                                    </li>\n' +
                        '                                </ul>\n' +
                        '                                <div class="mt-10">\n' +
                        '                                    <div class="text-content w-20"></div>\n' +
                        '                                    <div class="fs-4-text-content mt-3"></div>\n' +
                        '                                    <div class="text-content w-40 mt-16"></div>\n' +
                        '                                    <div class="fs-4-text-content mt-3"></div>\n' +
                        '                                    <div class="fs-4-text-content mt-3"></div>\n' +
                        '                                    <div class="text-content w-30 mt-16"></div>\n' +
                        '                                    <div class="fs-4-text-content mt-3"></div>\n' +
                        '                                </div>\n' +
                        '                            </div>                              \n' +
                        '                        </div>\n' +
                        '                    </div>')
                },
                success: function (response) {
                    if (response.success == true) {
                        $('#claim_details').html(response.html);
                    }
                }
            });
        });
    });
</script>