<?php
use lighthouse\Auth;
use lighthouse\Steward;
use lighthouse\Proposal;
use lighthouse\Form;
class controller extends Ctrl {
    public function init() {

        $site = Auth::getSite();
        $stewars = Steward::find("SELECT * FROM stewards WHERE is_delete=0",true);
        foreach ($stewars as $steward) {
            if(strlen($steward->proposal_adr) > 0){
                $p = new Proposal();
                $p->wallet_adr = $steward->wallet_adr;
                $p->comunity_id = $steward->comunity_id;
                $p->proposal_adr = $steward->proposal_adr;
                $p->proposal_yes_count = $steward->proposal_yes_count;
                $p->proposal_type = $steward->proposal_type;
                $p->object = 'admin';
                $p->object_id = $steward->id;
                $p->insert();
            }
        }
exit();

        $__page = (object)array(
            'title' => 'Lighthouse',
            'site' => $site,
            'blockchain' => $site['blockchain'],
            'dao_name' => strtoupper($site['sub_domain']),
            'sections' => array(
                __DIR__ . '/../tpl/section.404.php'
            ),
            'js' => array( local_cdn_path.'js/web3/testing.js')
        );
        require_once app_template_path . '/base.php';
        exit();
    }
}

?>