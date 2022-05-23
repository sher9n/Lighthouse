<?php
use lighthouse\Auth;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }
            $__page = (object)array(
                'title' => app_site,
                'site' => $site,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-approvals.php'
                ),
                'js' => array('https://unpkg.com/feather-icons')
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>