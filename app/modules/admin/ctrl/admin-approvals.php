<?php
use lighthouse\Auth;
use lighthouse\Claim;
use lighthouse\Community;
use lighthouse\Api;
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
        $com = Community::getByDomain(app_site);

        if($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/claim-status' && $this->getParam('claim_id')){
                $claim_id = $this->getParam('claim_id');
                $claim = Claim::get($claim_id);
                if($this->hasParam('status')) {

                    if($com->blockchain == 'solana')
                        $api_response = api::solana_addPoints($claim->wallet_adr,$claim->ntts);
                    else
                        $api_response = api::gnosis_addPoints(app_site,$claim->wallet_adr,$claim->ntts);

                    if(isset($api_response->error)) {
                        echo json_encode(array('success' => false,'message' =>'Error! Your NTTs have not been sent. <a id="retryNewNtt" hre="#">RETRY</a>'));
                        exit();
                    }
                    else {

                        if($this->getParam('status') == 1)
                            $claim->status = 1;
                        else
                            $claim->status = 2;

                        $claim->txHash = $api_response->txHash;
                        $claim->chainId = $api_response->chainId;
                        $claim->update();

                        echo json_encode(array('success' => true, 'message' => 'Success! Your NTTs have been sent. <a target="_blank" href="'.KOVAN_OPT_LINK.$claim->txHash.'"> VIEW TRANSACTION</a>'));
                    }
                }
                else
                    echo json_encode(array('success' => false,'message' => 'Error! Something went wrong.'));
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

           $all_claims = Claim::find("SELECT c.id as c_id,c.c_at,c.wallet_adr,com.id,c.ntts,com.ticker,c.status FROM claims c LEFT JOIN communities com ON c.comunity_id=com.id WHERE com.dao_domain='$domain'");
           $claims = $a_claims = $r_claims = array();
           foreach ($all_claims as $claim){
               if($claim['status'] == 0)
                   array_push($claims,$claim);
               elseif ($claim['status'] == 1)
                   array_push($a_claims,$claim);
               else
                   array_push($r_claims,$claim);
           }

            $solana = false;
            if($com->blockchain == 'solana')
                $solana = true;

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'solana' => $solana,
                'sel_wallet_adr' => $sel_wallet_adr,
                'claims' => $claims,
                'a_claims' => $a_claims,
                'all_claims' => $all_claims,
                'r_claims' => $r_claims,
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