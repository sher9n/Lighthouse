<?php
use lighthouse\Api;
use lighthouse\Log;
use lighthouse\Proposal;
use lighthouse\Contribution;
use lighthouse\User;
use lighthouse\Form;
use lighthouse\Approval;

if(app_site == 'app') {

    $props = Proposal::find("SELECT p.*,c.contract_name FROM proposals p LEFT JOIN communities c ON p.comunity_id=c.id WHERE p.is_delete=0 AND p.is_executed=0 AND p.id=123 LIMIT 1");
    foreach ($props as $prop){
        $api_response = API::getSolanaProposal(constant(strtoupper(SOLANA) . "_API"), $prop['contract_name'], $prop['proposal_id']);

        if(isset($api_response->error)) {
            $log = new Log();
            $log->type      = 'Proposal';
            $log->log       = serialize($api_response->error);
            $log->action    = 'read-failed';
            $log->type_id   = $prop['id'];
            $log->insert();

            unset($prop['contract_name']);
            $p = new Proposal();
            $p->load($prop);

            if($p->is_checked == 2){
                $p->proposal_state  = Proposal::PROPOSAL_STATE_DEFEATED;
                $p->is_executed     = Proposal::PROPOSAL_EXECUTE_DEFEATED;
            }

            $p->is_checked += 1;
            $p->update();
        }
        else
        {
            if($api_response->state == Proposal::PROPOSAL_STATE_SUCCEEDED) {
                unset($prop['contract_name']);
                $p = new Proposal();
                $p->load($prop);

                $contribution  = Contribution::get($p->object_id);
                $user          = $user = User::isExistUser($contribution->comunity_id,$contribution->wallet_to);
                $ntt_consent   = 0;
                if($user instanceof User)
                    $ntt_consent = $user->ntt_consent;

                if($ntt_consent == 0) {

                    $contribution->status = 1;

                    if($contribution->approval_type == Form::APPROVAL_TYPE_BINARY)
                        $contribution->score  = $contribution->max_point;
                    else
                    {
                        $points = 0;

                        if ($contribution->scoring == 1 && $contribution->max_point > 0) {
                            $maxPoint = $contribution->max_point;
                            $tem      = 0;
                            $tem_tot  = 0;

                            $approval = Approval::getUserApprovals($contribution->approval_type,$contribution->id);
                            $approval = $approval['approvals'];

                            foreach ($approval as $key => $val) {
                                $tem     += $val;
                                $tem_tot += $tem;
                            }

                            $points = ($tem_tot > 0)? ($tem/$tem_tot) * $maxPoint :0;
                        }

                        $contribution->score  = $points;

                    }
                    $contribution->update();

                    $p->proposal_state = Proposal::PROPOSAL_STATE_SUCCEEDED;
                    $p->is_executed    = Proposal::PROPOSAL_EXECUTED;
                    $p->update();
                }
            }
            elseif ($api_response->state == Proposal::PROPOSAL_STATE_DEFEATED) {
                $log = new Log();
                $log->type      = 'Proposal';
                $log->log       = serialize($api_response->error);
                $log->action    = 'defeated';
                $log->type_id   = $prop['id'];
                $log->insert();

                unset($prop['contract_name']);
                $p = new Proposal();
                $p->load($prop);
                $p->proposal_state  = Proposal::PROPOSAL_STATE_DEFEATED;
                $p->is_executed     = Proposal::PROPOSAL_EXECUTE_DEFEATED;
                $p->update();
            }

        }
    }
}
?>