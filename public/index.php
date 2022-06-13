<?php

define('BS_SHOP',1);
//是否捕获异常日志，开启后不会输出错误，异常存储数据库中
define('BS_CATCH_ERROR',false);

require __DIR__.'/base.php';
// 定义应用目录
define('APP_PATH', dirname(dirname($_SERVER['SCRIPT_FILENAME']) ) . '/application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';


