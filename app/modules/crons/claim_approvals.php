<?php
use lighthouse\Contribution;
use lighthouse\Approval;
use lighthouse\Community;
use lighthouse\Api;
use lighthouse\Log;
use lighthouse\Proposal;
exit();
/*if(app_site == 'app') {

    $communities = array();
    $comms = Community::find("SELECT id,blockchain,contract_name,approval_count FROM communities WHERE is_delete=0");
    foreach ($comms as $row)
        $communities[$row['id']] = $row;

    $contributions = Contribution::find("SELECT  con.* FROM contributions con LEFT JOIN forms frm ON con.form_id = frm.id WHERE con.status = 0 AND DATE_ADD(con.c_at, INTERVAL frm.approval_days DAY) <= now()",true);

    foreach ($contributions as $contribution) {

        $com = $communities[$contribution->comunity_id];

        if ($contribution->approvals >= $contribution->approval_count) {
            $blockchain = $com['blockchain'];
            $dao_name = $com['contract_name'];
            $tags = $contribution->tags;
            $approval = Approval::getUserApprovals($contribution->approval_type,$contribution->id);
            $approval = $approval['approvals'];
            $points = 0;

            if ($contribution->scoring == 1 && $contribution->max_point > 0) {
                $maxPoint = $contribution->max_point;

                if ($contribution->approval_type == 2) {
                    $tem = 0;
                    $tem_tot = 0;
                    foreach ($approval as $key => $val) {
                        $tem += $val;
                        $tem_tot += 5;
                    }

                    $points = ($tem_tot > 0)? ($tem/$tem_tot) * $maxPoint :0;
                }
                else
                    $points = $maxPoint;
            }

            if ($blockchain != SOLANA)
                $api_response = Api::AddAttestation(constant(strtoupper($blockchain) . "_API"), $dao_name, $contribution->wallet_to, $points, $contribution->contribution_reason, $tags);
            else
                $api_response = Api::AddSolanaAttestation(constant(strtoupper($blockchain) . "_API"), $dao_name, $contribution->wallet_to, $points, $contribution->contribution_reason, $tags, '');

            if(isset($api_response->error)) {
                $log = new Log();
                $log->type = 'Attestation';
                $log->log = serialize($api_response->error);
                $log->action = 'create-failed';
                $log->type_id = $contribution->id;
                $log->insert();
            } else {
                $contribution->status = 1;
                $contribution->txHash = $api_response->txHash;
                $contribution->score  = $points;
                $contribution->update();
                $log = new Log();
                $log->type = 'Attestation';
                $log->type_id = $contribution->id;
                $log->action = 'created';
                $log->insert();
            }
        }
        else {

            $contribution->status = 2;
            $contribution->update();

            $log = new Log();
            $log->type = 'Contribution';
            $log->type_id = $contribution->id;
            $log->action = 'denied';
            $log->insert();

        }
    }
}*/

?>