<?php
use lighthouse\Claim;
use lighthouse\Approval;

if(app_site == 'app') {

    $claim_all = Claim::find("SELECT * FROM claims where status = 0 order by comunity_id");

    foreach ($claim_all as $claim) {
        $approvals = Approval::find("SELECT * FROM approvals where contribution_id = 0 order by comunity_id");
    }

}

?>