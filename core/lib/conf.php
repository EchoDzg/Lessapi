<?php
namespace core\lib;
/*
|--------------------------------------------------------------------------
| 配置类
|--------------------------------------------------------------------------
|
| Don't make things too complicated.
| WE CAN DO IT MORE SIMPLE
| Author: 听听风  <907226763@qq.com>
|
*/
class conf
{
    static public $conf = array();
    static public function get($name,$file)
    {
        if(isset(self::$conf[$file])) {
            return self::$conf[$file][$name];
        } else {
            $path  = PROJECT_PATH . '/config/'.$file.'.php';
            if(is_file($path)) {
               $conf =  include $path;
               if(isset($conf[$name])) {
                   self::$conf[$file] = $conf;
                   return $conf[$name];
               } else {
                   throw new \Exception('没有这个配置项'.$name);
               }
            } else {
                throw new \Exception("找不到配置文件".$file);
            }   
        }

    }

    static public function all($file)
    {
        if(isset(self::$conf[$file])) {
            return self::$conf[$file];
        } else {
            $path  = PROJECT_PATH . '/config/'.$file.'.php';
            if(is_file($path)) {
               $conf =  include $path;
               self::$conf[$file] = $conf;
               return $conf;
            } else {
                throw new \Exception("找不到配置文件".$file);
            }   
        }
    }

}