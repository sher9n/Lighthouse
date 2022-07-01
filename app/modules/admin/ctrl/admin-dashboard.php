<?php
use lighthouse\Auth;
use lighthouse\Claim;
use lighthouse\Community;
use lighthouse\Contribution;
use Core\Utils;
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

            if( __ROUTER_PATH == '/get-ntts'){

                $claim_table = $rank_table = array();
                $total = 0;
                $com_id = $community->id;
                $domain = app_site;
/*                $claims = Claim::find("SELECT GROUP_CONCAT(IF(c.status='1', c.clm_tags,null)) as tags ,c.wallet_adr,sum(c.ntts) as score FROM claims c LEFT JOIN communities com ON c.comunity_id=com.id WHERE c.status='1' AND com.dao_domain='$domain' group by c.wallet_adr");
                $ranks  = Claim::find("SELECT wallet_adr,sum(ntts) as ntts FROM lighthouse.claims WHERE comunity_id='$com_id' AND status=1 group by wallet_adr order by ntts DESC");*/

                $claims = Claim::find("SELECT wallet_to,sum(score) as score FROM contributions WHERE status=1 AND comunity_id='$com_id' group by wallet_to");
                $ranks  = Claim::find("SELECT wallet_to,sum(score) as ntts FROM contributions WHERE comunity_id='$com_id' AND status=1 group by wallet_to order by ntts DESC");

                $rank_index = 0;
                foreach ($ranks as $rank) {
                    $rank_index++;
                    $rank_table[$rank['wallet_to']] = array('rank' => $rank_index,'sum' => $rank['ntts'])  ;
                    $total += $rank['ntts'];
                }

                foreach ($claims as $claim) {
/*                    $tags = explode(',', $claim['tags']);
                    $tem_tags = array();
                    foreach ($tags as $tag) {
                        if(strlen($tag) > 0) {
                            $tag = ucfirst($tag);
                            if (isset($tem_tags[$tag]))
                                $tem_tags[$tag] += 1;
                            else
                                $tem_tags[$tag] = 1;
                        }
                    }*/
                    $tag_string = array();
/*                    foreach ($tem_tags as $key => $c)
                        array_push($tag_string , $key.':'.$c);*/

                    $wallet_adr = $claim['wallet_to'];
                    $r = $p = '-';
                    if(isset($rank_table[$wallet_adr])){
                        $r = $rank_table[$wallet_adr]['rank'];
                        if($total > 0)
                            $p = number_format((($rank_table[$wallet_adr]['sum'] / $total) * 100),2).'%';
                        else
                            $p = 0;
                    }


                    $claim_table[] = array(
                        '<a data-adr="' . $wallet_adr . '" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" href="#" class="text-center d-block contribution_history">'.Utils::WalletAddressFormat($wallet_adr).'</a>',
                        $claim['score'],
                        $r,
                        $p,
                        '<div class="text-truncate text-max-width">' . implode(', ', $tag_string) . '</div>'
                    );


                }

                $recordsTotal = count($claim_table);
                echo json_encode(array('data' => $claim_table,'recordsTotal'=>$recordsTotal,'recordsFiltered'=>$recordsTotal));
                exit();
            }
            elseif (__ROUTER_PATH =='/contribution-history') {
                $wallet = $this->getParam('wallet');
                $contributions = Contribution::find("SELECT c.contribution_reason,c.c_at,c.score,f.form_title FROM contributions c LEFT JOIN forms f ON c.form_id=f.id where c.status=1 AND c.wallet_to='$wallet'");
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
                'blockchain' => $community->blockchain,
                'sel_wallet_adr' => $sel_wallet_adr,
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