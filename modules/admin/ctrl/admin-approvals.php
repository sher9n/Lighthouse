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

                    echo json_encode(array(
                        'success' => true,
                        'wallet_adr' => MINT_ADDRESS,
                        'to_wallet_adr' => $claim->wallet_adr,
                        'amount' => $claim->ntts,
                        'dao_domain' => app_site
                    ));
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
            $claim_adrs = array();
            $addresses = Claim::find("SELECT max(c.c_at) as date,c.wallet_adr FROM claims c LEFT JOIN communities com ON c.comunity_id=com.id WHERE com.dao_domain='$domain' GROUP BY wallet_adr");
            foreach ($addresses as $address)
                $claim_adrs[$address['wallet_adr']] = $address['date'];

            $claims = Claim::find("SELECT c.id as c_id,c.c_at,c.wallet_adr,com.id,c.ntts,com.ticker FROM claims c LEFT JOIN communities com ON c.comunity_id=com.id WHERE status=0 AND com.dao_domain='$domain'");
            $a_claims = Claim::find("SELECT c.id as c_id,c.c_at,c.wallet_adr,com.id,c.ntts,com.ticker FROM claims c LEFT JOIN communities com ON c.comunity_id=com.id WHERE status=1 AND com.dao_domain='$domain'");

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'sel_wallet_adr' => $sel_wallet_adr,
                'claims' => $claims,
                'a_claims' => $a_claims,
                'claim_adrs' => $claim_adrs,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-approvals.php'
                ),
                'js' => array(
                    app_cdn_path.'js/wallet.connect.admin.js',
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