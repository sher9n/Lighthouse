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

        $login = Auth::attemptLogin();
        if($login != false) {
            $sel_wallet_adr = $login;
            $is_admin = $community->isAdmin($sel_wallet_adr);
        }
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {
            if (__ROUTER_PATH == '/form-activation' && $this->hasParam('fid')) {
                $fid = $this->getParam('fid');
                $status = $this->hasParam('status')?$this->getParam('status'):1;
                if($fid==1){
                    $community->simple_claim_form = $status;
                    $community->update();
                }
                else {
                    $form = Form::get($fid);
                    $form->active = $status;
                    $form->update();
                }
                echo json_encode(array('success' => true));
                exit();
            }
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
                'ticker' => $community->ticker,
                'forms' => $forms,
                'is_admin' => $is_admin,
                'blockchain' => $community->blockchain,
                'simple_claim_form' => $community->simple_claim_form,
                'logo_url' => $community->getLogoImage(),
                'sel_wallet_adr' => $sel_wallet_adr,
                'user' => \lighthouse\User::isExistUser($sel_wallet_adr,$community->id),
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