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

                    $form_title = $form_description = null;
                    $questions = array();
                    $selected_type = $question = $description = $required = $element_ids =  array();

                    if ($this->hasParam('form_title') && strlen($this->getParam('form_title')) > 0)
                        $form_title = $this->getParam('form_title');
                    else
                        throw new Exception("form_title:Not a valid Title");

                    if ($this->hasParam('form_description') && strlen($this->getParam('form_description')) > 0)
                        $form_description = $this->getParam('form_description');

                    if ($this->hasParam('selected_type') && count($this->getParam('selected_type')) > 0)
                        $selected_type = $this->getParam('selected_type');
                    else
                        throw new Exception("Invalid question type");

                    if ($this->hasParam('question') && count($this->getParam('question')) > 0)
                        $question = $this->getParam('question');
                    else
                        throw new Exception("Invalid question");

                    if ($this->hasParam('description') && count($this->getParam('description')) > 0)
                        $description = $this->getParam('description');
                    else
                        throw new Exception("Invalid question description");

                    if ($this->hasParam('required') && count($this->getParam('required')) > 0)
                        $required = $this->getParam('required');

                    if ($this->hasParam('element_ids') && count($this->getParam('element_ids')) > 0)
                        $element_ids = $this->getParam('element_ids');

                    $q_count = count($selected_type);

                    for($i=1;$i <= $q_count; $i++) {

                        if(isset($element_ids[$i]))
                            $questions[$i]['e_id'] = is_array($element_ids[$i])?array_key_first($element_ids[$i]):null;
                        else
                            $questions[$i]['e_id'] = null;

                        $questions[$i]['e_type'] = $selected_type[$i];

                        if(isset($question[$i]) && strlen($question[$i]) > 0)
                            $questions[$i]['e_label'] = $question[$i];
                        else
                            throw new Exception("question_" . $i . ":This field is required.");

                        if(isset($description[$i])) {
                            if(is_array($description[$i]))
                                $questions[$i]['e_description'] = json_encode($description[$i]);
                            else
                                $questions[$i]['e_description'] = $description[$i];
                        }

                        if(isset($required[$i]))
                            $questions[$i]['e_required'] = $required[$i];

                        if(isset($required[$i]))
                            $questions[$i]['e_required'] = $required[$i];
                    }

                    if($this->hasParam('form_id') && strlen($this->getParam('form_id')) > 0) {
                        $new_form_id = $this->getParam('form_id');
                        $form = Form::get($new_form_id);
                        $form->form_title = $form_title;
                        $form->form_description = $form_description;
                        $form->update();
                    }
                    else {
                        $form = new Form();
                        $form->form_title = $form_title;
                        $form->form_description = $form_description;
                        $form->comunity_id = $community->id;
                        $new_form_id = $form->insert();
                    }

                    $order = 1;

                    foreach ($questions as $index => $question){
                        if(!is_null($question['e_id'])) {
                            $id = $question['e_id'];
                            $formElement = FormElement::get($id);
                            $formElement->e_type  = $question['e_type'];
                            $formElement->e_label = $question['e_label'];
                            $formElement->e_order = $order;
                            $label_name = strtolower(preg_replace("/\s+/", "_", $formElement->e_label));
                            $formElement->e_name  = $label_name;
                            $formElement->e_id    = $label_name;
                            $formElement->e_required = isset($question['e_required'])?1:0;
                            $formElement->e_description = $question['e_description'];
                            $formElement->update();
                        }
                        else {
                            $formElement = new FormElement();
                            $formElement->form_id = $new_form_id;
                            $formElement->e_type  = $question['e_type'];
                            $formElement->e_label = $question['e_label'];
                            $formElement->e_order = $order;
                            $label_name = strtolower(preg_replace("/\s+/", "_", $formElement->e_label));
                            $formElement->e_name  = $label_name;
                            $formElement->e_id    = $label_name;
                            $formElement->e_required = isset($question['e_required'])?1:0;
                            $formElement->e_description = $question['e_description'];
                            $formElement->insert();
                        }
                        $order++;
                    }

                    echo json_encode(array('success' => true,'form_id' => $new_form_id,'message' => 'Success! Your form has been submitted.'));
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
            else {

                if (__ROUTER_PATH == '/get-form-question') {
                    $row_id = $this->hasParam('rid') ? $this->getParam('rid') : 1;
                    $type   = $this->hasParam('type') ? $this->getParam('type') : 1;
                    $row_id++;
                    include __DIR__ . '/../tpl/partial/question.php';
                    $html = ob_get_clean();
                    echo json_encode(array('success' => true, 'html' => $html, 'row_id' => $row_id ));
                    exit();
                }
            }

        }
        else {
 
            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            if($this->hasParam('form_id'))
                $form = Form::get($this->getParam('form_id'));

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'row_id' => 1,
                'form' => $form,
                'is_admin' => $is_admin,
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