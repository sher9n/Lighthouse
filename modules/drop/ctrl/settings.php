<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        $__page = (object)array(
            'title' => 'Dashboard',
            'tab' => 'messages',
            'sections' => array(
                __DIR__ . '/../tpl/section.settings.php'
            ),
            'js' => array( app_cdn_path .'js/imageUpload.js')
        );
        require_once app_template_path . '/dash_base.php';
        exit();
    }
}
?>