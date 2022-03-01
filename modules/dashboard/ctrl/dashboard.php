<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            if($this->__lh_request->is_post){
                $comment    = $this->hasParam('comments')?$this->getParam('comments'):'';
                $user_key   = $this->hasParam('user_key')?$this->getParam('user_key'):'';
                $status     = false;
                $respose    = Utils::LightHouseApi('posts',array('user_key'=>$user_key,'post'=>$comment));
                if($respose['status'] == 200) {
                    $html = '<hr><div class="row"><div class="col-md-12"><p><strong>Posted By:</strong> '.$user_key.'</p><p><strong>Message :</strong> '.$comment.'</p></div></div>';
                    echo json_encode(array('success' => true,'comment' => $html));
                }
                else
                    echo json_encode(array('success' => false));

                exit();
            }
            else {
                if (__ROUTER_PATH == '/get-coins') {
                    $data     = array();
                    $success  = false;
                    $user_key = $this->getParam('user_key');
                    //$user_key = '0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507';
                    $p        = $this->hasParam('p')?$this->getParam('p'):0;

                    if($this->hasParam('search') && strlen($this->getParam('search')) > 0) {
                        $search = $this->getParam('search');
                        $response = Utils::LightHouseApi("coins?address=$user_key&page=$p&search=$search");
                    }
                    else
                        $response = Utils::LightHouseApi("coins?address=$user_key&page=$p");

                    if($response['status'] == 200) {
                        $success = true;
                        $coins = $response['data'];
                        include __DIR__ . '/../tpl/partial/list_items.php';
                        $html = ob_get_clean();
                    }

                    echo json_encode(array('success' => $success,'lines' => $html));
                    exit();
                }
                elseif (__ROUTER_PATH == '/pin-coin') {
                    $user_key = $this->getParam('user_key');
                    $action = 'pin';
                    if($this->hasParam('unpin')) {
                        $action = 'unpin';
                        $coin_id = $this->getParam('unpin');
                        $response = Utils::LightHouseApi("pin-coin?address=$user_key&coin=$coin_id&action=unpin");
                    }
                    elseif ($this->hasParam('pin')) {
                        $coin_id = $this->getParam('pin');
                        $response = Utils::LightHouseApi("pin-coin?address=$user_key&coin=$coin_id&action=pin");
                    }

                    if($response['status'] == 200)
                        echo json_encode(array('success' => true,'action' =>$action));
                    else
                        echo json_encode(array('success' => false));
                    exit();
                }
            }
        }

        $commnets = array();
        $respose  = Utils::LightHouseApi('posts');
        if($respose['status'] == 200)
            $commnets = $respose['data'];

        $__page = (object)array(
            'title' => 'Dashboard',
            'tab' => 'messages',
            'commnets' => $commnets,
            'sections' => array(
                __DIR__ . '/../tpl/section.dashboard.php'
            ),
            'js' => array()
        );
        require_once app_template_path . '/base.php';
        exit();
    }
}
?>