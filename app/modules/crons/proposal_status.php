<?php
use lighthouse\Api;
use lighthouse\Log;
use lighthouse\Proposal;


if(app_site == 'app') {

    $props = Proposal::find("SELECT p.*,c.contract_name FROM proposals p LEFT JOIN communities c ON p.comunity_id=c.id WHERE p.is_delete=0 AND p.is_executed=0 LIMIT 1");
    foreach ($props as $prop){
        $api_response = API::getSolanaProposal(constant(strtoupper(SOLANA) . "_API"), $prop['contract_name'], $prop['proposal_id']);

        if(isset($api_response->error)) {
            var_dump("ddd");
            $log = new Log();
            $log->type      = 'Proposal';
            $log->log       = serialize($api_response->error);
            $log->action    = 'read-failed';
            $log->type_id   = $prop['id'];
            $log->insert();

            unset($prop['contract_name']);
            $p = new Proposal();
            $p->load($prop);

            if($p->check == 2){
                $p->proposal_state  = Proposal::PROPOSAL_STATE_DEFEATED;
                $p->is_executed     = Proposal::PROPOSAL_EXECUTE_DEFEATED;
            }

            $p->check += 1;
            $p->update();
        }
        else
        {
            var_dump("aaa");
            if($api_response->state == Proposal::PROPOSAL_STATE_DEFEATED) {
                var_dump("bbb");
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