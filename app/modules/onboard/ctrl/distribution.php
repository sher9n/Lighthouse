<?php
use Core\Utils;
use lighthouse\Claim;
use lighthouse\Community;
use lighthouse\Api;
class controller extends Ctrl {
    function init() {

        $community = null;

        if (!isset($_SESSION['lhc']['c_id'])) {
            header("Location: " . app_url);
            die();
        }
        else
            $community = Community::get($_SESSION['lhc']['c_id']);

        if(app_site != 'app' || !$community instanceof Community) {
            header("Location: " . app_url);
            die();
        }

        if ($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/skip-onboard'){
                $_SESSION['lhc'] = null;
                echo json_encode(array('success' => true));
                exit();
            }

            try {

                $wallet_address = $ntts = null;

                if($this->hasParam('wallet_address') && strlen($this->getParam('wallet_address')) > 0)
                    $wallet_address = $this->getParam('wallet_address');
                else
                    throw new Exception("sel_wallet_address:Please connect the wallet");

                if($this->hasParam('ntts'))
                    $ntts = floatval($this->getParam('ntts'));
                else
                    throw new Exception("ntts:Not a valid NTTs");

                $reason = $this->hasParam('claim_reason')?$this->getParam('claim_reason'):'';
                $tags  = $this->hasParam('claim_tags')?$this->getParam('claim_tags'):'';
                $tags  = is_array($tags)?implode(',',$tags):'';

                if($community->blockchain == 'solana')
                    $api_response = api::solana_addPoints($wallet_address,$ntts);
                else
                    $api_response = api::gnosis_addPoints($community->dao_domain,$wallet_address,$ntts);

                if(isset($api_response->error)) {
                    echo json_encode(array('success' => false,'msg' =>'Your NTTs have not been sent','element' => 'wallet_address'));
                    exit();
                }
                else {

                    $claim = new Claim();
                    $claim->wallet_adr = $wallet_address;
                    $claim->ntts = $ntts;
                    $claim->clm_reason = $reason;
                    $claim->clm_tags = $tags;
                    $claim->comunity_id = $community->id;
                    $claim->status = 1;
                    $claim->txHash = $api_response->txHash;
                    $claim->chainId = $api_response->chainId;
                    $claim->insert();
                    $_SESSION['lhc'] = null;

                }

                echo json_encode(array(
                    'success' => true,
                    'url' => 'distribution',
                    'txHash' => $api_response->txHash
                ));
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
        } else {

            $solana = false;
            if($_SESSION['lhc']['b'] == 'solana')
                $solana = true;

            $__page = (object)array(
                'title' => 'First Distribution',
                'community' => $community,
                'solana' => $solana,
                'admin_page' => 'http://'.$community->dao_domain.'.lighthouse.xyz/admin',
                'claim_page' => 'http://'.$community->dao_domain.'.lighthouse.xyz',
                'sections' => array(
                    __DIR__ . '/../tpl/section.distribution.php'
                ),
                'js' => array(
                    app_cdn_path.'js/wallet.connect.js',
                    app_cdn_path.'js/connect-solana.js',
                    'https://unpkg.com/@solana/web3.js@latest/lib/index.iife.js',
                    'https://assets.calendly.com/assets/external/widget.js'
                )
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>