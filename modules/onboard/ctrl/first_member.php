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

            if(__ROUTER_PATH =='/update-contract-address'){
                $community = Community::get($_SESSION['lhc']['c_id']);
                $community->token_address = $this->getParam('token_address');
                $community->community_address = $this->getParam('community_address');
                $community->gas_address = $this->getParam('gas_address');
                $community->gas_private_key = $this->getParam('gas_private_key');
                $community->update();
                echo json_encode(array('success' => true));
                exit();
            }

            try {

                $display_name = $wallet_address = '';

                if($this->hasParam('display_name') && strlen($this->getParam('display_name')) > 0)
                    $display_name = $this->getParam('display_name');
                else
                    throw new Exception("display_name:Not a valid name");

                if($this->hasParam('wallet_address') && strlen($this->getParam('wallet_address')) > 0)
                    $wallet_address = $this->getParam('wallet_address');
                else
                    throw new Exception("display_name:Please connect the wallet");

                $dao_domain = $_SESSION['lhc']['d'];
                $domain_check = Community::isExistsCommunity($dao_domain);

                if ($domain_check === FALSE) {
                    $community = new Community();
                    $community->dao_name = $_SESSION['lhc']['n'];
                    $community->dao_domain = $_SESSION['lhc']['d'];
                    $community->blockchain = $_SESSION['lhc']['b'];
                    $community->ticker = $_SESSION['lhc']['t'];
                    $community->wallet_adr = $wallet_address;
                    $community->display_name = $display_name;
                    $id = $community->insert();
                    $_SESSION['lhc']['c_id'] = $id;

                    echo json_encode(array(
                            'success' => true,
                            'url' => 'distribution',
                            'wallet_adr' => $wallet_address,
                            'dao_name' => $community->dao_name,
                            'dao_domain' => $community->dao_domain,
                            'symbol' => 'nt'.$community->ticker,
                            'decimal' => 18,
                            'blockchain' => $community->blockchain
                        )
                    );
                }
                else {
                    $_SESSION['lhc'] = null;
                    echo json_encode(array('success' => true, 'url' => 'first-member'));
                }

            }
            catch (Exception $e)
            {
                $msg = explode(':',$e->getMessage());
                $element = 'error-msg';
                if(isset($msg[1])){
                    $element = $msg[0];
                    $msg = $msg[1];
                }
                echo json_encode(array('success' => false,'msg'=>$msg,'element'=>$element));
            }
            exit();
        } else {

            $solana = false;
            if($_SESSION['lhc']['b'] == 'solana')
                $solana = true;

            $__page = (object)array(
                'title' => 'Fist Member',
                'dao_domain' => $_SESSION['lhc']['d'],
                'dao_name' => $_SESSION['lhc']['n'],
                'blockchain' => $_SESSION['lhc']['b'],
                'ticker' => $_SESSION['lhc']['t'],
                'solana' => $solana,
                'sections' => array(
                    __DIR__ . '/../tpl/section.first_member.php'
                ),
                'js' => array(
                    'https://unpkg.com/web3@1.2.11/dist/web3.min.js',
                    'https://unpkg.com/web3modal@1.9.0/dist/index.js',
                    'https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js',
                    'https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js',
                    app_cdn_path.'js/connect.js',
                    app_cdn_path.'js/connect-solana.js',
                    'https://unpkg.com/@solana/web3.js@latest/lib/index.iife.js',
                )
            );
            require_once app_template_path . '/base.php';
            exit();
        }
    }
}
?>