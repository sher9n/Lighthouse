<?php

try {
    session_start();
    ob_start();
    
    date_default_timezone_set('UTC');

    require_once __DIR__ . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'config.inc.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'app.constants.inc.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'bootstrap.inc.php';

    if (strlen(local_server_name) > 0) {
        $router_path = trim((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $routers = explode(local_server_name, $router_path);
        define('__ROUTER_PATH', $routers[1]);
    } else
        define('__ROUTER_PATH', '/' . trim((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

    if(app_site != 'app') {

        $site = \lighthouse\Auth::getSite();

        if($site === false) {
            header("Location: https://getlighthouse.xyz");
            die();
        }
    }

    $localRoutes = array(
        '/cron-claim-approvals' => 'modules/crons/claim_approvals.php',
        '/cron-realms-api' => 'modules/crons/realms_api.php',
        '/disconnect_wallet' => 'modules/admin/ctrl/admin.php',
        '/check-dao-domain' => 'modules/onboard/ctrl/onboard.php',
        '/update-contract-address' => 'modules/onboard/ctrl/first_member.php',
        '/wallet-menu' => 'modules/admin/ctrl/admin.php',
        '/admin' => 'modules/admin/ctrl/admin.php',
        '/get-ntts' => 'modules/admin/ctrl/admin-dashboard.php',
        '/admin-dashboard' => 'modules/admin/ctrl/admin-dashboard.php',
        '/contribution-history' => 'modules/admin/ctrl/admin-dashboard.php',
        '/admin-approvals' => 'modules/admin/ctrl/admin-approvals.php',
        '/contribution-status' =>  'modules/admin/ctrl/admin-approvals.php',
        '/contribution' => 'modules/admin/ctrl/contribution.php',
        '/contribution-list' => 'modules/admin/ctrl/contribution.php',
        '/similar-contributions' => 'modules/admin/ctrl/contribution.php',
        '/contribution-details' => 'modules/admin/ctrl/admin-approvals.php',
        '/steward-percentage' => 'modules/admin/ctrl/admin-stewards.php',
        '/delete-stewards' => 'modules/admin/ctrl/admin-stewards.php',
        '/add-stewards' => 'modules/admin/ctrl/admin-stewards.php',
        '/admin-stewards' => 'modules/admin/ctrl/admin-stewards.php',
        '/integrations' => 'modules/admin/ctrl/admin-integrations.php',
        '/form-activation' =>  'modules/admin/ctrl/admin-integrations.php',
        '/realms-settings' => 'modules/admin/ctrl/realms-settings.php',
        '/integrations-form-preview' => 'modules/admin/ctrl/integrations-form-preview.php',
        '/integrations-form' => 'modules/admin/ctrl/admin-integrations-form.php',
        '/integrations-approvals' => 'modules/admin/ctrl/admin-integrations-approvals.php',
        '/get-form-question' => 'modules/admin/ctrl/admin-integrations-form.php',
        '/get-question-description' => 'modules/admin/ctrl/admin-integrations-form.php',
        '/delete-claim-img' => 'modules/admin/ctrl/admin-settings.php',
        '/gas_tank_balance' => 'modules/admin/ctrl/admin-settings.php',
        '/admin-settings' => 'modules/admin/ctrl/admin-settings.php',
        '/portal-dashboard' => 'modules/portal/ctrl/portal-dashboard.php',
        '/404' => 'modules/default/ctrl/http-404.php'
        /* claim and onboard routes
        '/send-ntts' => 'modules/admin/ctrl/admin-ntts.php',
        '/admin-ntts' => 'modules/admin/ctrl/admin-ntts.php',
        '/claim' => 'modules/claim/ctrl/claim.php',
        '/claim-reason' => 'modules/claim/ctrl/claim-reason.php',
        '/claim-success' => 'modules/claim/ctrl/claim-success.php',
        '/claim-details' => 'modules/admin/ctrl/admin-approvals.php',
        '/distribution' => 'modules/onboard/ctrl/distribution.php',
        '/first-member' => 'modules/onboard/ctrl/first_member.php',
        '/skip-onboard' => 'modules/onboard/ctrl/distribution.php',*/
    );

    function routeLocator($routerPath, $localRoutes)
    {
        if(app_site == 'app')
            $route = __DIR__ . DS . 'modules/onboard/ctrl/onboard.php';
        else
            $route = __DIR__ . DS . 'modules/admin/ctrl/admin.php';

        if (array_key_exists($routerPath, $localRoutes))
            $route = __DIR__ . DS . $localRoutes[$routerPath];

        return $route;
    }


    if (($route = routeLocator(__ROUTER_PATH, $localRoutes)) !== false) {
        include_once $route;
        $request = Request::build();
        $request->m = $request->o = $request->a = null;
        @list($request->m, $request->o, $request->a) = explode('/', trim(__ROUTER_PATH, '/'), 3);
        new Controller($request);
    }
    ob_end_flush();

} catch (Exception $e) {

    switch ($e->getCode()) {
        case 401:
            $msg = $mode = $pb = null;
            list($msg, $mode, $pb) = explode('-', $e->getMessage(), 3);

            $pb = !is_null($pb) ? '/signin?__pb=' . urlencode($pb) : '/signin';
            if ($mode == 'json') {
                header('Content-type: application/json');
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(array(
                    'success' => false,
                    'code' => $e->getCode(),
                    'message' => 'Your session has expired. Please Sign in',
                    'ret' => array('path' => $pb)
                ));
                exit();
            } else {
                header('Location: ' . $pb);
                exit();
            }
            break;

        default:
            if (!app_live) {
                echo '<pre>EXCEPTION: ' . $e->getMessage() . ' in file `' . $e->getFile() . '` on line `' . $e->getLine() . '`' . "\n\n";
                echo $e->getTraceAsString() . '</pre>';
            }
            break;
    }
}
exit(0);
