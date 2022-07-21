<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Form;
class controller extends Ctrl {
    function init() {
        $is_admin = false;
        $sel_wallet_adr = null;
        $form_id = null;
        $community = Community::getByDomain(app_site);

        if(isset($_SESSION['lh_sel_wallet_adr']) && strlen($_SESSION['lh_sel_wallet_adr']) > 0) {
            $sel_wallet_adr = $_SESSION['lh_sel_wallet_adr'];
            $is_admin = $community->isAdmin($sel_wallet_adr);
        }
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        if($this->getParam('form_id') && strlen($this->getParam('form_id')) > 0)
            $form_id = $this->getParam('form_id');
        else {
            header("Location: " . app_url.'integrations-form');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            if($this->__lh_request->is_post) {

                var_dump($_POST);exit();
                $scoring   = false;
                $max_point = 0;

                try {

                    if($this->hasParam('scoring') && $this->getParam('scoring') == 'on') {
                        $scoring = true;

                        if($this->hasParam('max_point') && $this->getParam('max_point') > 0)
                            $max_point = $this->getParam('max_point');
                        else
                            throw new Exception("max_point:This field is required.");

                    }

                    $form = Form::get($form_id);
                }
                catch (Exception $e) {

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
                'form_id' => $form_id,
                'is_admin' => $is_admin,
                'blockchain' => GNOSIS_CHAIN,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-integrations-approvals.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>