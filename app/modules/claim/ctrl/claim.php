<?php
use lighthouse\Claim;
use lighthouse\Community;
use lighthouse\Auth;
class controller extends Ctrl {
    function init() {

        if(app_site == 'app') {
            header("Location: " . app_url);
            die();
        }

        $site = Auth::getSite();
        if($site === false) {
            header("Location: https://lighthouse.xyz");
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {
            try {

                $wallet_address = $ntts = null;

                if($this->hasParam('wallet_address') && strlen($this->getParam('wallet_address')) > 0)
                    $wallet_address = $this->getParam('wallet_address');
                else
                    throw new Exception("w_addr_text:Please connect the wallet");

                if($this->hasParam('ntts'))
                    $ntts = floatval($this->getParam('ntts'));
                else
                    throw new Exception("ntts:Not a valid NTTs");

                $com = Community::getByDomain($site['sub_domain']);
                $claim = new Claim();
                $claim->wallet_adr = $wallet_address;
                $claim->ntts = $ntts;
                $claim->comunity_id = $com->id;
                $id = $claim->insert();
                $_SESSION['lh_claim_id'] = $id;

                echo json_encode(array('success' => true, 'url' => 'claim-reason'));
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
        else {

            $com    = Community::getByDomain($site['sub_domain']);
            $image  = $com->getClaimImages(true);
            $img_url= $image['claim_image_url'];

            $solana = false;
            if($com->blockchain == 'solana')
                $solana = true;

            $__page = (object)array(
                'title' => app_site,
                'solana' => $solana,
                'blockchain' => $com->blockchain,
                'site' => $site,
                'img_url' => $img_url ,
                'sections' => array(
                    __DIR__ . '/../tpl/section.claim.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/claim-base.php';
            exit();
        }
    }
}
?>