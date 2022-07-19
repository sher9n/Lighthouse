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
                        <div><?php echo $claim['form_title']; ?></div>
                    </div>
                    <div class="ms-auto fw-medium text-muted"><?php echo Utils::time_elapsed_string($claim['c_at'],false,true); ?></div>
                </div>
                <?php
                if ($t == 'Queue'){
                    $is_expired = Utils::isExpired(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$approval_days.' days')));
                    if($is_expired == false) {
                        ?>
                        <div class="d-flex align-items-center text-blue-stone my-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <div class="fw-medium ms-2 end_time_<?php echo $claim['c_id']; ?>"></div>
                        </div>
                        <script>

                            var countDownDate = new Date("<?php echo date('Y-m-d H:i:s',strtotime($claim['c_at'] .' +'.$approval_days.' days')); ?>").getTime();

                            var x = setInterval(function() {

                                var now = new Date().getTime();

                                var distance = countDownDate - now;

                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                $(".end_time_<?php echo $claim['c_id']; ?>").html("Approval period ends in "+days + "d " + hours + "h "
                                    + minutes + "m " + seconds + "s ");

                                if (distance < 0) {
                                    clearInterval(x);
                                    $(".end_time_<?php echo $claim['c_id']; ?>").html("EXPIRED");
                                }
                            }, 1000);
                        </script>
                        <?php
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
