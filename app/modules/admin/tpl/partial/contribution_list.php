<?php
use Core\Utils;
if($claims != false && count($claims) > 0 ){
    ?>
    <ul class="list-approvals">
    <?php
    foreach ($claims as $claim) {
        ?>
        <li data-item_id="<?php echo $claim['c_id']; ?>" class="list-approvals-item-two c_items" id="cq_item_<?php echo $claim['c_id']; ?>">
            <a class="text-decoration-none" href="#">
                <div class="d-flex align-items-center">
                    <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                        <?php if($claim['form_id'] == 2){ ?>
                            <div><?php echo $claim['form_title']; ?></div>
                        <?php }else{ ?>
                            <div>Lighthouse - Claimed <?php echo $claim['form_title']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                </div>
                <?php
                if ($t == 'Queue'){
                    $is_expired = Utils::isExpired(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$approval_days.' days')));
                    if($is_expired == false) {
                        $date_count = Utils::expire_date_count(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$approval_days.' days')));
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
                ?>
                <div class="fw-medium text-truncate text-muted my-1"><?php echo $claim['contribution_reason']; ?></div>
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
