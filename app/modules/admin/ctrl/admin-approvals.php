<?php
use lighthouse\Auth;
use lighthouse\Contribution;
use lighthouse\Community;
use lighthouse\Approval;
use lighthouse\Log;
use lighthouse\Api;
use lighthouse\Vote;
use lighthouse\Form;
use lighthouse\Proposal;
class controller extends Ctrl {
    function init() {
        $is_admin       = false;
        $sel_wallet_adr = null;
        $community      = Community::getByDomain(app_site);

        $login = Auth::attemptLogin();
        if($login != false) {
            $sel_wallet_adr = $login;
            $is_admin       = $community->isAdmin($sel_wallet_adr);
        }
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            switch (__ROUTER_PATH){

                case '/contribution-status':

                    if($this->getParam('con_id'))
                        $con_id = $this->getParam('con_id');
                    else {
                        echo json_encode(array('success' => false, 'msg' => 'Something went wrong'));
                        exit();
                    }

                    $contribution = Contribution::get($con_id);
                    $action       = '';
                    $app_status   = 1;
                    $approve      = true;
                    $vote         = 'YES';

                    if($this->hasParam('status')) {
                        $api_response = false;

                        if($this->getParam('status') == Contribution::CONTRIBUTION_STATUS_DENIED){
                            $contribution->refusal += 1;
                            $app_status = 0;
                            $action     = 'rejected';
                            $approve    = false;
                            $vote       = 'NO';
                        }
                        else
                        {
                            $contribution->approvals += 1;
                            $action  = 'approved';
                        }

                        $update  = false;
                        $form    = Form::get($contribution->form_id);
                        $post    = $_POST;
                        unset($post['con_id']);
                        unset($post['status']);

                        if($this->hasParam('approval_id') && strlen($this->getParam('approval_id')) > 0){
                            unset($post['approval_id']);
                            $update      = true;
                            $action      = 'approved-update';
                            $approval_id = $this->getParam('approval_id');
                            $approval    = Approval::get($approval_id);
                            if($approval->approval_status == 1)
                                $contribution->approvals -= 1;
                            else
                                $contribution->refusal -= 1;

                            $approval->approval        = json_encode($post);
                            $approval->approval_status = $app_status;
                            $approval->update();
                        }
                        else {

                            if ($community->blockchain == SOLANA && $contribution->proposal_id == 0) {

                                if($contribution->approval_type == Form::APPROVAL_TYPE_BINARY) {
                                    $api_response = Api::createLogProposal(
                                        constant(strtoupper(SOLANA) . "_API"),
                                        $community->contract_name,
                                        $contribution->wallet_to,
                                        $contribution->max_point,
                                        $contribution->contribution_reason,
                                        $contribution->tags,
                                        \lighthouse\Proposal::PROPOSAL_TYPE_BINARY,
                                        $sel_wallet_adr
                                    );
                                }
                                else {
                                    $api_response = Api::createLogProposal(
                                        constant(strtoupper(SOLANA) . "_API"),
                                        $community->contract_name,
                                        $contribution->wallet_to,
                                        $contribution->max_point,
                                        $contribution->contribution_reason,
                                        $contribution->tags,
                                        \lighthouse\Proposal::PROPOSAL_TYPE_SUBJECTIVE,
                                        $sel_wallet_adr,
                                        array_keys($post)
                                    );
                                }

                                if (isset($api_response->error)) {
                                    $log = new Log();
                                    $log->type   = 'Log-Proposal';
                                    $log->log    = serialize($api_response->error);
                                    $log->action = 'create-failed';
                                    $log->c_by   = $sel_wallet_adr;
                                    $log->insert();

                                    echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to add the proposal, please retry again.'));
                                    exit();
                                } else {
                                    $proposal = new Proposal();
                                    $proposal->proposal_adr  = $api_response->proposalAddress;
                                    $proposal->proposal_id   = $api_response->proposalId;
                                    $proposal->proposal_type = 'ADD';
                                    $proposal->object_name   = Vote::V_TYPE_LOG_PROPOSAL;
                                    $proposal->object_id     = $contribution->id;
                                    $proposal->wallet_adr    = $sel_wallet_adr;
                                    $proposal->comunity_id   = $community->id;
                                    $proposal->proposal_data = json_encode(array('maxPoint',$contribution->max_point));
                                    $pid = $proposal->insert();

                                    $contribution->proposal_id = $pid;
                                }
                            }

                            $approval = new Approval();
                            $approval->approval_by      = $sel_wallet_adr;
                            $approval->contribution_id  = $contribution->id;
                            $approval->approval         = json_encode($post);
                            $approval->approval_type    = $contribution->approval_type;
                            $approval->comunity_id      = $contribution->comunity_id;
                            $approval->approval_status  = $app_status;
                            $approval_id = $approval->insert();
                        }

                        $contribution->update();

                        $log = new Log();
                        $log->type      = 'Contribution';
                        $log->type_id   = $contribution->id;
                        $log->action    = $action;
                        $log->c_by      = $sel_wallet_adr;
                        $log->insert();

                        echo json_encode(array('success' => true,
                                'update'  => $update,
                                'c_id'    => $contribution->id,
                                'p_id' => $contribution->proposal_id,
                                'api_response' => $api_response,
                                'blockchain' => $community->blockchain,
                                'approval_id' => $approval_id,
                                'message' => 'Success! Your attestation has been updated.')
                        );
                        exit();

                    }
                    else
                        echo json_encode(array('success' => false,'message' => 'Error! Something went wrong.'));

                    break;

                case '/contribution-details':

                    $con_id        = $this->getParam('con_id');
                    $contribution  = Contribution::get($con_id,true);
                    $form          = Form::get($contribution->form_id);
                    $elements      = $form->getElements();
                    $wallet_to     = $contribution->wallet_to;
                    $stewards      = $community->getStewards();
                    $approvals     = Approval::getApprovals($contribution->id);
                    $com_id        = $community->id;
                    $contributions = Contribution::find("SELECT contribution_reason,c_at FROM contributions c LEFT JOIN proposals p ON where is_realms=0 AND comunity_id='$com_id' AND wallet_to='$wallet_to' order by c_at");

                    if($contribution->status == Contribution::CONTRIBUTION_STATUS_ATTESTED)
                        $user_arrovals = Approval::getUserApprovals($contribution->approval_type,$contribution->id);
                    else
                        $user_arrovals = Approval::getUserApprovals($contribution->approval_type,$contribution->id,$sel_wallet_adr);

                    $user_appproval_ids = $user_arrovals['ids'];
                    $user_arrovals      = $user_arrovals['approvals'];

                    $view_transaction_link = '';
                    if($community->blockchain == SOLANA)
                        $view_transaction_link = SOLANA_VIEW_LINK.'tx/'.$contribution->txHash;
                    elseif ($community->blockchain == OPTIMISM)
                        $view_transaction_link = OPTIMISM_VIEW_LINK.'tx/'.$contribution->txHash;
                    else
                        $view_transaction_link = GNOSIS_CHAIN_VIEW_LINK.'tx/'.$contribution->txHash;

                    include __DIR__ . '/../tpl/partial/contribution_details.php';
                    $html = ob_get_clean();
                    echo json_encode(array('success' => true,'html'=>$html));

                    break;

                case '/execute-log-proposal':

                    $proposal = $this->hasParam('pid') ? Proposal::get($this->getParam('pid')) : null;

                    if($proposal instanceof Proposal){
                        $contribution = Contribution::get($proposal->object_id);
                        $api_response =  API::executePointProposal(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $proposal->proposal_id);

                        if (!isset($api_response->error)) {
                            $proposal->txnHash          = $api_response->txHash;
                            $proposal->proposal_passed  = 1;
                            $proposal->is_executed      = 1;
                            $proposal->update();

                            $contribution->status = 1;
                            $contribution->txHash = $api_response->txHash;
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

                            echo json_encode(array('success' => true,'c_id' => $contribution->id,'update' => false));
                        }
                        else
                            echo json_encode(array('success' => false, 'msg' => 'something went wrong please try again'));
                    }

                    break;

                case '/vote-log-proposal':

                    try {

                        $approval = $this->hasParam('aid') ? Approval::get($this->getParam('aid')) : null;
                        $proposal = $this->hasParam('pid') ? Proposal::get($this->getParam('pid')) : null;

                        if ($proposal instanceof Proposal && $approval instanceof Approval) {
                            $pid  = $proposal->id;
                            $vote = ($approval->approval_status == 1)?'YES':'NO';;
                            if($approval->approval_type == Form::APPROVAL_TYPE_SUBJECTIVE) {
                                $data         = array();
                                $vote_data    = json_decode($approval->approval);
                                foreach ($vote_data as $k => $v)
                                    array_push($data,intval($v));

                                $api_response = api::solanaProposalVote(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $sel_wallet_adr, $proposal->proposal_id, $data,Proposal::PROPOSAL_TYPE_SUBJECTIVE);
                            }
                            else
                                $api_response = api::solanaProposalVote(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $sel_wallet_adr, $proposal->proposal_id, $vote);

                            if (isset($api_response->error)) {
                                $log = new Log();
                                $log->type   = $proposal->object_name;
                                $log->log    = serialize($api_response->error);
                                $log->action = 'vote-failed';
                                $log->c_by   = $sel_wallet_adr;
                                $log->insert();

                                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to submit the vote, please retry again.'));
                                exit();
                            }
                            else {
                                $v = new Vote();
                                $v->wallet_adr   = $sel_wallet_adr;
                                $v->comunity_id  = $community->id;
                                $v->vote         = $vote;
                                $v->proposal_id  = $proposal->id;
                                $v->insert();

                                if($vote =='YES')
                                    $proposal->proposal_yes_count = (int)$proposal->proposal_yes_count + 1;
                                else
                                    $proposal->proposal_no_count = (int)$proposal->proposal_no_count + 1;

                                $proposal->update();
                            }

                            echo json_encode(array('success' => true,'api_response' => $api_response,'pid' => $proposal->id,'msg' => 'Attesting contribution...'));
                        }
                    } catch (Exception $e) {
                        $msg = explode(':', $e->getMessage());
                        $element = 'error-msg';
                        if (isset($msg[1])) {
                            $element = $msg[0];
                            $msg = $msg[1];
                        }
                        echo json_encode(array('success' => false, 'msg' => $msg, 'element' => $element));
                    }

                    break;
            }
        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            $community_id  = $community->id;
            $reviewed_ids  = array();
            $reviewed_data = Contribution::find("SELECT a.contribution_id FROM approvals a LEFT JOIN contributions c ON a.contribution_id = c.id WHERE c.comunity_id='$community_id' AND c.status=0 AND a.approval_by='$sel_wallet_adr'");
            if($reviewed_data->num_rows > 0) {
                foreach ($reviewed_data as $review) {
                    array_push($reviewed_ids,$review['contribution_id']);
                }

                $id_sql = '('.implode(",",$reviewed_ids).')';
                $claim_all = Contribution::find("SELECT distinct(c.id) as c_id,c.c_at,c.status,f.form_title,c.contribution_reason,f.tags,c.form_data,c.form_id,c.proposal_id,p.proposal_state,p.is_executed,c.wallet_to FROM contributions c LEFT JOIN forms f ON c.form_id=f.id LEFT JOIN proposals p ON c.proposal_id=p.id WHERE  c.is_realms=0 AND c.status = 0 AND f.id <> 2 AND c.comunity_id='$community_id' AND c.id NOT IN ".$id_sql);
            }
            else
                $claim_all = Contribution::find("SELECT distinct(c.id) as c_id,c.c_at,c.status,f.form_title,c.contribution_reason,f.tags,c.form_data,c.form_id,c.proposal_id,p.proposal_state,p.is_executed,c.wallet_to  FROM contributions c LEFT JOIN forms f ON c.form_id=f.id LEFT JOIN proposals p ON c.proposal_id=p.id WHERE c.is_realms=0 AND c.status = 0 AND f.id <> 2 AND c.comunity_id='$community_id'");

            $claims = array();
            if($claim_all != false) {
                foreach ($claim_all as $claim) {
                    array_push($claims, $claim);
                }
            }

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'ticker' => $community->ticker,
                'blockchain' => $site['blockchain'],
                'sel_wallet_adr' => $sel_wallet_adr,
                'is_admin' => $is_admin,
                'claims' => $claims,
                'com_id' => $community->id,
                'approval_days' => $community->approval_days,
                'logo_url' => $community->getLogoImage(),
                'user' => \lighthouse\User::isExistUser($sel_wallet_adr,$community->id),
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-approvals.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>