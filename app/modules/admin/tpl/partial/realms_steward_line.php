<div class="mb-8">
    <div class="stew-<?php echo $id; ?> fw-medium text-muted"><?php echo $steward->name; ?> </div>
    <div class="stew-<?php echo $id; ?> d-flex align-items-center mt-1">
        <div>
            <div class="fs-3 fw-semibold me-6"><?php echo $steward->wallet_adr; ?></div>
            <script>

                var countDownDate_<?php echo $id; ?> = new Date("<?php echo date('Y-m-d H:i:s',strtotime($steward->c_at .' +'.($community->max_voting_time/86400).' days')); ?>").getTime();

                var x_<?php echo $id; ?> = setInterval(function() {

                    var now = new Date().getTime();
                    var distance_<?php echo $id; ?> = countDownDate_<?php echo $id; ?> - now;
                    var hours_<?php echo $id; ?> = Math.floor((distance_<?php echo $id; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes_<?php echo $id; ?> = Math.floor((distance_<?php echo $id; ?> % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds_<?php echo $id; ?> = Math.floor((distance_<?php echo $id; ?> % (1000 * 60)) / 1000);

                    if (countDownDate_<?php echo $id; ?> < now) {
                        clearInterval(x_<?php echo $id; ?>);
                        $(".end_time_<?php echo $id; ?>").html("EXPIRED");
                    }
                    else {
                        $(".end_time_<?php echo $id; ?>").html("Approval period ends in " + hours_<?php echo $id; ?> + "h "
                            + minutes_<?php echo $id; ?> + "m " + seconds_<?php echo $id; ?> + "s ");
                    }
                }, 1000);
            </script>
            <div class="d-flex align-items-center text-blue-stone">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock feather-md"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <div class="fw-medium ms-2 end_time_<?php echo $id; ?>"></div>
            </div>
        </div>
        <div class="ms-auto">
            <?php $praposal_adr = $steward->praposal_adr; ?>
            <a type="button" class="btn btn-primary" target="_blank" href="https://solscan.io/account/<?php echo $praposal_adr; ?>">View Proposal</a>
        </div>
    </div>
</div>