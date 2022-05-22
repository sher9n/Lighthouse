<?php
use Core\Utils;
use lighthouse\Community;
class controller extends Ctrl {
    function init() {

        if(app_site != 'app') {
            header("Location: " . app_url);
            die();
        }

        if ($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/check-dao-domain'){
                $subdomain = '';
                if($this->hasParam('dao_name')) {
                    $subdomain = $this->getParam('dao_name');
                    $subdomain = strtolower(preg_replace("/\s+/", "", $subdomain));

                    if (Community::isExistsCommunity($subdomain) === FALSE) {
                        echo json_encode(array('success' => true, 'sub_domain' =>$subdomain ));
                        exit();
                    }
                }

                echo json_encode(array('success' => false, 'sub_domain' =>$subdomain ,'msg' => "This name is already taken. Please try a different name.", 'element' => 'dao_domain'));
                exit();
            }
            else {

                try {

                    $dao_name = $dao_domain = $blockchain = $ticker = '';

                    if($this->hasParam('dao_name') && strlen($this->getParam('dao_name')) > 0)
                        $dao_name = $this->getParam('dao_name');
                    else
                        throw new Exception("dao_name:Not a valid dao name");

                    if($this->hasParam('blockchain') && strlen($this->getParam('blockchain')) > 0)
                        $blockchain = $this->getParam('blockchain');
                    else
                        throw new Exception("blockchain:Not a valid block chain");

                    if($this->hasParam('ticker') && strlen($this->getParam('ticker')) > 0)
                        $ticker = $this->getParam('ticker');
                    else
                        throw new Exception("ticker:Not a valid ticker");

                    if($this->hasParam('dao_domain') && strlen($this->getParam('dao_domain')) > 0) {
                        $dao_domain = $this->getParam('dao_domain');
                        $domain_check = Community::isExistsCommunity($dao_domain);

                        if ($domain_check === FALSE) {
                            $subdomain = strtolower(preg_replace("/\s+/", "", $dao_domain));
                            $_SESSION['lhc']['n'] = $dao_name;
                            $_SESSION['lhc']['d'] = $dao_domain;
                            $_SESSION['lhc']['b'] = $blockchain;
                            $_SESSION['lhc']['t'] = $ticker;

                            echo json_encode(array('success' => true, 'url' => 'first-member'));
                        }
                        else
                            echo json_encode(array('success' => false, 'msg' => "Duplicate or invalid subdomain", 'element' => 'dao_domain'));
                    }
                    else
                        throw new Exception("dao_domain:Not a valid dao domain");

                }
                catch (Exception $e)
                {
                    $msg = explode(':',$e->getMessage());
                    $element = 'error-msg';
                    if(isset($msg[1])){
                        $element = $msg[0];
                        $msg = $msg[1];
                    }
                    echo json_encode(array('success' => false,'msg'=>$msg,'element'=>$element));
                }
                exit();
            }
        } else {
            $__page = (object)array(
                'title' => 'Create NTTs',
                'sections' => array(
                    __DIR__ . '/../tpl/section.onboard.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/base.php';
            exit();
        }


    }
}
?>