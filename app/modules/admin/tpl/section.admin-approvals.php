<?php use Core\Utils; ?>
<main>
    <?php require_once 'partial/admin-leftmenu.php'; ?>
    <section class="admin-body-section">
        <div class="container-fluid h-100">
            <?php
            if($__page->user->ntt_consent_bar != 1){
                require_once app_root. "/modules/admin/tpl/partial/ntt-consent-bar.php";
            } ?>
            <div class="row h-100">
                <div class="col-xl-6 mb-6 mb-xl-0">
                    <div  id="claim_item" class="card shadow h-100 d-none">
                        <div class="card-header border-bottom">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="tab_link nav-link active" id="pills-queue-tab" data-bs-toggle="pill" data-bs-target="#pills-queue" type="button" role="tab" aria-controls="pills-queue" aria-selected="true">Claims</button>
                                </li>
                                <?php if($__page->is_admin != false){ ?>
                                <li class="nav-item" role="presentation">
                                    <button class="tab_link nav-link" id="pills-reviewed-tab" data-bs-toggle="pill" data-bs-target="#pills-reviewed" type="button" role="tab" aria-controls="pills-reviewed" aria-selected="false">Queued</button>
                                </li>
                                <?php } ?>
                                <li class="nav-item" role="presentation">
                                    <button class="tab_link nav-link" id="pills-approved-tab" data-bs-toggle="pill" data-bs-target="#pills-approved" type="button" role="tab" aria-controls="pills-approved" aria-selected="false">Attested</button>
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
                                            <li data-item_id="<?php echo $claim['c_id']; ?>" data-proposal_id="<?php echo $claim['proposal_id']; ?>" class="list-approvals-item-two c_items" id="cq_item_<?php echo $claim['c_id']; ?>">
                                                <a class="text-decoration-none" href="#">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                                                            <?php if($claim['form_id'] == 2){ ?>
                                                                <div><?php echo $claim['form_title']; ?></div>
                                                            <?php }else{ ?>
                                                                <div><?php echo $claim['form_title']; ?></div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                                                    </div>
                                                    <?php
                                                        $is_expired = Utils::isExpired(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$__page->approval_days.' days')));
                                                        if($is_expired == false) {
                                                            $date_count = Utils::expire_date_count(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$__page->approval_days.' days')));
                                                            if(!is_null($date_count)) {
                                                                ?>
                                                                <div class="d-flex align-items-center text-blue-stone my-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                                    <div class="fw-medium ms-2 end_time_<?php echo $claim['c_id']; ?>">Attestation Period ends in <?php echo $date_count; ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                            else {
                                                                ?>
                                                                <div class="d-flex align-items-center text-blue-stone my-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                                    <div class="fw-medium ms-2 end_time_<?php echo $claim['c_id']; ?>"></div>
                                                                </div>
                                                                <script>

                                                                    var countDownDate_<?php echo $claim['c_id']; ?> = new Date("<?php echo date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$__page->approval_days.' days')); ?>").getTime();

                                                                    var x_<?php echo $claim['c_id']; ?> = setInterval(function() {

                                                                        var now = new Date().getTime();
                                                                        var distance_<?php echo $claim['c_id']; ?> = countDownDate_<?php echo $claim['c_id']; ?> - now;
                                                                        var hours_<?php echo $claim['c_id']; ?> = Math.floor((distance_<?php echo $claim['c_id']; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                        var minutes_<?php echo $claim['c_id']; ?> = Math.floor((distance_<?php echo $claim['c_id']; ?> % (1000 * 60 * 60)) / (1000 * 60));
                                                                        var seconds_<?php echo $claim['c_id']; ?> = Math.floor((distance_<?php echo $claim['c_id']; ?> % (1000 * 60)) / 1000);

                                                                        if (countDownDate_<?php echo $claim['c_id']; ?> < now) {
                                                                            clearInterval(x_<?php echo $claim['c_id']; ?>);
                                                                            $(".end_time_<?php echo $claim['c_id']; ?>").html("EXPIRED");
                                                                        }
                                                                        else {
                                                                            $(".end_time_<?php echo $claim['c_id']; ?>").html("Attestation Period ends in " + hours_<?php echo $claim['c_id']; ?> + "h "
                                                                                + minutes_<?php echo $claim['c_id']; ?> + "m " + seconds_<?php echo $claim['c_id']; ?> + "s ");
                                                                        }
                                                                    }, 1000);
                                                                </script>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                    <!--<div class="fw-medium text-truncate text-muted my-1"><?php /*echo $claim['contribution_reason']; */?></div>-->
                                                    <ul class="select2-selection__rendered d-flex gap-3">
                                                        <?php
                                                        if(isset($claim['tags']) && strlen($claim['tags']) > 0){
                                                            $tags_arry = explode(",",$claim['tags']);
                                                            foreach ($tags_arry as $tag){ ?>

                                                                <li class="select2-selection__choice" title="<?php echo $tag; ?>" data-select2-id="141"><?php echo $tag; ?></li>
                                                                <?php
                                                            }
                                                        } ?>
                                                    </ul>
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
                                        <div class="fs-2 fw-semibold mt-20 text-center">Hurray, there's nothing in your claims!</div>
                                        <div class="fw-medium text-muted mt-4">When someone makes a claim, it will show up here. </div>
                                    </div>
                                    <?php
                                } ?>
                            </div>
                            <div class="tab-pane fade h-100" id="pills-reviewed" role="tabpanel" aria-labelledby="pills-reviewed-tab">
                            </div>
                            <div class="tab-pane fade h-100" id="pills-approved" role="tabpanel" aria-labelledby="pills-approved-tab">
                            </div>
                            <div class="tab-pane fade h-100" id="pills-denied" role="tabpanel" aria-labelledby="pills-denied-tab">
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
    $("#claim_item").removeClass('d-none');
    $("#skeleton_claim").addClass('d-none');

    $(document).on('shown.bs.tab', function (e) {
        var t = $(e.target).text();
        if(t=='Claims' || t=='Queued' || t=='Attested' || t=='Denied') {
            $('#claim_details').html('');

            $.ajax({
                url: 'contribution-list?t='+t,
                dataType: 'json',
                type: 'GET',
                beforeSend: function (){
                    $('#pills-approved, #pills-reviewed, #pills-denied, #pills-queue').html('<ul class="list-approvals"><div class="d-flex flex-column loading">\n' +
                        '            <div class="list-approvals-item-two">\n' +
                        '                <div class="text-decoration-none">\n' +
                        '                    <div class="d-flex align-items-center my-1">\n' +
                        '                        <div class="fs-4-text-content w-40"></div>\n' +
                        '                        <div class="ms-auto text-content w-10"></div>\n' +
                        '                    </div>\n' +
                        '                    <div class="text-content my-3"></div>\n' +
                        '                    <div class="skeleton-btn-gray rounded"></div>\n' +
                        '                </div>\n' +
                        '            </div>\n' +
                        '            <div class="list-approvals-item-two">\n' +
                        '                <div class="text-decoration-none">\n' +
                        '                    <div class="d-flex align-items-center my-1">\n' +
                        '                        <div class="fs-4-text-content w-40"></div>\n' +
                        '                        <div class="ms-auto text-content w-10"></div>\n' +
                        '                    </div>\n' +
                        '                    <div class="text-content my-3"></div>\n' +
                        '                    <div class="skeleton-btn-gray rounded"></div>\n' +
                        '                </div>\n' +
                        '            </div>\n' +
                        '            <div class="list-approvals-item-two">\n' +
                        '                <div class="text-decoration-none">\n' +
                        '                    <div class="d-flex align-items-center my-1">\n' +
                        '                        <div class="fs-4-text-content w-40"></div>\n' +
                        '                        <div class="ms-auto text-content w-10"></div>\n' +
                        '                    </div>\n' +
                        '                    <div class="text-content my-3"></div>\n' +
                        '                    <div class="skeleton-btn-gray rounded"></div>\n' +
                        '                </div>\n' +
                        '            </div>\n' +
                        '            <div class="list-approvals-item-two">\n' +
                        '                <div class="text-decoration-none">\n' +
                        '                    <div class="d-flex align-items-center my-1">\n' +
                        '                        <div class="fs-4-text-content w-40"></div>\n' +
                        '                        <div class="ms-auto text-content w-10"></div>\n' +
                        '                    </div>\n' +
                        '                    <div class="text-content my-3"></div>\n' +
                        '                    <div class="skeleton-btn-gray rounded"></div>\n' +
                        '                </div>\n' +
                        '            </div>\n' +
                        '            <div class="list-approvals-item-two border-bottom-0">\n' +
                        '                <div class="text-decoration-none">\n' +
                        '                    <div class="d-flex align-items-center my-1">\n' +
                        '                        <div class="fs-4-text-content w-40"></div>\n' +
                        '                        <div class="ms-auto text-content w-10"></div>\n' +
                        '                    </div>\n' +
                        '                    <div class="text-content my-3"></div>\n' +
                        '                    <div class="skeleton-btn-gray rounded"></div>\n' +
                        '                </div>\n' +
                        '            </div>\n' +
                        '        </div></ul>');
                },
                success: function (response) {
                    if (response.success == true) {
                        if (t == 'Attested')
                            $('#pills-approved').html(response.html);
                        else if(t == 'Queued')
                            $('#pills-reviewed').html(response.html);
                        else if(t == 'Denied')
                            $('#pills-denied').html(response.html);
                        else
                            $('#pills-queue').html(response.html);
                    }
                }
            });
        }
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
                        '                            <div class="card-body p-xxl-20">\n' +
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
                        '                            <div class="card-body p-xxl-20 border-top">\n' +
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

            checkProposalState(item.data('proposal_id'));
        });
    });

    function checkProposalState(pid) {
        $.ajax({
            url: 'get-proposal?pid='+pid,
            dataType: 'json'
        });
    }
</script>