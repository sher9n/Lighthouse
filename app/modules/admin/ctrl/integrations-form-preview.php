<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Form;
use lighthouse\FormElement;
class controller extends Ctrl {
    function init() {
        $form       = null;
        $is_admin   = false;
        $community  = Community::getByDomain(app_site);
        $sel_wallet_adr = null;

        $login = Auth::attemptLogin();
        if($login != false) {
            $sel_wallet_adr = $login;
            $is_admin       = $community->isAdmin($sel_wallet_adr);
        }
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        $form_title     = $form_description = null;
        $questions      = array();
        $selected_type  = $question = $description = $required = $element_ids =  array();

        if ($this->hasParam('form_title') && strlen($this->getParam('form_title')) > 0)
            $form_title = $this->getParam('form_title');

        if ($this->hasParam('form_description') && strlen($this->getParam('form_description')) > 0)
            $form_description = $this->getParam('form_description');

        if ($this->hasParam('selected_type') && count($this->getParam('selected_type')) > 0)
            $selected_type = $this->getParam('selected_type');

        if ($this->hasParam('question') && count($this->getParam('question')) > 0)
            $question = $this->getParam('question');

        if ($this->hasParam('description') && count($this->getParam('description')) > 0)
            $description = $this->getParam('description');

        if ($this->hasParam('required') && count($this->getParam('required')) > 0)
            $required = $this->getParam('required');

        if ($this->hasParam('element_ids') && count($this->getParam('element_ids')) > 0)
            $element_ids = $this->getParam('element_ids');

        $keys = array_keys($selected_type);

        foreach ($keys as $index => $i) {

            if(isset($element_ids[$i]))
                $questions[$i]['e_id'] = is_array($element_ids[$i])?array_key_first($element_ids[$i]):null;
            else
                $questions[$i]['e_id'] = null;

            $questions[$i]['e_type'] = $selected_type[$i];

            if(isset($question[$i]) && strlen($question[$i]) > 0)
                $questions[$i]['e_label'] = $question[$i];

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

        $site = Auth::getSite();
        if($site === false) {
            header("Location: https://lighthouse.xyz");
            die();
        }

        if($this->hasParam('form_id'))
            $form = Form::get($this->getParam('form_id'));

        $__page = (object)array(
            'title' => $site['site_name'],
            'site'  => $site,
            'is_admin'   => $is_admin,
            'blockchain' => GNOSIS_CHAIN,
            'sel_wallet_adr' => $sel_wallet_adr,
            'logo_url' => $community->getLogoImage(),
            'sections' => array(
                __DIR__ . '/../tpl/section.admin-form-preview.php'
            ),
            'js' => array()
        );
        require_once app_template_path . '/admin-base.php';
        exit();

    }
}
?>