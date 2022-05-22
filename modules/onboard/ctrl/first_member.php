<?php
use Core\Utils;
use lighthouse\Community;
class controller extends Ctrl {
    function init() {

        if(app_site != 'app') {
            header("Location: " . app_url);
            die();
        }

        if (!isset($_SESSION['lhc']['d'])) {
            header("Location: " . app_url);
            die();
        }

        if ($this->__lh_request->is_xmlHttpRequest) {

        } else {
            $__page = (object)array(
                'title' => 'Fist Member',
                'dao_domain' => $_SESSION['lhc']['d'],
                'dao_name' => $_SESSION['lhc']['n'],
                'blockchain' => $_SESSION['lhc']['b'],
                'ticker' => $_SESSION['lhc']['t'],
                'sections' => array(
                    __DIR__ . '/../tpl/section.first_member.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>