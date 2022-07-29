<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Form;
use lighthouse\FormElement;
class controller extends Ctrl {
    function init() {
        $is_admin = false;
        $sel_wallet_adr = null;
        $form = null;
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

        if($this->__lh_request->is_xmlHttpRequest) {

            if($this->__lh_request->is_post) {

                try {

                    if ($this->hasParam('realm_id') && strlen($this->getParam('realm_id')) > 0)
                        $community->realm_id = $this->getParam('realm_id');
                    else
                        throw new Exception("realm_id:Not a valid key");

                    if ($this->hasParam('scoring'))
                        $community->scoring = 1;
                    else
                        $community->scoring = 0;

                    if ($this->hasParam('for_vote'))
                        $community->for_vote = $this->getParam('for_vote');

                    if ($this->hasParam('for_proposal'))
                        $community->for_proposal  = $this->getParam('for_proposal');

                    if ($this->hasParam('for_other_proposal'))
                        $community->for_other_proposal = $this->getParam('for_other_proposal');

                    $community->update();

                    echo json_encode(array('success' => true,'message'=>'Success! Your changes have been saved.'));
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
                header("Location: https://getlighthouse.xyz");
                die();
            }

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'is_admin' => $is_admin,
                'community' => $community,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.realms-settings.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>