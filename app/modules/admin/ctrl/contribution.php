<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Contribution;
use lighthouse\Log;
use lighthouse\Form;
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

        $site = Auth::getSite();
        if($site === false) {
            header("Location: " . app_url.'admin');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            try {

                $form_id = $wallet_to = $contribution_reason = null;
                $community = Community::getByDomain($site['sub_domain']);
                $post = $_POST;
                unset($post['form_id']);
                unset($post['contribution_reason']);
                unset($post['wallet_address']);

                if($this->hasParam('form_id') && strlen($this->getParam('form_id')) > 0)
                    $form_id = $this->getParam('form_id');
                else
                    throw new Exception("Invalid form details, please contact your admin");

                if($this->hasParam('wallet_address') && strlen($this->getParam('wallet_address')) > 0)
                    $wallet_to = $this->getParam('wallet_address');
                else
                    throw new Exception("wallet_address:This field is required.");

                if($this->hasParam('contribution_reason') && strlen($this->getParam('contribution_reason')) > 0)
                    $contribution_reason = $this->getParam('contribution_reason');
                else
                    throw new Exception("contribution_reason:This field is required.");

                $form = Form::get($form_id);
                $elements = $form->getElements();

                foreach ($elements as $element) {
                    if($element['e_required'] == 1) {
                        $ele_name = $element['e_name'];
                        if(!isset($post[$ele_name]) || strlen($post[$ele_name]) < 1)
                            throw new Exception($ele_name.":This field is required.");
                    }
                }

                $contribusion  = new Contribution();
                $contribusion->comunity_id = $community->id;
                $contribusion->wallet_from = $sel_wallet_adr;
                $contribusion->contribution_reason = $contribution_reason;
                $contribusion->wallet_to   = $wallet_to;
                $contribusion->form_id     = $form_id;
                $contribusion->form_data   = json_encode($post);
                $contribusion->insert();

                echo json_encode(array('success' => true, 'message' => 'Success! Your contribution have been sent.'));

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
        else {

            $form = null;
            $template = '/../tpl/section.contribution.php';

            if($this->hasParam('form') && strlen($this->getParam('form')) > 0) {
                $form_id = $this->getParam('form');
                $form = Form::get($form_id);
                $template = '/../tpl/section.form_template.php';
            }

            $__page = (object)array(
                'title' => $site['site_name'],
                'form' => $form,
                'site' => $site,
                'blockchain' => $site['blockchain'],
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . $template
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>