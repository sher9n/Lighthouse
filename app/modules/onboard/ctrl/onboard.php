<?php
use Core\Utils;
use lighthouse\Community;
use lighthouse\Log;
use lighthouse\Claim;
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

                    $dao_name = $wallet_address = $dao_domain = $ticker = '';
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

                    if($this->hasParam('dao_domain') && strlen($this->getParam('dao_domain')) > 0) {
                        $dao_domain = $this->getParam('dao_domain');
                        $dao_domain = strtolower(preg_replace("/\s+/", "-", $dao_domain));
                        $domain_check = Community::isExistsCommunity($dao_domain);

                        if ($domain_check === FALSE) {
                            $ticker = strtoupper($dao_domain);
                            $subdomain = $dao_domain;

                            if ($blockchain != SOLANA)
                                $api_response = api::addCommunity(constant(strtoupper($blockchain) . "_API"), $dao_domain, $dao_domain, $ticker, 18, 0.0008,$wallet_address);
                            else
                                $api_response = api::addSolanaCommunity($dao_domain, $dao_domain, $ticker, 9,$wallet_address);

                            if (isset($api_response->error)) {
                                $log = new Log();
                                $log->type = 'Community';
                                $log->log = serialize($api_response->error);
                                $log->action = 'create-failed';
                                $log->c_by = $wallet_address;
                                $log->insert();

                                echo json_encode(array('success' => false, 'msg' => 'Your community has not been created, please contact your admin'));
                                exit();
                            }
                            else {
                                $community = new Community();
                                $community->dao_name = $dao_name;
                                $community->dao_domain = $dao_domain;
                                $community->blockchain = $blockchain;
                                $community->ticker = $ticker;
                                $community->wallet_adr = $wallet_address;
                                $community->display_name = 'Initial User';

                                /*------from api response-------*/
                                $community->token_address = $api_response->tokenAddress;

                                if($blockchain == SOLANA) {
                                    $community->txHash = $api_response->txHash;
                                    $community->community_address = $api_response->communityAddress;
                                    $community->gas_address = $api_response->gasTankInfo->address;
                                    $community->gas_private_key = $api_response->gasTankInfo->privateKey;
                                }
                                else {
                                    $community->gas_address = $api_response->gasTankInfo->gasTankAddress;
                                    $community->gas_private_key = $api_response->gasTankInfo->gasTankPrivateKey;
                                }

                                $community->ch = Utils::getUniqid();
                                $com_id = $community->insert();

                                $log = new Log();
                                $log->type = 'Community';
                                $log->type_id = $com_id;
                                $log->action = 'created';
                                $log->c_by = $community->wallet_adr;
                                $log->insert();

                                $contribusion = new Contribution();
                                $contribusion->comunity_id = $com_id;
                                $contribusion->wallet_from = $community->wallet_adr;
                                $contribusion->contribution_reason = "Created a new decentralized community.";
                                $contribusion->wallet_to = $community->wallet_adr;
                                $contribusion->form_id = 2;
                                $contribusion->status = 1;
                                $contribusion->score = 15;
                                $contribusion->tags = implode(',', array('Onboarding'));
                                $con_id = $contribusion->insert();

                                $log = new Log();
                                $log->type = 'Contribution';
                                $log->type_id = $con_id;
                                $log->action = 'create-pending';
                                $log->c_by = $wallet_address;
                                $log->insert();

                                echo json_encode(array('success' => true, 'url' => 'https://' . $dao_domain . '.' . base_app_url . '/admin-dashboard?ch=' . $community->ch));
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