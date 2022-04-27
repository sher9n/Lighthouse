<?php
use Core\Utils;
class controller extends Ctrl {
    function init() {

        if($this->__lh_request->is_xmlHttpRequest) {

            switch (__ROUTER_PATH) {
                case '/get-coins':
                    $data     = array();
                    $success  = false;
                    $search   = '';

                    $user_key = $this->hasParam('user_key')?$this->getParam('user_key'):'';
                   // $user_key = '0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507';
                    $p        = $this->hasParam('p')?$this->getParam('p'):0;

                    if($this->hasParam('search') && strlen($this->getParam('search')) > 0) {
                        $search = $this->getParam('search');
                        $response = Utils::LightHouseApi("coins?address=$user_key&page=$p&search=$search");
                    }
                    else
                        $response = Utils::LightHouseApi("coins?address=$user_key&page=$p");

                    $html = '';
                    if($p == 0 && $this->hasParam('search') && strlen(trim($search))== 0) {
                        $html = '<li class="list-community-item active">
                                    <div class="d-flex align-items-center">
                                        <a class="coin_details" data-n="Overall stats" data-l="'.app_cdn_path.'img/company-overall.png" href="#">
                                            <div class="d-flex align-items-center">
                                                <div class="avator d-flex justify-content-center align-items-center me-5">
                                                    <img src="'.app_cdn_path.'img/company-overall.png" class="rounded-circle bg-white" width="48" height="48" />
                                                </div>
                                                <div class="w-70">
                                                    <div class="fs-3 text-truncate">Overall Stats</div>
                                                    <div class="text-muted lh-1">Aggregate</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li class="list-community-item">
                                    <div class="d-flex align-items-center">
                                        <a class="coin_details" data-n="Lighthouse DAO" data-l=""'.app_cdn_path.'img/company-lighthouse.png" href="#">
                                            <div class="d-flex align-items-center">
                                                <div class="avator d-flex justify-content-center align-items-center me-5">
                                                    <img src="'.app_cdn_path.'img/company-lighthouse.png" class="rounded-circle bg-white" width="48" height="48" />
                                                </div>
                                                <div class="w-70">
                                                    <div class="fs-3 text-truncate">Lighthouse DAO</div>
                                                    <div class="text-muted lh-1">Reputation</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </li>' ;
                    }

                    if($response['status'] == 200) {
                        $success = true;
                        $coins = $response['data'];
                        include __DIR__ . '/../tpl/partial/list_items.php';
                        $html .= ob_get_clean();
                    }

                    echo json_encode(array('success' => $success,'lines' => $html));
                    exit();
                    break;

                case '/update-user':
                    $html = '';
                    $adds = $this->getParam('adds');
                    $wallet_adr = $this->getParam('sel_add');
                    $adds = implode(",",$adds);
                    $points = 0;

                    if(strlen($this->getParam('del_wallet_adr')) > 0) {
                        $del_wallet_adr = $this->getParam('del_wallet_adr');
                        $response = Utils::LightHouseApi("user-update",array('address' =>$adds,'wallet_adr' => $wallet_adr,'del_wallet_adr' => $del_wallet_adr));
                    }
                    else
                        $response = Utils::LightHouseApi("user-update",array('address' =>$adds,'wallet_adr' => $wallet_adr));

                    if($response['status'] == 200 && isset($response['data'])) {
                        $adds   = $response['data']['wallet_ids'];
                        $points = $response['data']['points'];
                    }

                    echo json_encode(array('success' => true,'adds' => $adds,'points' => $points));
                    exit();
                    break;

                case '/wallet-menu':

                    $html = '';
                    $adds = $this->getParam('adds');
                    include __DIR__ . '/../tpl/partial/wallet_addresses.php';
                    $html = ob_get_clean();
                    $adds = implode(",",$adds);
                    echo json_encode(array('success' => true,'html' => $html));
                    exit();
                    break;

                case '/notify':
                    $email = $this->getParam('email');
                    $user_key = $this->hasParam('user_key')?$this->getParam('user_key'):'';
                    $response = Utils::LightHouseApi("notify",array('email' =>$email,'wallet_address' => $user_key));
                    echo json_encode(array('success' => true));
                    exit();
                    break;

                case  '/pin-coin':
                    if($this->hasParam('user_key') && strlen($this->getParam('user_key')) > 0)
                        $user_key = $this->getParam('user_key');
                    else {
                        echo json_encode(array('success' => false));
                        exit();
                    }
                    $action   = 'pin';
                    $coin_id  = $href = '';

                    if($this->hasParam('unpin')) {
                        $action = 'unpin';
                        $coin_id = $this->getParam('unpin');
                        $response = Utils::LightHouseApi("pin-coin?address=$user_key&coin=$coin_id&action=unpin");
                        $href = 'pin-coin?user_key='.$user_key.'&pin='.$coin_id;
                    }
                    elseif ($this->hasParam('pin')) {
                        $coin_id = $this->getParam('pin');
                        $response = Utils::LightHouseApi("pin-coin?address=$user_key&coin=$coin_id&action=pin");
                        $href = 'pin-coin?user_key='.$user_key.'&unpin='.$coin_id;
                    }

                    if($response['status'] == 200)
                        echo json_encode(array('success' => true,'action' =>$action,'href' => $href));
                    else
                        echo json_encode(array('success' => false));
                    exit();
                    break;

                case  '/get-tweets':
                case  '/get-mentions':
                    $tw_user_name = '';
                    $c_logo       = '';
                    $c_name       = '';
                    $type = (__ROUTER_PATH =='/get-tweets')?'Tweeted':'Mentions';
                    if($this->hasParam('t') && strlen($this->getParam('t')) > 0) {
                        $tw_user_name = $this->getParam('t');
                        $c_logo = $this->getParam('l');
                        $c_name = $this->getParam('n');
                        //$tw_user_name = '0xSheran';
                    }
                    else {
                        echo json_encode(array(
                            'success' => true,
                            'updates' => '<div class="card-body text-center">
                                <img src="'.app_cdn_path.'img/img-myactivity.png" class="img-fluid rounded mt-16" alt=""/>
                                <div class="fs-1 fw-semibold mt-12">No contributions yet!</div>
                                <div class="fs-5  mt-5 text-center">Post an article link or announcement <br>
                                    from a DAO to start contributing</div>
                                <button type="button" class="btn btn-primary btn-lg px-25 text-uppercase mt-23 mb-18">Post Now</button>
                            </div>'));
                        exit();
                    }

                    $respose = Utils::getTweet((__ROUTER_PATH =='/get-tweets')?'tweets':'mentions',$tw_user_name);
                    //referenced_tweets
                    include __DIR__ . '/../tpl/partial/twiter_updates.php';
                    $html = ob_get_clean();
                    echo json_encode(array('success' => true,'updates' => $html));
                    exit();

                case  '/get-profile':
                    $coin_id = '';
                    if($this->hasParam('id') && strlen($this->getParam('id')) > 0) {
                        $coin_id = $this->getParam('id');
                    }
                    else {
                        echo json_encode(array(
                            'success' => true,
                            'updates' => '<div class="card shadow d-none">
                                <div class="card-body text-center">
                                    <img src="'.app_cdn_path.'img/img-rewards.png" class="img-fluid rounded mt-16" alt=""/>
                                    <div class="fs-1 fw-semibold mt-12">Rewards dropping soon! </div>
                                    <div class="fs-5  mt-5 text-center">We’re working with communities to define <br>
                                        rewards for Lighthouse members. Sign up to stay tuned.</div>
                                    <form class="row g-6 justify-content-md-center mt-23 mb-18">
                                        <div class="col-6">
                                            <label for="Email" class="visually-hidden">Email</label>
                                            <input type="password" class="form-control form-control-lg" id="Email" placeholder="Email">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary btn-lg px-20 text-uppercase">Get Notified</button>
                                        </div>
                                    </form>
                                </div>
                            </div>'));
                        exit();
                    }
                    $response =  Utils::LightHouseApi("coin?coin=$coin_id");
                    include __DIR__ . '/../tpl/partial/profile.php';
                    $html = ob_get_clean();
                    echo json_encode(array('success' => true,'profile' => $html));
                    exit();

                case '/ohlcv-updates':
                    if($this->hasParam('coin_id') && strlen($this->getParam('coin_id')) > 0) {
                        $coin_id = $this->getParam('coin_id');
                        $response = Utils::OHLCV($coin_id);

                        if(isset($response->data)) {
                            $data = (array)$response->data;
                            $val = $data[$coin_id]->quote->USD->close;
                            $e_val = $data['1027']->quote->USD->close;
                            echo json_encode(array('success' => true,'c_val' =>'$'.number_format($val,2),'eth_val' => number_format(($val/$e_val),7).' ETH'));
                        }
                    }
                    else
                        echo json_encode(array('success' => false));
                    exit();
                    break;
            }
        }
    }
}
?>