<?php
use Core\AmazonS3;
use lighthouse\Community;
class controller extends Ctrl {
    public function init() {

        try {
            $community = Community::get(129);
            $community->addDefaultClaimImages(129);
            var_dump($community);
        }
        catch (Exception $e) {
            var_dump($e->getMessage());
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