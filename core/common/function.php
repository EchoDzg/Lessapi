<?php

 
/**
 * 获取请求参数 function
 *
 * @param [type] $name 获取值
 * @param boolean $default 默认
 * @param boolean $fitt 过滤
 * @return void
 */
function request($name='',$default=false,$fitt=false)
{
     
    if($name){
        if(isset($_REQUEST["$name"])) {
            if($fitt) {
                switch($fitt) {
                    case 'int':
                        if(is_numeric($_REQUEST[$name])){
                            return $_REQUEST[$name];
                        } else {
                            return $default;
                        }
                    break;
                    default : ;
                }
            } else {
                return $_REQUEST["$name"];
            }
        } else {
            return $default;
        }
    }else{
        return $_REQUEST;
    }
}

 