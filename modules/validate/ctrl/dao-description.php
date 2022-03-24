<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            if($this->__lh_request->is_get) {
                if(__ROUTER_PATH == '/get-coins-info') {
                    $data = array();
                    $rc = $rf = 0;
                    $start = $this->hasParam('start')?$this->getParam('start'):1;
                    $user_key = $this->hasParam('user_key')?$this->getParam('user_key'):null;
                    $limit = $this->hasParam('length')?$this->getParam('length'):20;
                    $search = $this->hasParam('search')?$this->getParam('search'):'';

                    if(strlen($search['value']) > 0 ) {
                        $search_val = $search['value'];
                        $response = Utils::LightHouseApi("coins-info?start=$start&limit=$limit&user_key=$user_key&search=$search_val");
                    }
                    else
                        $response =  Utils::LightHouseApi("coins-info?start=$start&limit=$limit&user_key=$user_key");

                    if($response['status'] == 200 && isset($response['data'])) {
                        $response_data = $response['data']['data'];

                        foreach ($response_data as $data_row) {

                            $coin_id = $data_row['id'];
                            $data[] = array(
                                $data_row['info_name'],
                                $data_row['description'],
                                '<a id="coin-'.$coin_id.'" href="edit-coins-info?coin_id='.$coin_id.'&user_key='.$user_key.'" class="edit-coin">Edit</a> | <a href="delete-coins-info?coin_id='.$coin_id.'&user_key='.$user_key.'" data-id="'.$coin_id.'" data-bs-toggle="modal" data-bs-target="#removeCoin" class="remove_coin_info">Remove</a>'
                            );
                        }

                        $rc = $response['data']['count'];
                        $rf = $response['data']['count'];
                    }

                    echo json_encode(array('data' => $data, 'recordsTotal' => $rc, 'recordsFiltered' => $rf));
                    exit();
                }
                elseif (__ROUTER_PATH == '/edit-coins-info') {
                    echo json_encode(
                        array(
                            'success' => true,
                            'coin' => array()
                        )
                    );
                    exit();
                }
            }
            else {

                if(__ROUTER_PATH == '/edit-coins-info' || __ROUTER_PATH == '/delete-coins-info' ) {

                    if($this->hasParam('coin_id') && $this->hasParam('user_key')) {
                        $coin_id     = $this->getParam('coin_id');
                        $user_id     = $this->getParam('user_key');
                        $update      = (__ROUTER_PATH == '/edit-coins-info')?1:0;
                        $description = $this->hasParam('description')?$this->getParam('description'):'';
                        $response    =  Utils::LightHouseApi("update-coin-info",array('address' => $user_id,'coin_id' =>$coin_id,'description' => $description,'update' => $update));

                        if($response['status'] == 200)
                            echo json_encode(array('success' => true,'coin_id' => $coin_id));
                        else
                            echo json_encode(array('success' => false));
                    }
                    else
                        echo json_encode(array('success' => false));
                    exit();
                }
            }
        }

        $__page = (object)array(
            'title' => 'Validate coins info',
            'tab' => 'messages',
            'is_validate' => true,
            'sections' => array(
                __DIR__ . '/../tpl/section.dao-description.php'
            ),
            'js' => array()
        );
        require_once app_template_path . '/base.php';
        exit();
    }
}
?>