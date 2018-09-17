<?php

/*
|--------------------------------------------------------------------------
| 入口文件
|--------------------------------------------------------------------------
|
| Don't make things too complicated.
| WE CAN DO IT MORE SIMPLE
| Author: 听听风  <907226763@qq.com>
|
*/
 
date_default_timezone_set('Asia/Shanghai');
// 定义根目录,可更改此目录
 define( 'PROJECT_PATH',realpath('../' )); 

 // 定义核心包目录
 define( 'CORE',PROJECT_PATH.'/core' );

 // 定义应用目录
 define( 'APP',PROJECT_PATH.'/app' );
 define( 'MODULE','app' );
 
//  引入composer
 include PROJECT_PATH."/vendor/autoload.php";

 // 调试模式开关
 define( 'DEBUG',true);

include CORE.'/common/function.php';

include CORE.'/Lessapi.php';

spl_autoload_register('\core\Lessapi::load');

\core\Lessapi::run();
 