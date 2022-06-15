<?php
use lighthouse\Auth;
use lighthouse\Claim;
use lighthouse\Community;
use lighthouse\Api;
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
        $com = Community::getByDomain(app_site);

        if($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/claim-status' && $this->getParam('claim_id')){
                $claim_id = $this->getParam('claim_id');
                $claim = Claim::get($claim_id);

                if($this->hasParam('status')) {

                    if($this->getParam('status') != 1){
                        $claim->status = 2;
                        $claim->update();

                        $log = new Log();
                        $log->type = 'Claim';
                        $log->type_id = $claim->id;
                        $log->action = 'rejected';
                        $log->c_by = $sel_wallet_adr;
                        $log->insert();

                        echo json_encode(array('success' => true));
                        exit();
                    }

                    $ntts = 0;

                    if($this->hasParam('ntts'))
                        $ntts = floatval($this->getParam('ntts'));
                    else
                        throw new Exception("ntts:Not a valid NTTs");

                    if($com->blockchain == 'solana')
                        $api_response = api::solana_addPoints($claim->wallet_adr,$ntts);
                    else
                        $api_response = api::addPoints(constant(strtoupper($com->blockchain).'_API'),app_site,$claim->wallet_adr,$ntts);

                    if(isset($api_response->error)) {
                        echo json_encode(array('success' => false,'message' =>'Error! Your NTTs have not been sent. <a class="text-white ms-1" id="retryNewNtt" hre="#">RETRY</a>'));
                        exit();
                    }
                    else {

                        $reason = $this->hasParam('claim_reason') ? $this->getParam('claim_reason') : '';
                        $tags   = $this->hasParam('claim_tags') ? $this->getParam('claim_tags') : '';
                        $tags   = is_array($tags) ? implode(',', $tags) : '';
                        $claim->ntts = $ntts;
                        $claim->clm_reason = $reason;
                        $claim->clm_tags = $tags;
                        $claim->status = 1;
                        $claim->txHash = $api_response->txHash;
                        $claim->chainId = $api_response->chainId;
                        $claim->update();

                        $log = new Log();
                        $log->type = 'Claim';
                        $log->type_id = $claim->id;
                        $log->action = 'approved';
                        $log->c_by = $sel_wallet_adr;
                        $log->insert();

                        echo json_encode(array('success' => true, 'c_id' => $claim->id, 'message' => 'Success! Your NTTs have been sent. <a class="text-white ms-1" target="_blank" href="'.constant(strtoupper($com->blockchain).'_TX_LINK').$claim->txHash.'"> VIEW TRANSACTION</a>'));
                        exit();
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
                'blockchain' => $com->blockchain,
                'sel_wallet_adr' => $sel_wallet_adr,
                'claims' => $claims,
                'a_claims' => $a_claims,
                'all_claims' => $all_claims,
                'r_claims' => $r_claims,
                'claim_adrs' => $claim_adrs,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-approvals.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>