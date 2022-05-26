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

        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            $domain = $site['sub_domain'];
            $claims = Claim::find("SELECT c.id,c.clm_tags,com.wallet_adr,com.id FROM claims c LEFT JOIN communities com ON c.comunity_id=com.id WHERE status=1 AND com.dao_domain='$domain'");

            $__page = (object)array(
                'title' => app_site,
                'site' => $site,
                'first_admin_view' => (isset($_SESSION['lh_admin_view']) && $_SESSION['lh_admin_view'] == 0 )?true:false,
                'claims' => $claims,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-dashboard.php'
                ),
                'js' => array(
                    'https://unpkg.com/feather-icons',
                    'https://cdn.datatables.net/1.12.0/js/jquery.dataTables.js',
                    'https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js',
                    'https://unpkg.com/web3@1.2.11/dist/web3.min.js',
                    'https://unpkg.com/web3modal@1.9.0/dist/index.js',
                    'https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js',
                    'https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js',
                    app_cdn_path.'js/connect.admin.js',
                    app_cdn_path.'js/connect-solana.admin.js',
                    'https://unpkg.com/@solana/web3.js@latest/lib/index.iife.js',
                    'https://assets.calendly.com/assets/external/widget.js'
                )
            );

            $_SESSION['lh_admin_view'] = 0;
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>