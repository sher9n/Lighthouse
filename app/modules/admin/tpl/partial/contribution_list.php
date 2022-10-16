<?php
use Core\Utils;
use lighthouse\User;
if($claims != false && count($claims) > 0 ){
    ?>
    <ul class="list-approvals">
    <?php
    foreach ($claims as $claim) {
        ?>
        <li data-proposal_id="<?php echo $claim['proposal_id']; ?>" data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item-two c_items" id="cq_item_<?php echo $claim['c_id']; ?>">
            <a class="text-decoration-none" href="#">
                <div id="cq_item_title_<?php echo $claim['c_id']; ?>" class="d-flex align-items-center">
                    <div  class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                        <?php if($claim['form_id'] == 2){ ?>
                            <div><?php echo $claim['form_title']; ?></div>
                        <?php }else{ ?>
                            <div><?php echo $claim['form_title']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                </div>
                <?php
                if ($t == 'Queued' || $t == 'Claims'){
                    $is_expired = Utils::isExpired(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$approval_days.' days')));
                    if($is_expired == false) {
                        $date_count = Utils::expire_date_count(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$approval_days.' days')));
                        if(!is_null($date_count)) {
                            ?>
                            <div class="d-flex align-items-center text-blue-stone my-1 msg-<?php echo $claim['c_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <div class="fw-medium ms-2 end_time_<?php echo $claim['c_id']; ?>">Attestation Period ends in <?php echo $date_count; ?></div>
                            </div>
                        <?php
                        }
                        else {
                        ?>
                            <div class="d-flex align-items-center text-blue-stone my-1 msg-<?php echo $claim['c_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <div class="fw-medium ms-2 end_time_<?php echo $claim['c_id']; ?>"></div>
                            </div>
                            <script>

                                var countDownDate_<?php echo $claim['c_id']; ?> = new Date("<?php echo date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$approval_days.' days')); ?>").getTime();

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
                }

                if($claim['proposal_state'] == \lighthouse\Proposal::PROPOSAL_STATE_SUCCEEDED && $claim['is_executed']==\lighthouse\Proposal::PROPOSAL_EXECUTE_PENDING){
                    $user = User::isExistUser($claim['wallet_to'],$com_id);

                    if($user instanceof User && $user->ntt_consent == 1){
                        ?>
                        <div class="d-flex align-items-center text-orange my-1 msg-<?php echo $claim['c_id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle feather-md"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <div class="fw-medium ms-2">Execution pending</div>
                        </div>
                        <?php
                    }
                    else {
                        ?>
                        <div class="d-flex align-items-center text-muted my-1 msg-<?php echo $claim['c_id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle feather-md"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            <div class="fw-medium ms-2">Execution unavailable until member consents to NTTs</div>
                        </div>
                        <?php
                    }
                }
                elseif ( $claim['proposal_state'] == \lighthouse\Proposal::PROPOSAL_STATE_EXECUTED && $claim['is_executed']==\lighthouse\Proposal::PROPOSAL_EXECUTED) {
                    ?>
                    <div class="d-flex align-items-center text-blue-stone my-1 msg-<?php echo $claim['c_id']; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 22 22">
                            <g id="Group_5834" data-name="Group 5834" transform="translate(-807 -400)">
                                <circle id="Ellipse_383" data-name="Ellipse 383" cx="10" cy="10" r="10" transform="translate(808 401)" fill="none" stroke="#006064" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <path id="Path_6496" data-name="Path 6496" d="M15.662,4,10.537,9.13,7.828,6.666" transform="translate(806.669 404.436)" fill="none" stroke="#006064" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            </g>
                        </svg>
                        <div class="fw-medium ms-2">Executed</div>
                    </div>
                    <?php
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
else {
    ?>
    <div class="d-flex flex-column align-items-center justify-content-center h-100">
        <img src="<?php echo app_cdn_path; ?>img/img-empty.svg" width="208">
        <div class="fs-2 fw-semibold mt-20 text-center">When someone makes a claim,<br>it will show up here</div>
    </div>
    <?php
}
?>
