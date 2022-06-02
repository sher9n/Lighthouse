<?php
use lighthouse\Auth;
use lighthouse\Claim;
use lighthouse\Community;
class controller extends Ctrl {
    function init() {
        $claim = null;
        if($this->hasParam('id'))
            $claim = Claim::get($this->getParam('id'));

        if(!$claim instanceof Claim){
            header("Location: " . app_url);
            die();
        }

        $com    = Community::getByDomain(app_site);
        $site   = Auth::getSite();
        $solana = false;
        if($com->blockchain == 'solana')
            $solana = true;

        if($site === false) {
            header("Location: https://lighthouse.xyz");
            die();
        }

        $__page = (object)array(
            'title' => app_site,
            'site' => $site,
            'solana' => $solana,
            'claim' => $claim,
            'sections' => array(
                __DIR__ . '/../tpl/section.claim-success.php'
            ),
            'js' => array()
        );
        require_once app_template_path . '/base.php';
        exit();

    }
}
?>