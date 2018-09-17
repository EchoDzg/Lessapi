<?php
namespace core\lib;
use core\lib\conf;
/*
|--------------------------------------------------------------------------
| 日志类
|--------------------------------------------------------------------------
|
| Don't make things too complicated.
| WE CAN DO IT MORE SIMPLE
| Author: 听听风  <907226763@qq.com>
|
*/
class log
{
    static  $class;
    static public function init()
    {
        //存储日志方式
        $drive = conf::get('DRIVE','log');
        $class = "\core\lib\drive\log\\".$drive;
        self::$class = new $class;
    }

    static public function log($name,$file = 'log')
    {  
        self::$class->log($name,$file);
    }
}