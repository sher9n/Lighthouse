<?php
try {
    session_start();
    ob_start();

    require_once __DIR__ . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'config.inc.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'app.constants.inc.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'bootstrap.inc.php';

    if (strlen(local_server_name) > 0) {
        $router_path = trim((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $routers = explode(local_server_name, $router_path);
        define('__ROUTER_PATH', $routers[1]);
    } else
        define('__ROUTER_PATH', '/' . trim((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

    $localRoutes = array(
        //-------------dashboard-------------
        '/dashboard' => 'modules/dashboard/ctrl/dashboard.php',
        '/update-user' => 'modules/dashboard/ctrl/dashboard.php',
        '/get-profile' => 'modules/dashboard/ctrl/dashboard.php',
        '/get-coins' =>  'modules/dashboard/ctrl/dashboard.php',
        '/pin-coin' =>  'modules/dashboard/ctrl/dashboard.php',
        '/get-tweets' => 'modules/dashboard/ctrl/dashboard.php',
        '/get-notify' => 'modules/dashboard/ctrl/dashboard.php',
        '/get-mentions' => 'modules/dashboard/ctrl/dashboard.php',
        '/ohlcv-updates' => 'modules/dashboard/ctrl/dashboard.php',
        //------------validate---------------
        '/get-spaces' => 'modules/validate/ctrl/validate.php',
        '/coin-search' => 'modules/validate/ctrl/validate.php',
        '/validate' => 'modules/validate/ctrl/validate.php',
        '/validate-governance' => 'modules/validate/ctrl/validate.php',
        '/update-space-coin' => 'modules/validate/ctrl/validate.php',
        '/delete-space-coin' => 'modules/validate/ctrl/validate.php',
        //----------------drops-----------------
        '/dashboardv2' => 'modules/drop/ctrl/dashboardv2.php',
        '/404' => 'modules/default/ctrl/http-404.php'
    );

    function routeLocator($routerPath, $localRoutes)
    {
        $route = __DIR__ . DS . 'modules/dashboard/ctrl/dashboard.php';

        if (array_key_exists($routerPath, $localRoutes))
            $route = __DIR__ . DS . $localRoutes[$routerPath];

        if(request_type == 'api')
            $route = __DIR__ . DS . 'modules/api/ctrl/api-endpoints.php';

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
