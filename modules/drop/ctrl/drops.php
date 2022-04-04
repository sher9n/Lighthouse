<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            if (__ROUTER_PATH == '/get-drops') {

                $html       = '';
                $user_add   = null;
                if($this->hasParam('sel_add') && strlen($this->getParam('sel_add')) > 0)
                    $user_add = $this->getParam('sel_add');
                //$user_add = '0xfA64e1445DFB9B98795c3FA4a2F022419B64Ec9B';
                if($this->hasParam('id')) {
                    $drop_id  = $this->getParam('id');
                    $claim    = false;
                    $response =  Utils::LightHouseApi("drop?drop_id=".$drop_id."&wallet_adr=".$user_add);

                    include __DIR__ . '/../tpl/partial/drop-details.php';
                }
                else {
                    $search = '';
                    if($this->hasParam('search'))
                        $search = $this->getParam('search');

                    $response =  Utils::LightHouseApi("drops?wallet_adr=".$user_add."&search=".$search);
                    include __DIR__ . '/../tpl/partial/drops.php';
                }

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