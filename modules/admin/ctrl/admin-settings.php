<?php
use lighthouse\Auth;
use lighthouse\Community;
use Core\AmazonS3;
use Core\Utils;
class controller extends Ctrl {
    function init() {

        $sel_wallet_adr = null;

        $site = Auth::getSite();
        if($site === false) {
            header("Location: https://lighthouse.xyz");
            die();
        }

        if(isset($_SESSION['lh_sel_wallet_adr']))
            $sel_wallet_adr = $_SESSION['lh_sel_wallet_adr'];
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {
            try {
                $community = Community::getByDomain(app_site);

                if ($this->hasParam('dao_name') && strlen($this->getParam('dao_name')) > 0)
                    $community->dao_name = $this->getParam('dao_name');
                else
                    throw new Exception("dao_name:Not a valid name");

                if ($this->hasParam('ticker_imag')) {
                    $ticker_imag = $this->getParam('ticker_imag');
                    if (!empty($ticker_imag)) {
                        if (!Utils::isValidImageSize($ticker_imag->size))
                            throw new Exception("ticker_imag:Maximum image size exceeded. File size should be less then " . MAX_IMAGE_UPLOAD_SIZE . "mb.");

                        $amazons3 = new AmazonS3(app_site);
                        $url = $amazons3->uploadFile($ticker_imag->tmp_name, "communities/ticker." . pathinfo($ticker_imag->name, PATHINFO_EXTENSION));
                        $community->ticker_img_url = array('file' => 'ticker.' . pathinfo($ticker_imag->name, PATHINFO_EXTENSION));
                    }
                }

                $community->update();
                echo json_encode(array('success' => true));
            }
            catch (Exception $e)
            {
                $msg = explode(':',$e->getMessage());
                $element = 'error-msg';
                if(isset($msg[1])){
                    $element = $msg[0];
                    if($element == 'dao_name' || $element == 'ticker_imag'  || $element == 'background_imag')
                        $msg = $msg[1];
                    else
                        $msg = $e->getMessage();
                }
                echo json_encode(array('success' => false,'msg'=>$msg,'element'=>$element));
            }
            exit();
        }
        else {



            $community = Community::getByDomain($site['sub_domain']);

            $__page = (object)array(
                'title' => app_site,
                'site' => $site,
                'community' => $community,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-settings.php'
                ),
                'js' => array('https://unpkg.com/feather-icons')
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>