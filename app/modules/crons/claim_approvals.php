<?php
use lighthouse\Contribution;
use lighthouse\Approval;
use lighthouse\Community;

if(app_site == 'app') {

    $communities = array();
    $comms = Community::find("SELECT id,approval_count FROM communities WHERE is_delete=0");
    foreach ($comms as $com)
        $communities[$com['id']] = $com['approval_count'];

    /*$contributions = Contribution::find("SELECT * FROM contributions where status = 0 order by comunity_id",true);
    foreach ($contributions as $contribution){

        if($contribution->approvals == $communities[$contribution->comunity_id]) {
            $blockchain = $community->blockchain;
            $dao_domain = $community->dao_domain;
            $tags       = $contribution->tags;
            if($blockchain != SOLANA)
                $api_response = Api::AddAttestation(constant(strtoupper($blockchain) . "_API"), $dao_domain,$contribution->wallet_to,$points,$contribution->contribution_reason,$tags);
            else
                $api_response = Api::AddSolanaAttestation(constant(strtoupper($blockchain) . "_API"), $dao_domain,$contribution->wallet_to,$points,$contribution->contribution_reason,$tags,'');

            if (isset($api_response->error)) {
                $log = new Log();
                $log->type = 'Attestation';
                $log->log = serialize($api_response->error);
                $log->action = 'create-failed';
                $log->type_id = $contribution->id;
                $log->c_by = $sel_wallet_adr;
                $log->insert();

                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to create attestation, please retry again.'));
                exit();
            }
            else {
                $contribution->status = 1;
                $approve = true;
                $contribution->txHash = $api_response->txHash;

                $contribution->update();
                $approval->insert();

                $log = new Log();
                $log->type = 'Contribution';
                $log->type_id = $contribution->id;
                $log->action = 'created';
                $log->c_by = $sel_wallet_adr;
                $log->insert();

                $contribution_id = $contribution->id;
                $stewards = $community->getStewards();
                $html = '';
                foreach (Approval::getApprovals($contribution_id) as $stewd_adr) {
                    $steward = $stewards[$stewd_adr];
                    $html .= '<div class="fw-semibold">'.$steward["name"].'</div><div class="fw-medium fs-4 mt-1">'.$steward["wallet_adr"].'</div>';
                }

                $view_transaction_link = '';
                if($community->blockchain == SOLANA)
                    $view_transaction_link = SOLANA_VIEW_LINK.'tx/'.$contribution->txHash;
                elseif ($community->blockchain == OPTIMISM)
                    $view_transaction_link = OPTIMISM_VIEW_LINK.'tx/'.$contribution->txHash;
                else
                    $view_transaction_link = GNOSIS_CHAIN_VIEW_LINK.'tx/'.$contribution->txHash;

                echo json_encode(array('success' => true,
                        'approve' => $approve ,
                        'steward_html' => $html,
                        'c_id' => $contribution->id,
                        'message' => 'Success! Your attestation has been recorded. <a target="_blank" class="text-white ms-1" href="'.$view_transaction_link.'">View Transaction</a>')
                );
                exit();
            }
        }
    }*/
}

?>