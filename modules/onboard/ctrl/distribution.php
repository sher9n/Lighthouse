<?php
use Core\Utils;
use lighthouse\Claim;
use lighthouse\Community;
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
                $claim = new Claim();
                $claim->wallet_adr = $wallet_address;
                $claim->ntts = $ntts;
                $claim->clm_reason  = $reason;
                $claim->clm_tags    = $tags;
                $claim->comunity_id = $community->id;
                $claim->insert();
                $_SESSION['lhc'] = null;

                echo json_encode(array('success' => true, 'url' => 'distribution'));
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
            $__page = (object)array(
                'title' => 'First Distribution',
                'community' => $community,
                'sections' => array(
                    __DIR__ . '/../tpl/section.distribution.php'
                ),
                'js' => array(
                    'https://unpkg.com/web3@1.2.11/dist/web3.min.js',
                    'https://unpkg.com/web3modal@1.9.0/dist/index.js',
                    'https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js',
                    'https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js',
                    app_cdn_path.'js/connect.js',
                    'https://assets.calendly.com/assets/external/widget.js'
                )
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>