<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Claim;
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

        $site = Auth::getSite();
        if($site === false) {
            header("Location: https://lighthouse.xyz");
            die();
        }
        $community = Community::getByDomain($site['sub_domain']);

        if($this->__lh_request->is_xmlHttpRequest) {

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
                $claim = new Claim();
                $claim->wallet_adr = $wallet_address;
                $claim->ntts = $ntts;
                $claim->clm_reason  = $reason;
                $claim->clm_tags    = $tags;
                $claim->status      = 1;
                $claim->admin_adr   = $sel_wallet_adr;
                $claim->comunity_id = $community->id;
                $claim->insert();

                echo json_encode(array(
                    'success' => true,
                    'url' => 'admin-ntts',
                    'wallet_adr' => MINT_ADDRESS,
                    'to_wallet_adr' => $claim->wallet_adr,
                    'amount' => $claim->ntts,
                    'dao_domain' => app_site
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
        }
        else {

            $solana = false;
            if($community->blockchain == 'solana')
                $solana = true;

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'solana' => $solana,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-ntts.php'
                ),
                'js' => array(
                    'https://unpkg.com/web3@1.2.11/dist/web3.min.js',
                    'https://unpkg.com/web3modal@1.9.0/dist/index.js',
                    'https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js',
                    'https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js',
                    app_cdn_path.'js/connect.admin.js',
                    app_cdn_path.'js/connect-solana.admin.js',
                    'https://unpkg.com/@solana/web3.js@latest/lib/index.iife.js'
                )
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>