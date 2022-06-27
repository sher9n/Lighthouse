<?php
use lighthouse\Auth;
class controller extends Ctrl {
    function init() {

        $sel_wallet_adr = null;

        if(isset($_SESSION['lh_sel_wallet_adr']))
            $sel_wallet_adr = $_SESSION['lh_sel_wallet_adr'];
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }
            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'blockchain' => GNOSIS_CHAIN,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-integrations-form.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>