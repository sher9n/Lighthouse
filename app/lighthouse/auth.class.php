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

    public static function attemptLogin()
    {
        if(isset($_SESSION['lh_sel_wallet_adr']) && strlen($_SESSION['lh_sel_wallet_adr']) > 0)
            return $_SESSION['lh_sel_wallet_adr'];

        if(isset($_COOKIE['lighthouse']) && is_string($_COOKIE['lighthouse']))
        {
            $wallet = json_decode($_COOKIE['lighthouse'], true);

            if(isset($wallet['lh_sel_wallet_adr']) && strlen($wallet['lh_sel_wallet_adr']) > 0)
            {
                return $wallet['lh_sel_wallet_adr'];
            }
        }

        return false;
    }

    public static function setCookieWallet($wallet)
    {
        if(headers_sent()) return false;
        $_SESSION['lh_sel_wallet_adr'] = $wallet;
        $sessions = array('lh_sel_wallet_adr' => $wallet);
        $s = json_encode($sessions);
        return setcookie('lighthouse', $s, time()+60*60*24*1, '/', $_SERVER['HTTP_HOST']);
    }
}
?>