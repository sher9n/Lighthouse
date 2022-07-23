<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Form;
class controller extends Ctrl {
    function init() {
        $is_admin = false;
        $sel_wallet_adr = null;
        $community = Community::getByDomain(app_site);
        $com_id    = $community->id;

        if(isset($_SESSION['lh_sel_wallet_adr']) && strlen($_SESSION['lh_sel_wallet_adr']) > 0) {
            $sel_wallet_adr = $_SESSION['lh_sel_wallet_adr'];
            $is_admin = $community->isAdmin($sel_wallet_adr);
        }
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

            $forms = Form::find("SELECT * FROM forms WHERE id <> 2 AND comunity_id='$com_id'",true);

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'forms' => $forms,
                'is_admin' => $is_admin,
                'blockchain' => $community->blockchain,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-integrations.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>