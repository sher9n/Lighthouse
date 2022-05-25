<?php
use lighthouse\Auth;
use lighthouse\Community;
class controller extends Ctrl {
    function init() {

        if(isset($_SESSION['lh_sel_wallet_adr']) && !is_null($this->__lh_request->get__PB())) {
            header("Location: " . $this->__lh_request->get__PB());
            exit();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/wallet-menu' ) {
                $selected_adr = $this->getParam('sel_add');
                $_SESSION['lh_sel_wallet_adr'] = $selected_adr;
                echo json_encode(array('success' => true));
                exit();
            }

        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            $_SESSION['lh_admin_view'] = 0;
            $com    = Community::getByDomain(app_site);
            $solana = false;

            if($com->blockchain == 'soalana')
                $solana = true;

            $__page = (object)array(
                'title' => app_site,
                'site' => $site,
                'solana' => $solana,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin.php'
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