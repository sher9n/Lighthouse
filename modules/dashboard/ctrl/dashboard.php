<?php
use Core\Ds;
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
                if (__ROUTER_PATH == '/get-erc721') {
                    $data = array();
                    $recordsTotal = 0;
                    $user_key = $this->getParam('user_key');
                    $erc721 = Utils::etherscanApiECR721($user_key);
                    foreach ($erc721->result as $obj){
                        $recordsTotal++;
                        array_push($data,array(
                            'hash' => $obj->hash,
                            'age' => date('d/m/Y H:i:s',$obj->timeStamp),
                            'from' => $obj->from,
                            'to' => $obj->to,
                            'tokenID' => $obj->tokenID,
                            'tokenName' => $obj->tokenName,
                            'tokenSymbol' => $obj->tokenSymbol,
                            'contractAddress' => $obj->contractAddress,
                            'value' => $obj->tokenDecimal,
                            'gas' => $obj->tokenDecimal,
                            'gasPrice' => $obj->gasPrice
                        ));
                    }
                    echo json_encode(array('data' => $data,'recordsTotal'=>$recordsTotal,'recordsFiltered'=>$recordsTotal));
                    exit();
                }
                elseif (__ROUTER_PATH == '/get-erc20') {
                    $data = array();
                    $recordsTotal = 0;
                    $user_key = $this->getParam('user_key');
                    $erc721 = Utils::etherscanApiECR20($user_key);
                    foreach ($erc721->result as $obj){
                        $recordsTotal++;
                        array_push($data,array(
                            'hash' => $obj->hash,
                            'age' => date('d/m/Y H:i:s',$obj->timeStamp),
                            'from' => $obj->from,
                            'to' => $obj->to,
                            'tokenName' => $obj->tokenName,
                            'tokenSymbol' => $obj->tokenSymbol,
                            'contractAddress' => $obj->contractAddress,
                            'value' => $obj->value,
                            'gas' => $obj->tokenDecimal,
                            'gasPrice' => $obj->gasPrice
                        ));
                    }
                    echo json_encode(array('data' => $data,'recordsTotal'=>$recordsTotal,'recordsFiltered'=>$recordsTotal));
                    exit();
                }
                elseif (__ROUTER_PATH == '/get-snapshot') {
                    $data = array();
                    $recordsTotal = 0;
                    $user_key = $this->getParam('user_key');
                    $graphql = Utils::snapshotApi($user_key);
                    foreach ($graphql->data->votes as $obj){
                        $recordsTotal++;
                        array_push($data,array(
                            'voter' => $obj->voter,
                            'proposal' => $obj->proposal->title,
                            'space' => $obj->space->id
                        ));
                    }
                    echo json_encode(array('data' => $data,'recordsTotal'=>$recordsTotal,'recordsFiltered'=>$recordsTotal));
                    exit();
                }
                elseif (__ROUTER_PATH == '/get-graphql') {
                    $data = array();
                    $user_key = $this->getParam('user_key');
                    $graphql = Utils::graphqlApi($user_key);
                    foreach ($graphql->data as $coin => $obj){
                        foreach ($obj->address as $balances => $values){
                            foreach ($values->balances as $index =>$val){
                                if($val->value > 0){
                                    array_push($data,array(
                                        'name' => $coin,
                                        'symbol' => $val->currency->symbol,
                                        'value' => $val->value
                                    ));
                                }
                            }
                        }
                    }
                    echo json_encode(array('success' => true,'data' => $data));
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