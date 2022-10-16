<?php use Core\Utils; ?>
<div>
        <div class="d-flex align-items-center fw-medium">
            <a class="text-blue-stone me-2 text-decoration-none">Modify</a>
            <div class="text-muted">Quorum</div>
        </div>
        <div class="d-flex align-items-center fw-medium text-gray-700">
            <div class="fs-2"><?php echo $qdata->c; ?></div>
            <div class="fs-3">/<?php echo $stewardCount; ?></div>
        </div>
         <?php
         $date_count = Utils::expire_date_count(date("Y-m-d H:i:s"),date('Y-m-d H:i:s',strtotime($proposal->c_at .' +'.($community->max_voting_time/86400).' days')));
         if(!is_null($date_count)) {
             ?>
             <div class="d-flex align-items-center text-blue-stone">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                 <div class="fw-medium ms-2 end_time_<?php echo $qid; ?>">Approval period ends in <?php echo $date_count; ?></div>
             </div>
             <?php
         }
         else{
             ?>
            <script>

                var countDownDate_<?php echo $qid; ?> = new Date("<?php echo date('Y-m-d H:i:s',strtotime($proposal->c_at .' +'.($community->max_voting_time/86400).' days')); ?>").getTime();

                var x_<?php echo $qid; ?> = setInterval(function() {

                    var now = new Date().getTime();
                    var distance_<?php echo $qid; ?> = countDownDate_<?php echo $qid; ?> - now;
                    var hours_<?php echo $qid; ?> = Math.floor((distance_<?php echo $qid; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes_<?php echo $qid; ?> = Math.floor((distance_<?php echo $qid; ?> % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds_<?php echo $qid; ?> = Math.floor((distance_<?php echo $qid; ?> % (1000 * 60)) / 1000);

                    if (countDownDate_<?php echo $qid; ?> < now) {
                        clearInterval(x_<?php echo $qid; ?>);
                        $(".end_time_<?php echo $qid; ?>").html("EXPIRED");
                    }
                    else {
                        $(".end_time_<?php echo $qid; ?>").html("Approval period ends in " + hours_<?php echo $qid; ?> + "h "
                            + minutes_<?php echo $qid; ?> + "m " + seconds_<?php echo $qid; ?> + "s ");
                    }
                }, 1000);
            </script>
            <div class="d-flex align-items-center text-blue-stone">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div class="fw-medium ms-2 end_time_<?php echo $qid; ?>"></div>
            </div>
            <?php
         }
    ?>
    </div>
 <div class="text-end">
        <div class="fw-medium text-muted mb-1"><?php echo (int)$proposal->proposal_yes_count; ?> of <?php echo $stewardCount; ?> Approved</div>
        <div>
            <?php
            if(!isset($user_votes[$qid])){?>
                <a type="button" data-pid="<?php echo $qid; ?>" data-vote="NO" id="deny_<?php echo $qid; ?>" class="admin_proposal_vote btn btn-secondary me-2">Deny</a>
                <a type="button" data-pid="<?php echo $qid; ?>" data-vote="YES" id="approve_<?php echo $qid; ?>" class="admin_proposal_vote btn btn-blue-stone">Approve</a>
                <?php
            }
            ?>
        </div>
        <div class="d-flex align-items-center justify-content-end mt-2">
            <div class="fw-semibold me-2">View Proposal</div>
            <a target="_blank" href="https://solscan.io/account/<?php echo $proposal->proposal_adr ; ?>?cluster=devnet" class="text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            </a>
        </div>
    </div>
