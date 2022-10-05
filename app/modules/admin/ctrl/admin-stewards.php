<?php
use lighthouse\Auth;
use lighthouse\Steward;
use lighthouse\Community;
use lighthouse\Log;
use lighthouse\Api;
use lighthouse\Proposal;
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
                                $log->type   = 'Stewards';
                                $log->log    = serialize($api_response->error);
                                $log->c_by   = $wallet_address;
                                $log->action = 'create-failed';
                                $log->insert();

                                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to add amin proposal, please retry again.'));
                                exit();
                            }
                            else {

                                $steward->comunity_id   = $community->id;
                                $steward->wallet_adr    = $wallet_address;
                                $steward->display_name  = $display_name;
                                $sid = $steward->insert();

                                $proposal = new Proposal();
                                $proposal->proposal_adr  = $api_response->proposalAddress;
                                $proposal->proposal_id   = $api_response->proposalId;
                                $proposal->proposal_type = 'ADD';
                                $proposal->object_name   = 'admin';
                                $proposal->object_id     = $sid;
                                $proposal->wallet_adr    = $sel_wallet_adr;
                                $proposal->comunity_id   = $community->id;
                                $pid = $proposal->insert();

                                $user_votes     = array();
                                $stewardCount   = $community->getStewards(true);
                                $approval_count = $community->approval_count;
                                $html = '<div class="mb-8"><div class="prop-'.$pid.' d-flex align-items-center justify-content-between">';
                                include __DIR__ . '/../tpl/partial/admin_proposal_line.php';
                                $html.= ob_get_clean();
                                $html.= '</div></div>';
                            }

                        }
                        else {
                            $steward->active = 1;
                            $steward->comunity_id  = $community->id;
                            $steward->wallet_adr   = $wallet_address;
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
                        $log->type      = 'Steward';
                        $log->type_id   = $id;
                        $log->action    = 'create';
                        $log->c_by      = $wallet_address;
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
                        $sid            = $this->getParam('id');
                        $wallet_address = $this->getParam('adr');
                        $steward        = Steward::get($sid);
                        $remove_stewards= $community->getAdminProposals('REMOVE');

                        if(count($remove_stewards) > 0){
                            echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to submit a Remove Admin proposal, Already have a pending proposal.'));
                            exit();
                        }

                        if ($community->blockchain == SOLANA ) {

                            $api_response = api::addSolanaAdminProposal(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $wallet_address, $sel_wallet_adr, 'REMOVE');

                            if (isset($api_response->error)) {
                                $log = new Log();
                                $log->type   = 'Stewards';
                                $log->log    = serialize($api_response->error);
                                $log->action = 'remove-failed';
                                $log->c_by   = $wallet_address;
                                $log->insert();

                                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to add amin proposal, please retry again.'));
                                exit();
                            }
                            else {

                                $proposal                 = new Proposal();
                                $proposal->proposal_adr   = $api_response->proposalAddress;
                                $proposal->proposal_id    = $api_response->proposalId;
                                $proposal->proposal_type  = 'REMOVE';
                                $proposal->object_name    = 'admin';
                                $proposal->object_id      = $steward->id;
                                $proposal->wallet_adr     = $sel_wallet_adr;
                                $proposal->comunity_id    = $community->id;
                                $pid = $proposal->insert();

                                $user_votes     = array();
                                $stewardCount   = $community->getStewards(true);
                                $approval_count = $community->approval_count;
                                $html = '<div class="mb-8"><div class="prop-'.$pid.' d-flex align-items-center justify-content-between">';
                                include __DIR__ . '/../tpl/partial/admin_proposal_line.php';
                                $html.= ob_get_clean();
                                $html.= '</div></div>';

                                echo json_encode(array('success' => true, 'stew_id' => $steward->id, 'api_response' => $api_response, 'blockchain' => $community->blockchain, 'html' => $html));
                                exit();
                            }
                        }
                    }
                    echo json_encode(array('success' => false));
                    break;

                case '/steward-percentage':
                    if($this->hasParam('range') && $this->getParam('range') > 0) {
                        $approval_count = $this->getParam('range');

                        if ($community->blockchain != SOLANA) {
                            $community->approval_count = $approval_count;
                            $community->update();
                            $c = $community->getStewards(true);
                            $percentage = '<div class="fs-1"><?php echo $__page->' . $community->approval_count . '</div><div class="fs-2">/' . $c . '</div>';
                            echo json_encode(array('success' => true, 'percentage' => $percentage, 'max' => $c,'blockchain' => $community->blockchain));
                        }
                        else {

                            if(count($community->getQuorumProposals()) > 0){
                                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to add Quorum proposal. There is a pending proposal for quorum.'));
                                exit();
                            }

                            $stewardCount  = $community->getStewards(true);
                            $percentage    =  round((($approval_count/$stewardCount) * 100),0,PHP_ROUND_HALF_DOWN);
                            $api_response  = api::addSolanaQuorumProposal(constant(strtoupper(SOLANA) . "_API"),$community->contract_name,$sel_wallet_adr,$percentage);

                            if (isset($api_response->error)) {
                                $log = new Log();
                                $log->type   = 'Quorum';
                                $log->log    = serialize($api_response->error);
                                $log->action = 'create-failed';
                                $log->c_by   = $sel_wallet_adr;
                                $log->insert();

                                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to add Quorum proposal, please retry again.'));
                                exit();
                            }
                            else {

                                $proposal = new Proposal();
                                $proposal->proposal_adr  = $api_response->proposalAddress;
                                $proposal->proposal_id   = $api_response->proposalId;
                                $proposal->proposal_type = 'ADD';
                                $proposal->object_name   = Vote::V_TYPE_QUORUM;
                                $proposal->wallet_adr    = $sel_wallet_adr;
                                $proposal->comunity_id   = $community->id;
                                $proposal->proposal_data = json_encode(array('c'=>$approval_count,'p' => $percentage));
                                $pid = $proposal->insert();

                                $user_votes     = array();
                                $approval_count = $community->approval_count;
                                $html  = '<div class="prop-<?php echo $qid; ?>  d-flex align-items-center justify-content-between mt-4">';
                                $qdata = json_decode($proposal->proposal_data);
                                include __DIR__ . '/../tpl/partial/quorum_proposal_line.php';
                                $html .= ob_get_clean();
                                $html .= '</div>';
                                echo json_encode(array('success' => true,'api_response' => $api_response,'blockchain' => $community->blockchain,'html' => $html));
                            }
                        }
                    }
                    else
                        echo json_encode(array('success' => false));

                    break;

                case  '/vote-proposal':

                    try {

                        $vote = $this->hasParam('vote') ? $this->getParam('vote') : null;
                        $proposal = $this->hasParam('pid') ? Proposal::get($this->getParam('pid')) : null;

                        if ($proposal instanceof Proposal) {
                            $pid  = $proposal->id;
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

                            $user_votes     = Vote::getUserVotes($sel_wallet_adr,$community->id);
                            $stewardCount   = $community->getStewards(true);
                            $approval_count = $community->approval_count;
                            $qdata          = json_decode($proposal->proposal_data);

                            if($proposal->object_name == Vote::V_TYPE_QUORUM) {
                                $qid  = $pid;
                                include __DIR__ . '/../tpl/partial/quorum_proposal_line.php';
                                $html = ob_get_clean();
                            }
                            else {
                                $steward = Steward::get($proposal->object_id);
                                include __DIR__ . '/../tpl/partial/admin_proposal_line.php';
                                $html    = ob_get_clean();
                            }

                            echo json_encode(array('success' => true,'api_response' => $api_response,'pid' => $proposal->id,'html' => $html));
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

                    $proposal = $this->hasParam('pid') ? Proposal::get($this->getParam('pid')) : null;

                    if ($proposal instanceof Proposal) {
                        $api_response =  API::getSolanaProposal(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $proposal->proposal_id);
                        $response     = array();

                        if (!isset($api_response->error)) {

                            $proposal->proposal_state = $api_response->state;
                            if($api_response->state == Proposal::PROPOSAL_STATE_DEFEATED)
                                $proposal->is_executed = Proposal::PROPOSAL_EXECUTE_DEFEATED;
                            $proposal->update();

          /*                  $response['create_at']    = $api_response->createdAt;
                            $response['state']        = $api_response->state;
                            $response['voting_closes_at']     = $api_response->votingClosesAt;
                            $response['min_votes_to_succeed'] = $api_response->minVotesToSucceed;*/

                            echo json_encode(array('success' => true));
                        }
                        /*else
                            echo json_encode(array('success' => false, 'msg' => 'something went wrong please try again'));*/

                    }

                    break;

                case '/execute-admin-proposal':

                    $proposal = $this->hasParam('pid') ? Proposal::get($this->getParam('pid')) : null;

                    if ($proposal instanceof Proposal) {
                        $steward      = Steward::get($proposal->object_id);

                        if($proposal->proposal_type != 'REMOVE') {
                            $api_response = API::executeAdminProposal(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $proposal->proposal_id, $steward->wallet_adr);

                            if (!isset($api_response->error)) {
                                $proposal->txnHash = $api_response->txHash;
                                $proposal->proposal_passed = 1;
                                $proposal->is_executed = 1;
                                $proposal->update();

                                $steward->active = 1;
                                $steward->update();

                                echo json_encode(array('success' => true, 'pid' => $proposal->id));
                            }
                            else
                                echo json_encode(array('success' => false, 'msg' => 'something went wrong please try again'));
                        }
                        else {
                            $api_response = API::executeAdminProposal(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $proposal->proposal_id, $steward->wallet_adr,'REMOVE');

                            if (!isset($api_response->error)) {
                                $proposal->txnHash = $api_response->txHash;
                                $proposal->proposal_passed = 1;
                                $proposal->is_executed = 1;
                                $proposal->update();

                                $steward->active    = 0;
                                $steward->is_delete = 0;
                                $steward->update();

                                echo json_encode(array('success' => true, 'pid' => $proposal->id));
                            }
                            else
                                echo json_encode(array('success' => false, 'msg' => 'something went wrong please try again'));

                        }
                    }

                    break;

                case '/execute-quorum-proposal':

                    $proposal = $this->hasParam('pid') ? Proposal::get($this->getParam('pid')) : null;

                    if($proposal instanceof Proposal){
                        $api_response =  API::executeBasicProposal(constant(strtoupper(SOLANA) . "_API"), $community->contract_name, $proposal->proposal_id);

                        if (!isset($api_response->error)) {
                            $proposal->txnHash          = $api_response->txHash;
                            $proposal->proposal_passed  = 1;
                            $proposal->is_executed      = 1;
                            $proposal->update();

                            $qdata = json_decode($proposal->proposal_data);
                            $community->approval_count  = $qdata->c;
                            $community->update();

                            echo json_encode(array('success' => true,'pid' => $proposal->id));
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
            $adminProposals = $community->getAdminProposals();
            $quorumProposals= $community->getQuorumProposals();

            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            $allStewards  = $community->getStewards();
            $stewardCount = count($allStewards);

            if($community->blockchain == SOLANA) {
                $api_response = api::getSolanaCommunity(constant(strtoupper(SOLANA) . "_API"), $community->contract_name);
                if (!isset($api_response->error)) {
                    $maxVotingTime    = $api_response->votingDuration;
                    $quorumPercentage = $api_response->quorumPercent;
                    $approval_count   = ($quorumPercentage/100) * $stewardCount;
                    $approval_count   = round($approval_count,0,PHP_ROUND_HALF_UP);
                    $community->approval_count  = $approval_count;
                    $community->max_voting_time = $maxVotingTime;
                    $community->update();
                }
            }
            else
                $approval_count = $community->approval_count;

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'ticker' => $community->ticker,
                'community' => $community,
                'is_admin' => $is_admin,
                'blockchain' => $community->blockchain,
                'stewards' => $allStewards,
                'stewardCount' => $stewardCount,
                'approval_count' => $approval_count,
                'maxVotingTime' => $maxVotingTime,
                'user_votes' => $user_votes,
                'admin_Proposals' => $adminProposals,
                'quorumProposals' => $quorumProposals,
                'logo_url' => $community->getLogoImage(),
                'sel_wallet_adr' => $sel_wallet_adr,
                'user' => \lighthouse\User::isExistUser($sel_wallet_adr,$community->id),
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