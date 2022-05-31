<?php
use lighthouse\Auth;
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

        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }
            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-integrations.php'
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