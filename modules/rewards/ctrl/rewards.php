<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/get-rewards'){

                $user_add   = null;
                $search     = '';
                if($this->hasParam('sel_add') && strlen($this->getParam('sel_add')) > 0)
                    $user_add = $this->getParam('sel_add');

/*                $html = '<div class="row align-items-center">
                            <div class="col mt-30">
                                <div class="text-center">
                                    <img src="'.app_cdn_path.'img/img-no-claim.png" height="160" >
                                </div>
                                <div class="fs-1 fw-semibold text-center mt-20">No claims yet!</div>
                                <div class="fs-5 fw-medium text-center text-muted mt-6">Please complete some challenges to unlock rewards.<br>Claimed rewards will appear here.</div>
                            </div>
                        </div>';*/

                if($this->hasParam('search'))
                    $search = $this->getParam('search');

                $response = Utils::LightHouseApi("claims?wallet_adr=$user_add&search=$search");
                if(isset($response['data'])) {
                    $html = '';
                    $claims  = $response['data'];
                    $is_notified = ($response['message'] && $response['message']=='Notified');
                    include __DIR__ . '/../tpl/partial/rewards.php';
                    $html .= ob_get_clean();
                }
                echo json_encode(array('success' => true,'html' => $html));
                exit();
            }
            else if (__ROUTER_PATH == '/rewards' && $this->getParam('drop_id') && $this->getParam('wallet_adr')){
                $drop_id = $this->getParam('drop_id');
                $waller_adr = $this->getParam('wallet_adr');
                $response = Utils::LightHouseApi("claim-drop",array('wallet_adr' =>$waller_adr,'drop_id' =>$drop_id ));
                if($response['message'] == 'Fail')
                    echo json_encode(array('success' => false));
                else
                    echo json_encode(array('success' => true));
                exit();
            }
        }
        else {
            $__page = (object)array(
                'title' => 'Rewards',
                'tab' => 'messages',
                'sections' => array(
                    __DIR__ . '/../tpl/section.rewards.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>