<?php
namespace core\lib;
use core\lib\conf;
/*
|--------------------------------------------------------------------------
| 路由类
|--------------------------------------------------------------------------
|
| Don't make things too complicated.
| WE CAN DO IT MORE SIMPLE
| Author: 听听风  <907226763@qq.com>
|
*/
class route
{
    public $Controller;
    public $action;

    public function __construct(){
      
        $url = str_replace(array('?','=','&'),'/',$_SERVER['REQUEST_URI']);
        
        if(isset($url) && $url != '/') {
            $path = $url;
            $patharr = explode('/',trim($path,'/'));    
            if(isset( $patharr[0])) {
                $this->Controller = $patharr[0];
                unset($patharr[0]);
            }
            if(isset( $patharr[1])) {
                $this->action = $patharr[1];
                unset($patharr[1]);
            } else{
                $this->action = conf::get('DEFAULTFUNCTION','route');
            }
            //多余部分转换成 GET参数
            $count =  count($patharr) + 2;
            $i = 2;
            while($i < $count) {
                if(isset($patharr[$i + 1])){
                    $_REQUEST[$patharr[$i]] = $patharr[$i + 1];
                }
                $i = $i + 2 ;
            }
             
        } else {
            $this->Controller = conf::get('DEFAULTCTRL','route');
            $this->action = conf::get('DEFAULTFUNCTION','route');
        }

    }
}