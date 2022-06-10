<?php
use lighthouse\Auth;
use lighthouse\Steward;
use lighthouse\Community;
use lighthouse\Log;
class controller extends Ctrl {
    function init() {

        $sel_wallet_adr = null;

        if(isset($_SESSION['lh_sel_wallet_adr']))
            $sel_wallet_adr = $_SESSION['lh_sel_wallet_adr'];
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        $community = Community::getByDomain(app_site);
        $community_id = $community->id;

        if($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/add-stewards' ) {

                try {
                    $display_name = $wallet_address = '';

                    if ($this->hasParam('nickname') && strlen($this->getParam('nickname')) > 0)
                        $display_name = $this->getParam('nickname');
                    else
                        throw new Exception("nickname:Not a valid name");

                    if ($this->hasParam('wallet_address') && strlen($this->getParam('wallet_address')) > 0)
                        $wallet_address = $this->getParam('wallet_address');
                    else
                        throw new Exception("display_name:Please connect the wallet");

                    $steward = new Steward();
                    $steward->comunity_id = $community->id;
                    $steward->wallet_adr = $wallet_address;
                    $steward->display_name = $display_name;
                    $id = $steward->insert();

                    $log = new Log();
                    $log->type = 'Steward';
                    $log->type_id = $id;
                    $log->action = 'create';
                    $log->c_by = $wallet_address;
                    $log->insert();

                    $html = '<div class="stew-'.$id.' fw-medium mt-22">'.$display_name.'</div>
                                <div class="stew-'.$id.' d-flex align-items-center">
                                    <div class="fs-3 fw-semibold me-6">'.$wallet_address.'</div>
                                    <a class="del_steward" href="delete-stewards?id='.$id.'&adr='.$wallet_address.'" data-bs-toggle="modal" data-bs-target="#delMember">
                                        <i data-feather="trash" class="text-danger"></i>
                                    </a>
                                </div>';

                    echo json_encode(array('success' => true, 'html' => $html));
                } catch (Exception $e) {
                    $msg = explode(':', $e->getMessage());
                    $element = 'error-msg';
                    if (isset($msg[1])) {
                        $element = $msg[0];
                        $msg = $msg[1];
                    }
                    echo json_encode(array('success' => false, 'msg' => $msg, 'element' => $element));
                }
                exit();
            }
            elseif (__ROUTER_PATH == '/delete-stewards') {
                if($this->hasParam('id') && $this->hasParam('adr')) {
                    $id  = $this->getParam('id');
                    $adr = $this->getParam('adr');
                    if(Steward::deleteSteward($id,$adr,$community_id))
                        echo json_encode(array('success' => true,'stew_id' => $id));
                    else
                        echo json_encode(array('success' => false));
                }
                else
                    echo json_encode(array('success' => false));
                exit();
            }
        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'community' => $community,
                'blockchain' => $community->blockchain,
                'stewards' => Steward::find("SELECT * FROM stewards WHERE comunity_id=".$community_id." AND is_delete=0"),
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-stewards.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>