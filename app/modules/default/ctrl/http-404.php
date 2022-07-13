<?php
use Core\AmazonS3;
use lighthouse\Community;
use lighthouse\Approval;

class controller extends Ctrl {
    public function init() {

        $approvals = Approval::find("SELECT * FROM approvals",true);
        foreach ($approvals as $approval){
            $app = json_decode($approval->approval);
            $approval->complexity = $app->complexity;
            $approval->importance = $app->importance;
            $approval->quality = $app->quality;
            $approval->update();
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