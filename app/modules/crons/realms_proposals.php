<?php
use lighthouse\Community;
use lighthouse\Api;
use lighthouse\RealmsProposal;
use lighthouse\RealmsVote;
use lighthouse\Contribution;
use lighthouse\Log;
use lighthouse\Approval;

if(app_site == 'app') {
    $p = isset($_GET['p'])?$_GET['p']:0;
    $skip = 500;
    $start = $p * 500;
    //$realms_proposals = RealmsProposal::find("SELECT * FROM realms_proposals",true);
    $realms_votes     = RealmsVote::find("SELECT rp.r_name,rv.* FROM realms_proposals rp LEFT JOIN realms_votes rv ON rp.r_pub_key=rv.proposal_key limit $start,500",true);
    $vote_approvals   = array();
    $con_id           = null;
exit();
/*    foreach ($realms_proposals as $proposal){
        $contribusion = new Contribution();
        $contribusion->comunity_id      = $proposal->comunity_id;
        $contribusion->contribution_reason = $proposal->r_name;
        $contribusion->wallet_to        = $proposal->c_by;
        $contribusion->tags          = 'SPL Governance';
        $contribusion->c_at          = $proposal->c_at;
        $contribusion->form_id       = 1;
        //$contribusion->max_point   = ;
        $contribusion->scoring       = 0;
        $contribusion->approval_type = 1;
        $contribusion->comunity_id   = 1;
        //$contribusion->form_data = json_encode($post);
        $contribusion->status        = 1;
        $contribusion->realms_id     = $proposal->id;
        $contribusion->is_realms     = 1;
        $contribusion->realms_status = $proposal->state;
        $con_id = $contribusion->insert();
    }*/

    foreach ($realms_votes as $vote){

        $contribusion = new Contribution();
        $contribusion->comunity_id          = $vote->comunity_id;
        $contribusion->contribution_reason  = $vote->r_name;
        $contribusion->wallet_to     = $vote->v_member_key;
        $contribusion->tags          = 'SPL Governance';
        $contribusion->c_at          = $vote->proposal_c_at;
        $contribusion->form_id       = 1;
        //$contribusion->max_point   = ;
        $contribusion->scoring       = 0;
        $contribusion->approval_type = 1;
        $contribusion->comunity_id   = 1;
        //$contribusion->form_data = json_encode($post);
        $contribusion->status        = 1;
        $contribusion->realms_id     = $vote->id;
        $contribusion->is_realms     = 2;
        $con_id = $contribusion->insert();
    }


}

?>