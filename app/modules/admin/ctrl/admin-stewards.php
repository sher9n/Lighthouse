<?php
use lighthouse\Auth;
use lighthouse\Steward;
use lighthouse\Community;
use lighthouse\Log;
class controller extends Ctrl {
    function init() {
        $is_admin = false;
        $sel_wallet_adr = null;
        $community = Community::getByDomain(app_site);
        $community_id = $community->id;

        if(isset($_SESSION['lh_sel_wallet_adr']) && strlen($_SESSION['lh_sel_wallet_adr']) > 0) {
            $sel_wallet_adr = $_SESSION['lh_sel_wallet_adr'];
            $is_admin = $community->isAdmin($sel_wallet_adr);
        }
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </a>
                                </div>';

                    $c = $community->getStewards(true);
                    $percentage = '<div class="fs-1"><?php echo $__page->'.$community->approval_count.'</div><div class="fs-2">/'.$c.'</div>';
                    echo json_encode(array('success' => true, 'html' => $html,'percentage' => $percentage,'max' => $c));
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
                    if(Steward::deleteSteward($id,$adr,$community_id)) {
                        $c = $community->getStewards(true);
                        $percentage = '<div class="fs-1"><?php echo $__page->'.$community->approval_count.'</div><div class="fs-2">/'.$c.'</div>';
                        echo json_encode(array('success' => true, 'stew_id' => $id,'percentage' => $percentage,'max' => $c));
                    }
                    else
                        echo json_encode(array('success' => false));
                }
                else
                    echo json_encode(array('success' => false));
                exit();
            }
            elseif (__ROUTER_PATH == '/steward-percentage') {
                if($this->hasParam('range') && $this->getParam('range') > 0) {
                    $community->approval_count = $this->getParam('range');
                    $community->update();
                    $c = $community->getStewards(true);
                    $percentage = '<div class="fs-1"><?php echo $__page->'.$community->approval_count.'</div><div class="fs-2">/'.$c.'</div>';
                    echo json_encode(array('success' => true, 'percentage' => $percentage,'max' => $c));
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
                'is_admin' => $is_admin,
                'blockchain' => $community->blockchain,
                'stewards' => $community->getStewards(),
                'logo_url' => $community->getLogoImage(),
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