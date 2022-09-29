<?php
use lighthouse\Auth;
use lighthouse\Claim;
use lighthouse\Community;
use lighthouse\Contribution;
use Core\Utils;
class controller extends Ctrl {
    function init() {
        $is_admin       = false;
        $sel_wallet_adr = $wallet_adr = null;
        $community      = Community::getByDomain(app_site);
        $login          = Auth::attemptLogin();

        if($login != false) {
            $sel_wallet_adr = $login;
            $is_admin       = $community->isAdmin($sel_wallet_adr);
        }
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            if( __ROUTER_PATH == '/get-ntts'){

                $claim_table = $rank_table = array();
                $total = 0;
                $length = $this->hasParam('length')?$this->getParam('length'):10;
                $start  = $this->hasParam('start')?$this->getParam('start'):0;
                $com_id = $community->id;

                if($this->hasParam('search')){
                    $search = $this->getParam('search');
                    $search = $search['value'];
                    $claims = Claim::find("SELECT wallet_to,sum(score) as score FROM contributions WHERE status=1 AND comunity_id='$com_id' AND wallet_to LIKE '%$search%' group by wallet_to LIMIT $start, $length");
                }
                else
                    $claims = Claim::find("SELECT wallet_to,sum(score) as score FROM contributions WHERE status=1 AND comunity_id='$com_id' group by wallet_to LIMIT $start, $length");

                $ranks  = Claim::find("SELECT wallet_to,sum(score) as ntts FROM contributions WHERE comunity_id='$com_id' AND status=1 group by wallet_to order by ntts DESC");

                $rank_index = 0;
                foreach ($ranks as $rank) {
                    $rank_index++;
                    $rank_table[$rank['wallet_to']] = array('rank' => $rank_index,'sum' => $rank['ntts'])  ;
                    $total += $rank['ntts'];
                }

                $wallets  = array();
                $tem_tags = array();
                foreach ($claims as $clm)
                    array_push($wallets,$clm['wallet_to']);

                if(count($wallets) > 0) {
                    $wallets_sql = implode("','",$wallets);
                    $wallets_sql = "('".$wallets_sql."')";
                    $tags_data = Claim::find("SELECT tags,wallet_to FROM contributions WHERE status=1 AND comunity_id='1' AND wallet_to IN ".$wallets_sql);
                    foreach ($tags_data as $data){
                        $tag = $data['tags'];
                        $wal = $data['wallet_to'];
                        if(strlen($tag) > 0) {
                            $tag = ucfirst($tag);
                            if (isset($tem_tags[$wal])) {
                                if(isset($tem_tags[$wal][$tag]))
                                    $tem_tags[$wal][$tag] += 1;
                                else
                                    $tem_tags[$wal][$tag] = 1;
                            }
                            else {
                                $tem_tags[$wal][$tag] = 1 ;
                            }
                        }
                    }
                }

                foreach ($claims as $claim) {
                    $wallet_adr = $claim['wallet_to'];
                    $tag_string = array();

                    if(isset($tem_tags[$wallet_adr])) {
                        $wallet_tags = $tem_tags[$wallet_adr];

                        foreach ($wallet_tags as $key => $c)
                            array_push($tag_string, $key . ':' . $c);
                    }

                    $r = $p = '-';
                    if(isset($rank_table[$wallet_adr])){
                        $r = $rank_table[$wallet_adr]['rank'];
                        if($total > 0)
                            $p = number_format((($rank_table[$wallet_adr]['sum'] / $total) * 100),2).'%';
                        else
                            $p = 0;
                    }

                    $claim_table[] = array(
                        '<a data-adr="' . $wallet_adr . '" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" href="#" class="text-decoration-none contribution_history">'.Utils::WalletAddressFormat($wallet_adr).'</a>',
                        'N/A',
                        'N/A',
                        'N/A',
                        '<div class="text-truncate text-max-width">' . implode(', ', $tag_string) . '</div>'
                    );
                }

                $recordsTotal = count($claim_table);
                echo json_encode(array("draw" => $this->hasParam('draw')?$this->getParam('draw'):1, 'data' => $claim_table,'recordsTotal'=>1000,'recordsFiltered'=>1000));
                exit();
            }
            elseif (__ROUTER_PATH =='/contribution-history') {
                $wallet = $this->getParam('wallet');
                $com_id = $community->id;
                $contributions = Contribution::find("SELECT c.contribution_reason,c.c_at,c.score,c.is_realms,c.realms_status,c.form_id,f.form_title FROM contributions c LEFT JOIN forms f ON c.form_id=f.id where c.comunity_id='$com_id' AND c.status=1 AND c.wallet_to='$wallet'");
                include __DIR__ . '/../tpl/partial/contribution_history.php';
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

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'ticker' => $community->ticker,
                'is_admin' => $is_admin,
                'blockchain' => $community->blockchain,
                'logo_url' => $community->getLogoImage(),
                'sel_wallet_adr' => $sel_wallet_adr,
                'user' => \lighthouse\User::isExistUser($sel_wallet_adr,$community->id),
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-dashboard.php'
                ),
                'js' => array()
            );

            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>