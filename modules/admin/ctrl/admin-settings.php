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
            else {
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

                            $img_name = time();
                            $amazons3 = new AmazonS3(app_site);
                            $url = $amazons3->uploadFile($ticker_imag->tmp_name, "communities/ticker-" . $img_name . '.' . pathinfo($ticker_imag->name, PATHINFO_EXTENSION));
                            $community->ticker_img_url = 'ticker-' . $img_name . '.' . pathinfo($ticker_imag->name, PATHINFO_EXTENSION);
                        }
                    }

                    $claim_images = array();
                    if ($this->hasParam('background_imag')) {
                        $images = $this->getParam('background_imag');
                        if (is_array($images)) {
                            foreach ($images as $index => $image) {
                                if (!empty($image)) {
                                    if (!Utils::isValidImageSize($image->size))
                                        throw new Exception("background_imag:Maximum image size exceeded. File size should be less then " . MAX_IMAGE_UPLOAD_SIZE . "mb.");

                                    $amazons3 = new AmazonS3(app_site);
                                    $img_name = time() . '-' . $index;
                                    $url = $amazons3->uploadFile($image->tmp_name, "communities/claim-" . $img_name . '.' . pathinfo($image->name, PATHINFO_EXTENSION));
                                    $url = 'instances/' . app_site . '/communities/claim-' . $img_name . '.' . pathinfo($image->name, PATHINFO_EXTENSION);
                                    array_push($claim_images, $url);
                                }
                            }
                        }
                    }

                    foreach ($claim_images as $url) {
                        Community::addClaimImages($community->id, $url);
                    }

                    $community->update();
                    echo json_encode(array('success' => true, 'url' => 'admin-settings'));
                } catch (Exception $e) {
                    $msg = explode(':', $e->getMessage());
                    $element = 'error-msg';
                    if (isset($msg[1])) {
                        $element = $msg[0];
                        if ($element == 'dao_name' || $element == 'ticker_imag' || $element == 'background_imag')
                            $msg = $msg[1];
                        else
                            $msg = $e->getMessage();
                    }
                    echo json_encode(array('success' => false, 'msg' => $msg, 'element' => $element));
                }
                exit();
            }
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
                'js' => array(
                    'https://unpkg.com/feather-icons',
                    'https://unpkg.com/web3@1.2.11/dist/web3.min.js',
                    'https://unpkg.com/web3modal@1.9.0/dist/index.js',
                    'https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js',
                    'https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js',
                    app_cdn_path.'js/connect.admin.js',
                    app_cdn_path.'js/connect-solana.admin.js',
                    'https://unpkg.com/@solana/web3.js@latest/lib/index.iife.js'
                )
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>