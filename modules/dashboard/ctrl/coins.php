<?php
use Core\Ds;
use Core\Utils;
class controller extends Ctrl {
    function init() {
        $coins = array();
        $response  = Utils::LightHouseApi('coins');
        $coins_names = array();
        if($response['status'] == 200)
            $coins = $response['data'];

        usort($coins, function ($a, $b) {
            return $a['rank'] > $b['rank'];
        });

        foreach ($coins as $c)
            array_push($coins_names,$c['slug']);

        $__page = (object)array(
            'title' => 'Coins',
            'coins' => $coins,
            'coin_names' => $coins_names,
            'sections' => array(
                __DIR__ . '/../tpl/section.coins.php'
            ),
            'js' => array()
        );
        require_once app_template_path . '/base.php';
        exit();
    }
}
?>