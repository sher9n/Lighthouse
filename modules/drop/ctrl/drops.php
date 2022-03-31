<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            if (__ROUTER_PATH == '/get-drops') {

                $html = '';

                if($this->hasParam('id')) {
                    $drop_id  = $this->getParam('id');
                    $user_add = null;
                    $claim    = false;
                    if($this->hasParam('sel_add') && strlen($this->getParam('sel_add')) > 0)
                        $user_add = $this->getParam('sel_add');

                    include __DIR__ . '/../tpl/partial/drop-details.php';
                }
                else
                    include __DIR__ . '/../tpl/partial/drops.php';

                $html .= ob_get_clean();

                echo json_encode(array('success' => true,'html' => $html));
                exit();
            }
        }
        else {

            $__page = (object)array(
                'title' => 'Dashboard',
                'tab' => 'messages',
                'sections' => array(
                    __DIR__ . '/../tpl/section.drops.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/dash_base.php';
            exit();
        }
    }
}
?>