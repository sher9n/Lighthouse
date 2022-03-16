<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

        }

        $__page = (object)array(
            'title' => 'Validate',
            'tab' => 'messages',
            'sections' => array(
                __DIR__ . '/../tpl/section.validate.php'
            ),
            'js' => array()
        );
        require_once app_template_path . '/base.php';
        exit();
    }
}
?>