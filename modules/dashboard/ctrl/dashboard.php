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
                    //$user_key = '0xD91cD76F3F0031cB27A1539eAfA4Bd3DBe434507';
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
                                    <a class="coin_details" href="#">
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
                                </li>
                                    <li class="list-community-item">
                                    <a class="coin_details" href="#">
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
                        $href = 'pin-coin?user_key='.$user_key.'&pin='.$coin_id;
                        $action = 'unpin';
                        $coin_id = $this->getParam('unpin');
                        $response = Utils::LightHouseApi("pin-coin?address=$user_key&coin=$coin_id&action=unpin");
                    }
                    elseif ($this->hasParam('pin')) {
                        $href = 'pin-coin?user_key='.$user_key.'&unpin='.$coin_id;
                        $coin_id = $this->getParam('pin');
                        $response = Utils::LightHouseApi("pin-coin?address=$user_key&coin=$coin_id&action=pin");
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
            }
        }

        $__page = (object)array(
            'title' => 'Dashboard',
            'tab' => 'messages',
            'sections' => array(
                __DIR__ . '/../tpl/section.dashboard.php'
            ),
            'js' => array()
        );
        require_once app_template_path . '/base.php';
        exit();
    }
}
?>