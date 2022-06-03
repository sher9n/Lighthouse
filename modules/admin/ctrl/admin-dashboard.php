<?php
use lighthouse\Auth;
use lighthouse\Claim;
use lighthouse\Community;
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

        $community = Community::getByDomain(app_site);

        if($this->__lh_request->is_xmlHttpRequest) {

        }
        else {

            $site = Auth::getSite();
            if($site === false) {
                header("Location: https://lighthouse.xyz");
                die();
            }

            $claim_table = array();
            $domain = $site['sub_domain'];
            $claims = Claim::find("SELECT GROUP_CONCAT(IF(c.status='1', c.clm_tags,null)) as tags ,c.wallet_adr,sum(c.ntts) as score FROM claims c LEFT JOIN communities com ON c.comunity_id=com.id WHERE c.status='1' AND com.dao_domain='$domain' group by c.wallet_adr");
            foreach ($claims as $claim) {

                    $tags = explode(',', $claim['tags']);
                    $tem_tags = array();
                    foreach ($tags as $tag) {
                        if(strlen($tag) > 0) {
                            if (isset($tem_tags[$tag]))
                                $tem_tags[$tag] += 1;
                            else
                                $tem_tags[$tag] = 1;
                        }
                    }
                    $tag_string = array();
                    foreach ($tem_tags as $key => $c)
                        array_push($tag_string , $key.':'.$c);

                    $claim_table[] = array(
                        'tags' => implode(', ',$tag_string),
                        'adr' => $claim['wallet_adr'],
                        'score' =>  $claim['score'],
                        'perc' => 0
                    );

            }

            $solana = false;
            if($community->blockchain == 'solana')
                $solana = true;

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'claims' => $claim_table,
                'solana' => $solana,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-dashboard.php'
                ),
                'js' => array(
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

            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>