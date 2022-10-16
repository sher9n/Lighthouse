<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Steward;
use lighthouse\User;
use lighthouse\Api;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            $com = Community::getByDomain(app_site);

            if(__ROUTER_PATH == '/wallet-menu' ) {
                $selected_adr = $this->getParam('sel_add');
                Auth::setCookieWallet($selected_adr);
                $new_user = false;

                if(User::isExistUser($selected_adr,$com->id) === false){
                    $u = new User();
                    $u->wallet_adr  = $selected_adr;
                    $u->comunity_id = $com->id;
                    $u->insert();
                    $new_user = true;
                }

                $user_role = $com->isAdmin($selected_adr)?'admin':'user';
                echo json_encode(array('success' => true,'new_user' => $new_user,'user_role' =>$user_role ));
                exit();
            }
            else if(__ROUTER_PATH =='/disconnect_wallet') {
                Auth::clearCookieWallet();
                $solana = false;
                if($com->blockchain == 'solana')
                    $solana = true;

                echo json_encode(array('success' => true,'solana' => $solana ));
                exit();
            }
            else if(__ROUTER_PATH == '/ntt-consent') {

                if($this->hasParam('wallet_address')) {
                    $comId = $com->id;
                    $consent = $this->hasParam('consent') ? $this->getParam('consent') : null;
                    $selected_adr = $this->getParam('wallet_address');
                    $user = User::isExistUser($selected_adr, $comId);

                    if ($user instanceof User && $this->hasParam('consent')) {
                        $consent = $this->getParam('consent');
                        if ($consent == 1) {
                            //$user->ntt_consent_bar = 1;
                            //$user->ntt_consent     = 1;

                            $api_response = api::addDelegate(constant(strtoupper(SOLANA) . "_API"), $com->contract_name, $selected_adr);

                            if (isset($api_response->error)) {
                                $log = new Log();
                                $log->type = 'delegate';
                                $log->log = serialize($api_response->error);
                                $log->action = 'failed';
                                $log->c_by = $selected_adr;
                                $log->insert();

                                echo json_encode(array('success' => false, 'msg' => 'Fail! Unable to submit for non-transferrable reputation tokens, please retry again.'));
                                exit();
                            }

                            echo json_encode(array('success' => true, 'api_response' => $api_response, 'user_id' => $user->id));
                        } else {
                            $user->ntt_consent_bar = 1;
                            $user->update();

                            echo json_encode(array('success' => true, 'api_response' => false));
                        }

                    }
                    else
                        echo json_encode(array('success' => false, 'msg' => "Something went wrong..."));
                }
                else
                {
                    $user = $this->hasParam('user_id')?User::get($this->getParam('user_id')):null;

                    if($user instanceof User){
                        $user->ntt_consent_bar = 1;
                        $user->ntt_consent = 1;
                        $user->update();
                        echo json_encode(array('success' => true));
                    }
                }
                exit();
            }
        }
        else {

            $login = Auth::attemptLogin();

            if($login != false ) {
                if(!is_null($this->__lh_request->get__PB()))
                    header("Location: " . $this->__lh_request->get__PB());
                else
                    header("Location: contribution");
                exit();
            }

            $site       = Auth::getSite();
            $wallet_adr = null;
            $community  = Community::getByDomain(app_site);

            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }


            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'ticker' => $community->ticker,
                'blockchain' => $site['blockchain'],
                'dao_name' => strtoupper($site['sub_domain']),
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>