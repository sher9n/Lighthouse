<?php
use Core\AmazonS3;
use lighthouse\Community;
use lighthouse\Form;
use lighthouse\Contribution;

class controller extends Ctrl {
    public function init() {

        $coms = Community::find("SELECT * FROM communities WHERE is_delete=0");

        foreach ($coms as $com){

        }
        exit();
        $__page = (object)array(
            'title' => 'Lighthouse',
            'session_user' => null,
            'sections' => array(
                __DIR__ . '/../tpl/section.404.php'
            ),
            'js' => array()
        );
        require_once app_template_path . '/public-base.php';
        exit();
    }
}

?>