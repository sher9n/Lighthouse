<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            if($this->__lh_request->is_get) {
                if(__ROUTER_PATH == '/get-spaces') {
                    $data = array();
                    $rc = $rf = 0;
                    $start = $this->hasParam('start')?$this->getParam('start'):1;
                    $user_key = $this->hasParam('user_key')?$this->getParam('user_key'):null;
                    $limit = $this->hasParam('length')?$this->getParam('length'):20;
                    $search = $this->hasParam('search')?$this->getParam('search'):'';

                    if(strlen($search['value']) > 0 ) {
                        $search_val = $search['value'];
                        $response = Utils::LightHouseApi("spaces?start=$start&limit=$limit&user_key=$user_key&search=$search_val");
                    }
                    else
                        $response =  Utils::LightHouseApi("spaces?start=$start&limit=$limit&user_key=$user_key");

                    if($response['status'] == 200 && isset($response['data'])) {
                        $response_data = $response['data']['data'];

                        foreach ($response_data as $data_row) {
                            $option_html = '';

                            if(strlen($data_row['c_id']) > 0) {
                                $c_ids      = explode(',', $data_row['c_id']);
                                $c_names    = explode(',', $data_row['c_name']);

                                foreach ($c_ids as $index => $val) {
                                    $option_html .= '<option value="'.$val.'">'.$c_names[$index].'</option>';
                                }
                            }

                            $space_id = $data_row['id'];
                            $data[] = array(
                                $data_row['space_name'],
                                $data_row['space_id'],
                                $data_row['symbol'],
                                '<select id="space-'.$space_id.'" class="form-control space_coin">'.$option_html.'</select>',
                                '<a href="update-space-coin?space_id='.$space_id.'" data-bs-target="#updateSpace" class="edit_space_coin" data-bs-toggle="modal" data-id="'.$data_row['id'].'">Update</a> | <a href="delete-space-coin?space_id='.$space_id.'" data-id="'.$data_row['id'].'" data-bs-toggle="modal" data-bs-target="#removeSpace" class="remove_space_coin">Remove</a>'
                            );
                        }

                        $rc = $response['data']['count'];
                        $rf = $response['data']['count'];
                    }

                    echo json_encode(array('data' => $data, 'recordsTotal' => $rc, 'recordsFiltered' => $rf));
                    exit();
                }
                elseif (__ROUTER_PATH == '/coin-search') {

                    $q = $this->hasParam('q') ? $this->getParam('q') : '';
                    $response =  Utils::LightHouseApi("space-coins?search=$q");

                    if($response['status'] == 200 && isset($response['data']))
                         echo json_encode(array('success' => true, 'items' => $response['data']));
                    else
                        echo json_encode(array('success' => false, 'items' => array()));

                    exit();
                }
            }
            else {

                if(__ROUTER_PATH == '/update-space-coin' || __ROUTER_PATH == '/delete-space-coin' ) {

                    if($this->hasParam('space_id') || $this->hasParam('user_key')) {
                        $space_id   = $this->getParam('space_id');
                        $user_id    = $this->getParam('user_key');
                        $coin_id    = ($this->hasParam('coin_id') && strlen($this->getParam('coin_id')))?$this->getParam('coin_id'):null;
                        $update     = (__ROUTER_PATH == '/update-space-coin')?1:0;
                        $response   =  Utils::LightHouseApi("update-space",array('address' => $user_id,'coin_id' =>$coin_id,'space_id' => $space_id,'update' => $update));

                        if($response['status'] == 200)
                            echo json_encode(array('success' => true,'space_id' => $space_id));
                        else
                            echo json_encode(array('success' => false));
                    }
                    else
                        echo json_encode(array('success' => false));
                    exit();
                }
            }
        }

        $is_validate = true;

/*        if($this->hasParam('wid')) {
            $wallet_id = $this->getParam('wid');
            $response =  Utils::LightHouseApi("validate-user?address=".$wallet_id);

            if(isset($response['data']) && $response['data']['is_validator'] == true) {
                $is_validate = true;
            }
        }*/

        $__page = (object)array(
            'title' => 'Validate',
            'tab' => 'messages',
            'is_validate' => true,
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