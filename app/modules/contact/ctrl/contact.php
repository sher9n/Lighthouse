<?php
use Core\Utils;
use lighthouse\Email;

class controller extends Ctrl {
    function init() {

        if(app_site != 'contact') {
            header("Location: " . app_url);
            die();
        }

        $gets = $_GET;
        unset($gets['route']);

        if(count($gets) > 0) {

            $get_string = '';
            foreach ($gets as $key => $val){
                $get_string .= '<p>'.$key.': '.$val.'</p>';
            }
            try {
                $email = new Email();
                $email->sender = 'admin+website+sender@lighthouse.xyz';
                $email->subject = 'Lighthouse contact';
                $email->data = '<p>You have a New GET request.</p>' .
                    '<p>You can reset your password by clicking the link below:</p>' .
                    $get_string.
                    '<p>Yours,</p>' .
                    '<p>Lighthouse.xyz</p>';

                $email->recipient = 'admin+website+sender@lighthouse.xyz';
                $email->send();
            } catch (\Exception $e) {
                var_dump($e->getMessage());
                return false;
            }
        }
    }
}
?>