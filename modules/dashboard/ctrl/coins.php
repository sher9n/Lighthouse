<?php
use Core\Ds;
use Core\Utils;
class controller extends Ctrl {
    function init() {
        $coins = array();
        $respose  = Utils::LightHouseApi('coins');
        if($respose['status'] == 200)
            $coins = $respose['data'];

        usort($coins, function ($a, $b) {
            return $a['rank'] > $b['rank'];
        });

        $__page = (object)array(
            'title' => 'Coins',
            'coins' => $coins,
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