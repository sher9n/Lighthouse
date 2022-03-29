<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/get_claims'){

                $html = '<div class="row align-items-center">
                            <div class="col mt-30">
                                <div class="text-center">
                                    <img src="'.app_cdn_path.'img/img-no-claim.png" height="160" >
                                </div>
                                <div class="fs-1 fw-semibold text-center mt-20">No claims yet!</div>
                                <div class="fs-5 fw-medium text-center text-muted mt-6">Please complete some challenges to unlock rewards.<br>Claimed rewards will appear here.</div>
                            </div>
                        </div>';
                /*include __DIR__ . '/../tpl/partial/claims.php';
                $html .= ob_get_clean();*/

                echo json_encode(array('success' => true,'html' => $html));
                exit();
            }
        }
        else {
            $__page = (object)array(
                'title' => 'Dashboard',
                'tab' => 'messages',
                'sections' => array(
                    __DIR__ . '/../tpl/section.claim.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/dash_base.php';
            exit();
        }
    }
}
?>