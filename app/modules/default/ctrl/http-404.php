<?php
use lighthouse\Auth;
class controller extends Ctrl {
    public function init() {

        $site = Auth::getSite();

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