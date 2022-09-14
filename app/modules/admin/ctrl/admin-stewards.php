<?php
use lighthouse\Auth;
use lighthouse\Steward;
use lighthouse\Community;
use lighthouse\Log;
use lighthouse\Api;
use lighthouse\Vote;
class controller extends Ctrl {
    function init() {
        $is_admin = false;
        $sel_wallet_adr = null;
        $community = Community::getByDomain(app_site);
        $community_id = $community->id;

        $login = Auth::attemptLogin();
        if($login != false) {
            $sel_wallet_adr = $login;
            $is_admin = $community->isAdmin($sel_wallet_adr);
        }
        else
        {
            /*$sel_wallet_adr = 'HSnWTzTqmzjw7GwggEuJgnXmPRbFwftSSv6a7GUAYXWj';
            $is_admin = $community->isAdmin($sel_wallet_adr);*/
            header("Location: " . app_url.'admin');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            switch (__ROUTER_PATH) {

                case '/add-stewards':

                    try {
                        $display_name = $wallet_address = '';

                        if ($this->hasParam('nickname') && strlen($this->getParam('nickname')) > 0)
                            $display_name = $this->getParam('nickname');
                        else
                            throw new Exception("nickname:Not a valid name");

                        if ($this->hasParam('wallet_address') && strlen($this->getParam('wallet_address')) > 0)
                            $wallet_address = $this->getParam('wallet_address');
                        else
                            throw new Exception("display_name:Please connect the wallet");

                        $steward      = new Steward();
                        $api_response = null;

                        if($community->blockchain == SOLANA) {

                            $api_response = api::addSolanaAdminProposal(constant(strtoupper(SOLANA) . "_API"),$community->contract_name,$wallet_address,$sel_wallet_adr);

                            if (isset($api_response->error)) {
                                $log = new Log();
                                $log->type = 'Stewards';
                                $log->log = serialize($api_response->error);
                                $log->action = 'create-failed';
                                $log->c_by = $wallet_address;
                                $log->insert();

                                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to add amin proposal, please retry again.'));
                                exit();
                            }
                            else {

                                $steward->comunity_id   = $community->id;
                                $steward->wallet_adr    = $wallet_address;
                                $steward->display_name  = $display_name;
                                $steward->praposal_adr  = $api_response->proposalAddress;
                                $steward->proposal_id   = $api_response->proposalId;
                                $id = $steward->insert();

                                include __DIR__ . '/../tpl/partial/realms_steward_line.php';
                                $html = ob_get_clean();
                            }

                        }
                        else {
                            $steward->praposal_passed = 1;
                            $steward->comunity_id = $community->id;
                            $steward->wallet_adr = $wallet_address;
                            $steward->display_name = $display_name;
                            $id = $steward->insert();

                            $html = '<div class="mb-8">
                                    <div class="stew-'.$id.' fw-medium text-muted"><span>'.$display_name.'</span>
                                        <a class="fw-medium text-decoration-none text-primary ms-3 edit_steward" data-sadr="'.$wallet_address.'" data-sid="'.$id.'" data-sname="'.$display_name.'" data-bs-toggle="modal" data-bs-target="#editSteward" href="#">Edit > </a>
                                    </div>
                                    <div class="stew-'.$id.' d-flex align-items-center">
                                        <div class="fs-3 fw-semibold me-6">'.$wallet_address.'</div>                                                                              
                                    </div>
                                </div>';
                        }

                        $log = new Log();
                        $log->type = 'Steward';
                        $log->type_id = $id;
                        $log->action = 'create';
                        $log->c_by = $wallet_address;
                        $log->insert();

                        $c = $community->getStewards(true);
                        $percentage = '<div class="fs-1"><?php echo $__page->'.$community->approval_count.'</div><div class="fs-2">/'.$c.'</div>';

                        echo json_encode(array('success' => true,'api_response' => $api_response,'blockchain' => $community->blockchain,'html' => $html,'percentage' => $percentage,'max' => $c));

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

                case '/edit-steward':

                    try {

                        $e_steward_id = $display_name = $e_steward_adr = '';

                        if ($this->hasParam('e_display_name') && strlen($this->getParam('e_display_name')) > 0)
                            $display_name = $this->getParam('e_display_name');
                        else
                            throw new Exception("e_display_name:Not a valid name");

                        if ($this->hasParam('e_steward_id') && strlen($this->getParam('e_steward_id')) > 0)
                            $e_steward_id = $this->getParam('e_steward_id');
                        else
                            throw new Exception("Please connect the wallet");

                        if($e_steward_id != 0) {
                            $steward = Steward::get($e_steward_id);
                            $steward->display_name = $display_name;
                            $steward->update();
                            $e_steward_adr = $steward->wallet_adr;
                        }
                        else {
                            $community->display_name = $display_name;
                            $community->update();
                            $e_steward_adr = $community->wallet_adr;
                        }

                        echo json_encode(array('success' => true, 'e_steward_id' => $e_steward_id,'e_display_name' => $display_name,'e_steward_adr' => $e_steward_adr));

                    } catch (Exception $e) {
                        $msg = explode(':', $e->getMessage());
                        $element = 'error-msg';
                        if (isset($msg[1])) {
                            $element = $msg[0];
                            $msg = $msg[1];
                        }
                        echo json_encode(array('success' => false, 'msg' => $msg,'element' => $element));
                    }

                    break;

                case '/delete-stewards':

                    if($this->hasParam('id') && $this->hasParam('adr')) {
                        $id  = $this->getParam('id');
                        $adr = $this->getParam('adr');
                        if(Steward::deleteSteward($id,$adr,$community_id)) {
                            $c = $community->getStewards(true);
                            $percentage = '<div class="fs-1"><?php echo $__page->'.$community->approval_count.'</div><div class="fs-2">/'.$c.'</div>';
                            echo json_encode(array('success' => true, 'stew_id' => $id,'percentage' => $percentage,'max' => $c));
                        }
                        else
                            echo json_encode(array('success' => false));
                    }
                    else
                        echo json_encode(array('success' => false));
                    exit();
                    break;

                case '/steward-percentage':
                    if($this->hasParam('range') && $this->getParam('range') > 0) {
                        $community->approval_count = $this->getParam('range');
                        $community->update();
                        $c = $community->getStewards(true);
                        $percentage = '<div class="fs-1"><?php echo $__page->'.$community->approval_count.'</div><div class="fs-2">/'.$c.'</div>';
                        echo json_encode(array('success' => true, 'percentage' => $percentage,'max' => $c));
                    }
                    else
                        echo json_encode(array('success' => false));

                    break;

                case  '/vote-stewards':

                    try {
                        $vote = $this->hasParam('vote') ? $this->getParam('vote') : null;
                        $steward = $this->hasParam('sid') ? Steward::get($this->getParam('sid')) : null;

                        if ($steward instanceof Steward) {
                            $vote = ($vote == 'YES') ? 'YES' : 'NO';
                            $api_response = api::solanaAdminProposalVote(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $sel_wallet_adr, $steward->proposal_id, $vote);

                            if (isset($api_response->error)) {
                                $log = new Log();
                                $log->type = 'Stewards';
                                $log->log = serialize($api_response->error);
                                $log->action = 'vote-failed';
                                $log->c_by = $sel_wallet_adr;
                                $log->insert();

                                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to submit the vote, please retry again.'));
                                exit();
                            }
                            else {
                                $v = new Vote();
                                $v->wallet_adr = $sel_wallet_adr;
                                $v->type = Vote::V_TYPE_ADMIN;
                                $v->type_id = $steward->id;
                                $v->proposal_adr = $steward->praposal_adr;
                                $v->proposal_id  = $steward->proposal_id;
                                $v->comunity_id = $community->id;
                                $v->vote = $vote;
                                $v->insert();

                                $steward->proposal_yes = (int)$steward->proposal_yes + 1;
                                $steward->update();
                            }

                            echo json_encode(array('success' => true,'api_response' => $api_response,'sid' => $steward->id));
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

                case '/get-proposal':

                    $steward = $this->hasParam('sid') ? Steward::get($this->getParam('sid')) : null;

                    if ($steward instanceof Steward) {
                        $api_response =  API::getSolanaProposal(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $steward->proposal_id);
                        $response     = array();

                        if (!isset($api_response->error)) {
                            $response['create_at'] = $api_response->createdAt;
                            $response['state']     = $api_response->state;
                            $response['voting_closes_at'] = $api_response->votingClosesAt;
                            $response['min_votes_to_succeed'] = $api_response->minVotesToSucceed;

                            echo json_encode(array('success' => true,'response' => $response,'sid' => $steward->id));
                        }
                        else
                            echo json_encode(array('success' => false, 'msg' => 'something went wrong please try again'));

                    }

                    break;

                case '/execute-admin-proposal':

                    $steward = $this->hasParam('sid') ? Steward::get($this->getParam('sid')) : null;

                    if ($steward instanceof Steward) {
                        $api_response =  API::executeAdminProposal(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $steward->proposal_id,$steward->wallet_adr);

                        if (!isset($api_response->error)) {
                            $steward->txnHash = $api_response->txnHash;
                            $steward->praposal_passed = 1;
                            $steward->update();

                            echo json_encode(array('success' => true,'sid' => $steward->id));
                        }
                        else
                            echo json_encode(array('success' => false, 'msg' => 'something went wrong please try again'));
                    }

                    break;
            }

            exit();
        }
        else {

            $site           = Auth::getSite();
            $approval_count = 0;
            $maxVotingTime  = $community->max_voting_time;
            $user_votes     = Vote::getUserVotes($sel_wallet_adr,$community->id);
            
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            $allStewards  = $community->getAllStewards();
            $stewardCount = 0;
            foreach ($allStewards as $steward){
                if($steward['praposal_passed'] == 1){
                    $stewardCount++;
                }
            }

/*            if($community->blockchain == SOLANA) {
                $api_response = api::getRealmInfo(constant(strtoupper(SOLANA) . "_REALMS_API"), $community->governance_pk);
                if (!isset($api_response->error)) {
                    $maxVotingTime    = $api_response->maxVotingTime;
                    $quorumPercentage = $api_response->quorumPercentage;
                    $approval_count   = ($quorumPercentage/100) * $stewardCount;
                    $approval_count   = round($approval_count,0,PHP_ROUND_HALF_UP);
                    $community->approval_count  = $approval_count;
                    $community->max_voting_time = $maxVotingTime;
                    $community->update();

                }
            }*/

            $approval_count = $community->approval_count;

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'community' => $community,
                'is_admin' => $is_admin,
                'blockchain' => $community->blockchain,
                'stewards' => $allStewards,
                'stewardCount' => $stewardCount,
                'approval_count' => $approval_count,
                'maxVotingTime' => $maxVotingTime,
                'user_votes' => $user_votes,
                'logo_url' => $community->getLogoImage(),
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-stewards.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>