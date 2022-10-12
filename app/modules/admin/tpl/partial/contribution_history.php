<?php foreach ($contributions as $contribution){ ?>
    <li class="list-history-item">
        <a class="text-decoration-none" href="#">
            <div class="d-flex align-items-center">
                <div class="fs-4 fw-semibold text-truncate d-flex align-items-center">
                    <!--<div>N/A points</div>
                    <div class="text-muted mx-3">•</div>-->
                    <?php
                    if($contribution['is_realms'] == 0){
                        if($contribution['form_id'] == 2 ) {
                            ?>
                            <div><?php echo $contribution['form_title']; ?></div>
                            <?php
                        }
                        else {
                            ?>
                            <div><?php echo $contribution['score']; ?> Points • <?php echo $contribution['form_title']; ?></div>
                            <?php
                        }
                    }
                    else if($contribution['is_realms'] == 1){
                        if($contribution['realms_status'] == 'Succeeded'){ ?>
                            <div>SPL Governance • Passed Proposal</div>
                            <?php
                        }
                        else{ ?>
                            <div>SPL Governance • Created Proposal</div>
                            <?php
                        }
                    }
                    else{?>
                        <div>SPL Governance • Voted</div>
                        <?php
                    } ?>
                </div>
                <div class="ms-auto fw-medium text-muted"><?php echo \Core\Utils::time_elapsed_string($contribution['c_at'],false,true); ?></div>
            </div>
            <div class="fw-medium text-truncate text-muted my-1"><?php echo $contribution['contribution_reason']?></div>
            <ul class="select2-selection__rendered d-flex gap-3">
                <?php if(strlen($contribution['tags']) >0 ){ ?>
                <li class="select2-selection__choice" title="dfddsfsdf" data-select2-id="141"><?php echo $contribution['tags']; ?></li>
                <?php } ?>
            </ul>
        </a>
    </li>
    <!-- Skeleton -->

    <!-- Skeleton END -->
<?php } ?>