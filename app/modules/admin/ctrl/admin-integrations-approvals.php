<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Form;
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

        if($this->getParam('form_id') && strlen($this->getParam('form_id')) > 0) {
            $form_id = $this->getParam('form_id');
            $form = Form::get($form_id);
        }
        else {
            header("Location: " . app_url.'integrations-form');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            if($this->__lh_request->is_post) {

                $scoring   = 0;
                $max_point = 0;
                $rating    = 1;
                $approval_type = 1;

                try {

                    if($this->hasParam('scoring') && $this->getParam('scoring') == 'on') {
                        $scoring = 1;

                        if($this->hasParam('max_point') && $this->getParam('max_point') > 0) {
                            $max_point = $this->getParam('max_point');
                            $form->max_point = $max_point;
                        }
                        else
                            throw new Exception("max_point:This field is required.");

                    }

                    if ($this->hasParam('approval_days') && $this->getParam('approval_days') > 0)
                        $form->approval_days = $this->getParam('approval_days');
                    else
                        throw new Exception("approval_days:Not a valid day");

                    if($this->hasParam('approval_type'))
                        $approval_type = $this->getParam('approval_type');


                    $form->scoring = $scoring;
                    $form->approval_type = $approval_type;

                    if($this->hasParam('tags') && count($this->getParam('tags')) > 0)
                        $form->tags = implode(",",$this->getParam('tags'));

                    if($form->approval_type == 2) {
                        $rating_cats = array();
                        if($this->hasParam('category') && count($this->getParam('category'))) {
                            $categories = $this->getParam('category');
                            $row_id = 1;
                            foreach ($categories as $category) {
                                if(strlen($category) > 0)
                                    array_push($rating_cats,$category);
                                else
                                    throw new Exception("category".$row_id.":This fields are required.");
                                $row_id++;
                            }

                            $form->rating_categories = json_encode($rating_cats);
                        }
                    }

                    $form->update();
                    echo json_encode(array('success' => true,'message' => 'Success! Your form has been updated.'));

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
                'form' => Form::get($form_id),
                'is_admin' => $is_admin,
                'blockchain' => GNOSIS_CHAIN,
                'logo_url' => $community->getLogoImage(),
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