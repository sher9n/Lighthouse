<?php
use lighthouse\Auth;
use lighthouse\Community;
use lighthouse\Log;
use Core\AmazonS3;
use Core\Utils;
use lighthouse\Api;
class controller extends Ctrl {
    function init() {
        $is_admin = false;
        $sel_wallet_adr = null;
        $community = Community::getByDomain(app_site);
        $site = Auth::getSite();

        if(isset($_SESSION['lh_sel_wallet_adr'])) {
            $sel_wallet_adr = $_SESSION['lh_sel_wallet_adr'];
            $is_admin = $community->isAdmin($sel_wallet_adr);
        }
        else
        {
            header("Location: " . app_url.'admin');
            die();
        }

        if($site === false) {
            header("Location: https://lighthouse.xyz");
            die();
        }

        if($this->__lh_request->is_xmlHttpRequest) {

            if(__ROUTER_PATH == '/delete-claim-img' ) {
                if($this->hasParam('id')) {
                    $image_id = $this->getParam('id');
                    Community::deleteClaimImage($image_id);
                    echo json_encode(array('success' => true, 'id' => $image_id));
                }
                else
                    echo json_encode(array('success' => false, 'msg' => 'Invalid image'));
                exit();
            }
            elseif (__ROUTER_PATH == '/gas_tank_balance' ) {
                $balance = Api::getGasTankBalance(constant(strtoupper($community->blockchain).'_API'),app_site);
                if(is_null($balance))
                    $balance = 0;

                if($community->blockchain == SOLANA)
                    echo json_encode(array('success' => true, 'balance' => 'Ξ'.$balance.' SOL'));
                else
                    echo json_encode(array('success' => true, 'balance' => 'Ξ'.$balance.' (ERC-20)'));
                exit();
            }
            else {
                try {

                    if ($this->hasParam('dao_name') && strlen($this->getParam('dao_name')) > 0)
                        $community->dao_name = $this->getParam('dao_name');
                    else
                        throw new Exception("dao_name:Not a valid name");

                    $tick_change = $bg_change = false;
                    $html = '';

                    if ($this->hasParam('ticker_imag')) {
                        $ticker_imag = $this->getParam('ticker_imag');

                        if (!empty($ticker_imag) ) {
                            if (!Utils::isValidImageSize($ticker_imag->size))
                                throw new Exception("ticker_imag:Maximum image size exceeded. File size should be less then " . MAX_IMAGE_UPLOAD_SIZE );

                            if(pathinfo($ticker_imag->name, PATHINFO_EXTENSION) == 'jpeg' || pathinfo($ticker_imag->name, PATHINFO_EXTENSION) == 'jpg'){
                                $tick_change = true;
                                $img_name = time();
                                $amazons3 = new AmazonS3(app_site);
                                $t_url = $amazons3->uploadFile($ticker_imag->tmp_name, "ticker/token_image.jpeg");
                                $community->ticker_img_url = 'token_image.jpeg';
                            }
                            else
                                throw new Exception("ticker_imag:Invalid file extension. File extension should be jpeg");

                        }
                    }

                    /*$claim_images = array();
                    if ($this->hasParam('background_imag')) {
                        $images = $this->getParam('background_imag');
                        if (is_array($images)) {
                            foreach ($images as $index => $image) {
                                if (!empty($image)) {
                                    if (!Utils::isValidImageSize($image->size))
                                        throw new Exception("background_imag:Maximum image size exceeded. File size should be less then " . MAX_IMAGE_UPLOAD_SIZE . "mb.");

                                    $bg_change = true;
                                    $amazons3 = new AmazonS3(app_site);
                                    $img_name = time() . '-' . $index;
                                    $t_url = $amazons3->uploadFile($image->tmp_name, "communities/claim-" . $img_name . '.' . pathinfo($image->name, PATHINFO_EXTENSION));
                                    $url = 'instances/' . app_site . '/communities/claim-' . $img_name . '.' . pathinfo($image->name, PATHINFO_EXTENSION);
                                    array_push($claim_images, $url);
                                }
                            }
                        }
                    }

                    $i = 0;
                    foreach ($claim_images as $url) {
                        $i++;
                        Community::addClaimImages($community->id, $url);

                         $html.='<li class="upload-image-item" id="claim-img-'.$i.'">
                                <a class="image-del" href="delete-claim-img?id='.$i.'">
                                    <i data-feather="x"></i>
                                </a>
                                <img width="220" height="250" src="'.app_cdn_path.$url.'" class="rounded-3">
                            </li>';

                    }*/

                    $community->update();

                    $log = new Log();
                    $log->type = 'Community';
                    $log->type_id = $community->id;
                    $log->action = 'update-settings';
                    $log->c_by = $sel_wallet_adr;
                    $log->insert();

                    echo json_encode(array(
                        'success' => true,
                        'url' => 'admin-settings',
                        'tick_change' => $tick_change,
                        'ticket_img_url' => 'https://lighthouse-cdn.s3.amazonaws.com/instances/'.$community->dao_domain.'/ticker/token_image.jpeg',
                        'bg_change' => $bg_change,
                        'bg_img_html' => $html
                    ));

                } catch (Exception $e) {
                    $msg = explode(':', $e->getMessage());
                    $element = 'error-msg';
                    if (isset($msg[1])) {
                        $element = $msg[0];
                        if ($element == 'dao_name' || $element == 'ticker_imag' || $element == 'background_imag')
                            $msg = $msg[1];
                        else {
                            $msg = $e->getMessage();
                            echo json_encode(array('success' => false, 'msg' => $msg));
                            exit();
                        }
                    }

                    echo json_encode(array('success' => false, 'msg' => $msg, 'element' => $element));
                }
                exit();
            }
        }
        else {

            $__page = (object)array(
                'title' => $site['site_name'],
                'site' => $site,
                'is_admin' => $is_admin,
                'community' => $community,
                'blockchain' => $community->blockchain,
                'sel_wallet_adr' => $sel_wallet_adr,
                'sections' => array(
                    __DIR__ . '/../tpl/section.admin-settings.php'
                ),
                'js' => array()
            );
            require_once app_template_path . '/admin-base.php';
            exit();
        }
    }
}
?>