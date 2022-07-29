<?php
use lighthouse\Auth;
use lighthouse\Community;
class controller extends Ctrl {
    function init() {

        if(isset($_SESSION['lh_sel_wallet_adr']) && !is_null($this->__lh_request->get__PB())) {
            header("Location: " . $this->__lh_request->get__PB());
            exit();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            $com = Community::getByDomain(app_site);

            if(__ROUTER_PATH == '/wallet-menu' ) {
                $selected_adr = $this->getParam('sel_add');
                //if($com->isAdmin($selected_adr)) {
                    $_SESSION['lh_sel_wallet_adr'] = $selected_adr;
                    echo json_encode(array('success' => true));
/*                }
                else {
                    $_SESSION['lh_sel_wallet_adr'] = null;
                    $_SESSION['lighthouse'] = null;
                    echo json_encode(array('success' => false));
                }*/
                exit();
            }
            else if(__ROUTER_PATH =='/disconnect_wallet') {

                $solana = false;
                if($com->blockchain == 'solana')
                    $solana = true;

                echo json_encode(array('success' => true,'solana' => $solana ));
                exit();
            }
        }
        else {
            $wallet_adr = null;

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://getlighthouse.xyz");
                die();
            }


            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
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