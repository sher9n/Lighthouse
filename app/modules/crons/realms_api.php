<?php
use lighthouse\Community;
use lighthouse\Api;
use lighthouse\RealmsProposal;
use lighthouse\RealmsVote;

if(app_site == 'app') {

    $communities = Community::find("SELECT id,realm_id,realm_enddate FROM communities where is_delete = 0 AND realm_id <>''",true);

    foreach ($communities as $com) {

        if(strlen($com->realm_id) > 0) {
            $realmId = $com->realm_id;
            $response = Api::realms_update($realmId);

            //if($response->success == true){

                $time = time();

                if ($com->realm_enddate == '0000-00-00 00:00:00' || is_null($com->realm_enddate)) {
                    $data = Api::realms_get_info($realmId);
                }
                else{
                    $start = strtotime($com->realm_enddate);
                    $data = Api::realms_get_info($realmId,$start,$time);
                }

                $com->realm_enddate = date('Y-m-d H:i:s', $time);
                $com->update();

                if(!is_null($data->proposals)) {
                    foreach ($data->proposals as $index => $proposal) {

                        $rp = new RealmsProposal();
                        $rp->r_pub_key = $proposal->pubKey;
                        $rp->r_name = $proposal->name;
                        $rp->description = $proposal->descriptionLink;
                        $rp->c_by = $proposal->createdBy;
                        $rp->c_at = date('Y-m-d H:i:s', $proposal->createdAt);
                        $rp->state = $proposal->state;
                        $rp->governance_key = $proposal->governancePubKey;
                        $rp->realm_key = $proposal->realmPubKey;
                        $rp->comunity_id = $com->id;
                        $rp->insert();
                    }
                }

                if(!is_null($data->voteRecords)) {
                    foreach ($data->voteRecords as $index => $vote) {

                        $rv = new RealmsVote();
                        $rv->v_id = $vote->id;
                        $rv->v_member_key = $vote->memberPubKey;
                        $rv->v_realm_key = $vote->realmPubKey;
                        $rv->proposal_key = $vote->proposalPubkey;
                        $rv->proposal_c_at = date('Y-m-d H:i:s', $vote->proposalCreatedAt);
                        $rv->vote = $vote->vote;
                        $rv->vote_weight = $vote->voteWeight;
                        $rv->version = $vote->version;
                        $rv->comunity_id = $com->id;
                        $rv->insert();
                    }
                }
           // }
       }
    }

}

?>