<?php
use lighthouse\Steward;
use lighthouse\Community;
use lighthouse\Api;
use lighthouse\Log;

exit();
if(app_site == 'app') {
    $stewards = Steward::find("SELECT * FROM stewards WHERE proposal_passed=0 AND proposal_adr <> '' LIMIT 1");
    foreach ($stewards as $steward) {
        $com_id = $steward['comunity_id'];
        $com    = Community::get($com_id);

        if($com->blockchain == SOLANA) {
            $api_response = api::getSolanaRealmsStewards(constant(strtoupper(SOLANA) . "_REALMS_API"),$com->realm_pk);

            if (isset($api_response->error)) {
                $log = new Log();
                $log->type = 'Stewards';
                $log->log = serialize($api_response->error);
                $log->action = 'realms-update-failed';
                $log->insert();
            }
            else {
                $comStewards = $com->getAllStewards();
                foreach ($api_response->stewards as $index => $adr){
                    if(isset($comStewards[$adr]) && $comStewards[$adr]['id'] != 0) {
                        $stew = Steward::get($comStewards[$adr]['id']);
                        $stew->proposal_passed = 1;
                        $stew->update();

                        $log = new Log();
                        $log->type = 'Steward';
                        $log->type_id = $stew->id;
                        $log->action = 'realms-update-passed';
                        $log->insert();
                    }
                }
            }
        }
    }
}

?>