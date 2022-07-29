<?php
define('DS', '/');
define('app_root', realpath(dirname(__FILE__) . '/../'));
define('app_version', 'Lighthouse Alpha');
define('app_timezone', 'Asia/Kolkata');

$server_parts = explode('.',$_SERVER['SERVER_NAME']);
$currently_in_localhost = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1','::1'))) ? true : false;

if(isset($server_parts[0]))
    define('app_site', $server_parts[0]);
else
    define('app_site', 'lighthouse');

define('app_name', 'Lighthouse');
define('request_type', 'web');
define('app_class_path', 'core' . DS);
define('app_core_path', app_root . DS.'modules' . DS);
define('app_template_path', app_root . DS.'templates' . DS);
define('app_upload_path', app_root .DS.'cdn'.DS.'uploads' . DS);
$image_path	= app_template_path."cdn".DS."img".DS."global".DS.app_name.DS;
define('app_image_path',$image_path);

if($currently_in_localhost)
{
    define('app_live', false);
    define('local_server_name', 'lighthouse');
    define('app_url', 'http://'.app_site.'.lighthouse.loc'.DS.local_server_name.DS);
    define('referer_app_url', 'http://'.app_site.'.lighthouse.loc');
    define('app_api_url', 'http://localhost/lighthouseapi/api');
}
else
{
    define('app_live', true);
    define('local_server_name', '');
    define('app_url', 'https://'.app_site.'.getlighthouse.xyz/');
    define('referer_app_url', 'https://'.app_site.'.getlighthouse.xyz');
    define('app_api_url', 'http://lighthouseapi.us-east-1.elasticbeanstalk.com/api');
}

define('app_cdn_path', 'cdn'.DS);
define('local_cdn_path', 'cdn'.DS);
?>