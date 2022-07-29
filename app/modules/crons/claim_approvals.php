<?php
use lighthouse\Contribution;
use lighthouse\Approval;

if(app_site == 'app') {

    $claim_all = Contribution::find("SELECT * FROM contributions where status = 0 order by comunity_id");

    foreach ($claim_all as $claim) {
        $approvals = Approval::find("SELECT * FROM approvals where contribution_id = 0 order by comunity_id");
    }

}

?>