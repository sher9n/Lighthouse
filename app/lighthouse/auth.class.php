<?php
namespace lighthouse;
use Core\Ds;
class Auth{

    public static function getSite() {

        if (isset($_SESSION['lighthouse']['site_name']) && isset($_SESSION['lighthouse']['site_domain'])) {
            if(app_site == $_SESSION['lighthouse']['site_domain']) {
                return array('sub_domain' => $_SESSION['lighthouse']['site_domain'],
                    'site_name' => $_SESSION['lighthouse']['site_name'],
                    'blockchain' => $_SESSION['lighthouse']['blockchain']
                );
            }
            else {
                $sub_domain =  \lighthouse\Community::isExistsCommunity(app_site);
                if($sub_domain !== FALSE) {
                    $_SESSION['lighthouse']['site_name'] = $sub_domain['dao_name'];
                    $_SESSION['lighthouse']['site_domain'] = $sub_domain['dao_domain'];
                    $_SESSION['lighthouse']['blockchain'] = $sub_domain['blockchain'];

                    return array('sub_domain' => $sub_domain['dao_domain'],
                        'site_name' => $sub_domain['dao_name'],
                        'blockchain' => $sub_domain['blockchain'],
                        'ch' => $sub_domain['ch'],
                        'wallet_adr' => $sub_domain['wallet_adr']
                    );
                }
                else
                    return false;
            }
        }
        else {
            $sub_domain =  \lighthouse\Community::isExistsCommunity(app_site);

            if($sub_domain !== FALSE) {
                $_SESSION['lighthouse']['site_name'] = $sub_domain['dao_name'];
                $_SESSION['lighthouse']['site_domain'] = $sub_domain['dao_domain'];
                $_SESSION['lighthouse']['blockchain'] = $sub_domain['blockchain'];

                return array('sub_domain' => $sub_domain['dao_domain'],
                    'site_name' => $sub_domain['dao_name'],
                    'blockchain' => $sub_domain['blockchain'],
                    'ch' => $sub_domain['ch'],
                    'wallet_adr' => $sub_domain['wallet_adr']
                );
            }
            else
                return false;
        }
    }
}
?>