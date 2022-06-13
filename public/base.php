<?php
if (!defined('BS_SHOP')) {
    exit('access denied');
}
//配置目录
defined('ROOT_PATH') or define('ROOT_PATH', str_replace('\\','/',dirname(dirname(__FILE__)).'/'));
defined('PUBLIC_PATH') or define('PUBLIC_PATH', ROOT_PATH . 'public/');
defined('EXTEND_PATH') or define('EXTEND_PATH', ROOT_PATH . 'extend' . '/');
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH . 'vendor' . '/');
defined('RUNTIME_PATH') or define('RUNTIME_PATH', ROOT_PATH . 'runtime' . '/');
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'log' . '/');
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'cache' . '/');
defined('TEMP_PATH') or define('TEMP_PATH', RUNTIME_PATH . 'temp' . '/');
defined('CONF_PATH') or define('CONF_PATH', ROOT_PATH . 'config' . '/'); // 配置文件目录
defined('DATA_PATH') or define('DATA_PATH', ROOT_PATH . 'data' . '/'); // 数据目录


// http协议类型

define('URL_HTTP', ((!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) || (!empty($_SERVER['HTTP_FROM_HTTPS']) && $_SERVER['HTTP_FROM_HTTPS'] !== 'off') || (!empty($_SERVER['HTTP_X_CLIENT_SCHEME']) && $_SERVER['HTTP_X_CLIENT_SCHEME'] == 'https')) ? 'https' : 'http');

//网站域名
if (empty($_SERVER['HTTP_HOST'])) {
    exit('error:unknown http_host!!!!!!');
}
define('URL_WEB', URL_HTTP . '://' . $_SERVER['HTTP_HOST'] . '/');


// 是否ajax
define('IS_AJAX', ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) ||
    isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'ajax'));
//是否post
define('IS_POST', isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post');