<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Steward;
use lighthouse\User;
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

                echo json_encode(array('success' => true,'new_user' => $new_user));
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
            else if(__ROUTER_PATH == '/ntt-consent' && $this->hasParam('wallet_address')) {
                $comId        = $com->id;
                $consent      = $this->hasParam('consent')?$this->getParam('consent'):null;
                $selected_adr = $this->getParam('wallet_address');
                $user         = User::isExistUser($selected_adr,$comId);

                if($user instanceof User && $this->hasParam('consent')){
                    $consent = $this->getParam('consent');
                    if($consent == 1){
                        $user->ntt_consent_bar = 1;
                        $user->ntt_consent     = 1;
                    }
                    else
                        $user->ntt_consent_bar = 1;

                    $user->update();
                    echo json_encode(array('success' => true));
                }
                else
                    echo json_encode(array('success' => false,'msg' => "Something went wrong..."));
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