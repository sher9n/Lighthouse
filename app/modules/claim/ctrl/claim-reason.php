<?php
use lighthouse\Auth;
use lighthouse\Claim;
use lighthouse\Community;
class controller extends Ctrl {
    function init() {

        if (!isset($_SESSION['lh_claim_id'])) {
            header("Location: " . app_url);
            die();
        }
        else
            $claim = Claim::get($_SESSION['lh_claim_id']);

        $site = Auth::getSite();
        if($site === false || !$claim instanceof Claim) {
            header("Location: ".app_url);
            die();
        }
        $com = Community::getByDomain($site['sub_domain']);

        if($this->__lh_request->is_xmlHttpRequest) {
            try {

                $reason = $tags = null;

                if($this->hasParam('claim_reason') && strlen($this->getParam('claim_reason')) > 0)
                    $reason = $this->getParam('claim_reason');
                else
                    throw new Exception("claim_reason:Not a valid dao reason");

                if($this->hasParam('claim_tags') && count($this->getParam('claim_tags')) > 0)
                    $tags = $this->getParam('claim_tags');
                else
                    throw new Exception("claim_tags:Not a valid dao tags");

                $tags  = is_array($tags)?implode(',',$tags):'';
                $claim->clm_reason  = $reason;
                $claim->clm_tags    = $tags;
                $claim->m_at        = date("Y-m-d H:i:s");;
                $claim->update();
                $_SESSION['lh_claim_id'] = null;

                echo json_encode(array(
                    'success' => true,
                    'is_admin' => $com->isAdmin($claim->wallet_adr),
                    'url' => 'claim',
                    'claim_id' => $claim->id,
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

            $image = $com->getClaimImages(true);
            $img_url = $image['claim_image_url'];

            $solana = false;
            if($com->blockchain == 'solana')
                $solana = true;

            $__page = (object)array(
                'title' => app_site,
                'site' => $site,
                'solana' => $solana,
                'blockchain' => $com->blockchain,
                'is_admin' => $com->isAdmin($claim->wallet_adr),
                'img_url' => $img_url ,
                'claim' => $claim,
                'sections' => array(
                    __DIR__ . '/../tpl/section.claim-reason.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/claim-base.php';
            exit();
        }
    }
}
?>