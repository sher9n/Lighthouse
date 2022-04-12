<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            if (__ROUTER_PATH == '/get-opportunities') {

                $html       = '';
                $user_add   = null;
                if($this->hasParam('sel_add') && strlen($this->getParam('sel_add')) > 0)
                    $user_add = $this->getParam('sel_add');
                //$user_add = '0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507';
                if($this->hasParam('id')) {
                    $drop_id  = $this->getParam('id');
                    $claim    = false;
                    $response =  Utils::LightHouseApi("drop?drop_id=".$drop_id."&wallet_adr=".$user_add);
                    include __DIR__ . '/../tpl/partial/opportunity-details.php';
                }
                else {
                    $search = '';
                    if($this->hasParam('search'))
                        $search = $this->getParam('search');

                    $response =  Utils::LightHouseApi("drops?wallet_adr=".$user_add."&search=".$search);
                    include __DIR__ . '/../tpl/partial/opportunities.php';
                }

                $html .= ob_get_clean();

                echo json_encode(array('success' => true,'html' => $html));
                exit();
            }
        }
        else {

            $__page = (object)array(
                'title' => 'Opportunities',
                'tab' => 'messages',
                'sections' => array(
                    __DIR__ . '/../tpl/section.opportunities.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>