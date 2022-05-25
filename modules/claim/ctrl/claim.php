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

            $com = Community::getByDomain($site['sub_domain']);
            $image = $com->getClaimImages(true);
            $img_url = $image['claim_image_url'];

            $__page = (object)array(
                'title' => app_site,
                'site' => $site,
                'img_url' => $img_url ,
                'sections' => array(
                    __DIR__ . '/../tpl/section.claim.php'
                ),
                'js' => array(
                    'https://unpkg.com/web3@1.2.11/dist/web3.min.js',
                    'https://unpkg.com/web3modal@1.9.0/dist/index.js',
                    'https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js',
                    'https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js',
                    app_cdn_path.'js/connect.claim.js',
                    'https://assets.calendly.com/assets/external/widget.js'
                )
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>