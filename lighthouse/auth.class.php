<?php
namespace lighthouse;
use Core\Ds;
class Auth{

    public static function getSite() {

        if (isset($_SESSION['lighthouse']['site_name']) && isset($_SESSION['lighthouse']['site_domain'])) {
            if(app_site == $_SESSION['lighthouse']['site_domain']) {
                return array('sub_domain' => $_SESSION['lighthouse']['site_domain'], 'site_name' => $_SESSION['lighthouse']['site_name']);
            }
            else {
                $sub_domain =  \lighthouse\NTTs::isExistsNtts(app_site);
                if($sub_domain !== FALSE) {
                    $_SESSION['lighthouse']['site_name'] = $sub_domain['site_name'];
                    $_SESSION['lighthouse']['site_domain'] = $sub_domain['sub_domain'];
                    return array('sub_domain' => $_SESSION['lighthouse']['site_domain'], 'site_name' => $_SESSION['lighthouse']['site_name']);
                }
                else
                    return false;
            }
        }
        else {
            $sub_domain =  \lighthouse\NTTs::isExistsNtts(app_site);

            if($sub_domain !== FALSE) {
                $_SESSION['lighthouse']['site_name'] = $sub_domain['site_name'];
                $_SESSION['lighthouse']['site_domain'] = $sub_domain['sub_domain'];
                return array('sub_domain' => $_SESSION['lighthouse']['site_domain'], 'site_name' => $_SESSION['lighthouse']['site_name']);
            }
            else
                return false;
        }
    }
}
?>