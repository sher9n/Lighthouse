<?php
use lighthouse\Auth;
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

        if($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/claim-status' && $this->getParam('claim_id')){
                $claim_id = $this->getParam('claim_id');
                $claim = Claim::get($claim_id);
                if($this->hasParam('status')) {
                    if($this->getParam('status') == 1)
                        $claim->status = 1;
                    else
                        $claim->status = 2;
                    $claim->update();
                    echo json_encode(array('success' => true));
                }
                else
                    echo json_encode(array('success' => false));
                exit();
            }
            elseif (__ROUTER_PATH == '/claim-details' && $this->getParam('claim_id')) {
                $claim_id = $this->getParam('claim_id');
                $claim = Claim::get($claim_id);
                include __DIR__ . '/../tpl/partial/claim_details.php';
                $html = ob_get_clean();
                echo json_encode(array('success' => true,'html'=>$html));
                exit();
            }
        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            $domain = $site['sub_domain'];
            $claims = Claim::find("SELECT c.id as c_id,c.clm_tags,c.c_at,com.wallet_adr,com.id as com_id FROM claims c LEFT JOIN communities com ON c.comunity_id=com.id WHERE status=0 AND com.dao_domain='$domain'");
            $a_claims = Claim::find("SELECT c.id as c_id,c.clm_tags,c.c_at,com.wallet_adr,com.id as com_id FROM claims c LEFT JOIN communities com ON c.comunity_id=com.id WHERE status=1 AND com.dao_domain='$domain'");

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'sel_wallet_adr' => $sel_wallet_adr,
                'claims' => $claims,
                'a_claims' => $a_claims,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-approvals.php'
                ),
                'js' => array(
                    'https://unpkg.com/feather-icons',
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