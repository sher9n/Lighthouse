<?php

date_default_timezone_set('UTC');
define('DS', '/');
define('app_root', realpath(dirname(__FILE__) . '/../'));
define('app_live', false);
define('app_version', 'Lighthouse Alpha');
define('app_timezone', 'Asia/Kolkata');

$server_parts = explode('.',$_SERVER['SERVER_NAME']);
$currently_in_localhost = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1','::1'))) ? true : false;

define('app_name', 'lighthouse');
define('request_type', 'web');
define('app_class_path', 'core' . DS);
define('app_core_path', app_root . DS.'modules' . DS);
define('app_template_path', app_root . DS.'templates' . DS);
define('app_upload_path', app_root .DS.'cdn'.DS.'uploads' . DS);
$image_path	= app_template_path."cdn".DS."img".DS."global".DS.app_name.DS;
define('app_image_path',$image_path);

if($currently_in_localhost)
{
    define('local_server_name', 'lighthouse');
    define('app_url', 'http://lighthouse.loc'.DS.local_server_name.DS);
    define('referer_app_url', 'http://lighthouse.loc');
} else
{
    define('local_server_name', '');
    define('app_url', 'http://lighthouse.com/');
    define('referer_app_url', 'https://lighthouse.com');
}

define('app_cdn_path', 'cdn'.DS);
define('local_cdn_path', 'cdn'.DS);
?>