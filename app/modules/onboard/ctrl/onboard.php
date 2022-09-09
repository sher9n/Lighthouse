<?php
use Core\Utils;
use lighthouse\Community;
use lighthouse\Log;
use lighthouse\Form;
use lighthouse\Api;
use lighthouse\Contribution;
class controller extends Ctrl {
    function init() {

        if(app_site != 'app') {
            header("Location: " . app_url);
            die();
        }

        if ($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/check-dao-domain'){
                $subdomain = '';
                if($this->hasParam('dao_name')) {
                    $subdomain = $this->getParam('dao_name');
                    $subdomain = strtolower(preg_replace("/\s+/", "-", $subdomain));

                    if (Community::isExistsCommunity($subdomain) === FALSE) {
                        echo json_encode(array('success' => true, 'sub_domain' =>$subdomain,'ticker' => strtoupper($subdomain)));
                        exit();
                    }
                }

                echo json_encode(array('success' => false, 'sub_domain' =>$subdomain ,'msg' => "This name is already taken. Please try a different name.", 'element' => 'dao_domain'));
                exit();
            }
            else {

                try {

                    $dao_name = $wallet_address = $dao_domain = $ticker = $n_t_token = '';
                    $blockchain = SOLANA;

                    if($this->hasParam('dao_name') && strlen($this->getParam('dao_name')) > 0)
                        $dao_name = $this->getParam('dao_name');
                    else
                        throw new Exception("dao_name:Not a valid dao name");

                    if($this->hasParam('blockchain') && strlen($this->getParam('blockchain')) > 0)
                        $blockchain = $this->getParam('blockchain');

                    if($this->hasParam('wallet_address') && strlen($this->getParam('wallet_address')) > 0)
                        $wallet_address = $this->getParam('wallet_address');
                    else
                        throw new Exception("dao_name:Please connect the wallet");

                    if($this->hasParam('n_t_token') && strlen($this->getParam('n_t_token')) > 0)
                        $n_t_token = $this->getParam('n_t_token');
                    else
                        throw new Exception("n_t_token:Not a valid token");

                    if($this->hasParam('dao_domain') && strlen($this->getParam('dao_domain')) > 0) {
                        $dao_domain = $this->getParam('dao_domain');
                        $dao_domain = strtolower(preg_replace("/\s+/", "-", $dao_domain));

                        if(filter_var('https://' . $dao_domain . '.lighthouse.xyz', FILTER_VALIDATE_URL) == false){
                            throw new Exception("dao_domain:Not a valid dao domain");
                            exit();
                        }

                        $domain_check = Community::isExistsCommunity($dao_domain);

                        if ($domain_check === FALSE) {
                            $ticker         = strtoupper($n_t_token);
                            $subdomain      = $dao_domain;
                            $contract_name  = $dao_domain.'-'.time();

                            if ($blockchain != SOLANA)
                                $api_response = api::addCommunityWithoutToken(constant(strtoupper($blockchain) . "_API"), $contract_name, 0.0008,$wallet_address);
                            else
                                $api_response = api::addSolanaCommunityWithRealm($contract_name,$ticker,$ticker,9,$wallet_address,50,50,604800);

                            if (isset($api_response->error)) {
                                $log = new Log();
                                $log->type   = 'Community';
                                $log->log    = serialize($api_response->error);
                                $log->action = 'create-failed';
                                $log->c_by   = $wallet_address;
                                $log->insert();

                                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to create community, please retry again.'));
                                exit();
                            }
                            else {
                                $community = new Community();
                                $community->dao_name    = $dao_name;
                                $community->dao_domain  = $dao_domain;
                                $community->ticker      = $ticker;
                                $community->contract_name   = $contract_name;
                                $community->blockchain      = $blockchain;
                                $community->wallet_adr      = $wallet_address;
                                $community->display_name    = 'Initial User';

                                /*------from api response-------*/

                                if($blockchain == SOLANA) {
                                    /*
                                     * ---------for addSolanaCommunityWithoutMint()------------
                                     *
                                    $community->txHash = $api_response->txHash;
                                    $community->community_address = $api_response->communityAddress;
                                    $community->gas_address = $api_response->gasTankInfo->address;
                                    $community->gas_private_key = $api_response->gasTankInfo->privateKey;
                                     *
                                     */
                                    $community->gas_address     = $api_response->gasTankInfo->address;
                                    $community->gas_private_key = $api_response->gasTankInfo->privateKey;

                                    $community->dao_wallet      = $api_response->realmInfo->daoWallet;
                                    $community->realm_pk        = $api_response->realmInfo->realmPk;
                                    $community->governance_pk   = $api_response->realmInfo->governancePk;
                                }
                                else {
                                    $community->gas_address     = $api_response->gasTankInfo->gasTankAddress;
                                    $community->gas_private_key = $api_response->gasTankInfo->gasTankPrivateKey;
                                }

                                $community->ch = Utils::getUniqid();
                                $com_id = $community->insert();

                                $log = new Log();
                                $log->type      = 'Community';
                                $log->type_id   = $com_id;
                                $log->action    = 'created';
                                $log->c_by      = $community->wallet_adr;
                                $log->insert();

                                $form = Form::get(2);
                                $contribusion = new Contribution();
                                $contribusion->comunity_id = $com_id;
                                $contribusion->wallet_from = $community->wallet_adr;
                                $contribusion->contribution_reason = ucfirst(strtolower($community->dao_name));
                                $contribusion->wallet_to = $community->wallet_adr;
                                $contribusion->form_id   = 2;
                                $contribusion->max_point = $form->max_point;
                                $contribusion->scoring   = $form->scoring;
                                $contribusion->approval_type     = $form->approval_type;
                                $contribusion->rating_categories = $form->rating_categories;
                                $contribusion->status    = 1;
                                $contribusion->score     = 0;
                                $contribusion->tags      = 'Onboarding';
                                $con_id = $contribusion->insert();

                                $log = new Log();
                                $log->type      = 'Contribution';
                                $log->type_id   = $con_id;
                                $log->action    = 'create-pending';
                                $log->c_by      = $wallet_address;
                                $log->insert();

                                echo json_encode(array('success' => true,'blockchain' =>$blockchain,'api_response' => $api_response,'url' => 'https://' . $dao_domain . '.' . base_app_url . '/contribution?ch=' . $community->ch));
                            }
                        }
                        else
                            echo json_encode(array('success' => false, 'msg' => "This name is already taken. Please try a different name.", 'element' => 'dao_domain'));
                    }
                    else
                        throw new Exception("dao_domain:Not a valid dao domain");

                }
                catch (Exception $e)
                {
                    $msg = explode(':',$e->getMessage());
                    $element = 'error-msg';
                    if(isset($msg[1])){
                        $element = $msg[0];
                        $msg = $msg[1];
                    }
                    echo json_encode(array('success' => false,'msg'=>$msg,'element'=>$element));
                }
                exit();
            }
        } else {
            $__page = (object)array(
                'title' => 'Create NTTs',
                'blockchain' => GNOSIS_CHAIN,
                 'sections' => array(
                    __DIR__ . '/../tpl/section.onboard.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/base.php';
            exit();
        }


    }
}
?>