<?php
use lighthouse\Auth;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }
            $__page = (object)array(
                'title' => app_site,
                'site' => $site,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin.php'
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
                    'https://assets.calendly.com/assets/external/widget.js'
                )
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>