<?php namespace core\lib;
use core\lib\conf;
/**
 *  自定义错误异常通知类
 * Class ErrorToException
 */

date_default_timezone_set('Asia/Shanghai');

define("EMAIL", conf::get('EXCEPTION','log')['EMAIL']);//邮件地址
define("NOTICE_TYPE", conf::get('EXCEPTION','log')['NOTICE_TYPE']);// 错误通知类型 1 邮件  3 日志形式
define("NOTICE_LOGADDR", conf::get('OPTION','log')['PATH'].date('Ymd').'/error.log');// 日志方式存放地址

class errortoexception extends \Exception{


    public $message = '';
    public $filename='';
    public $line=0;
    public $vars = array();

    public function __construct($message,$filename,$line,$vars){
        $this->message=$message;
        $this->filename=$filename;
        $this->line=$line;
        $this->vars=$vars;
        
        
    }

    //普通错误
    public  static function ordinary_error($errno,$message,$filename,$line,$vars){
        
        $self = new self($message,$filename,$line,$vars);
        
        switch($errno){
            case E_USER_WARNING:
                return $self->dealWarning();
                break;
            case E_WARNING:
                return $self->dealWarning();
                break;
            case E_NOTICE:
                return $self->dealNotice();
                break;
            case E_USER_NOTICE:
                return $self->dealNotice();
                break;
            default:
                return false;
        }
    }
 
     //处理警告
     public function dealWarning(){
         $time = date('Y-m-d H:i:s');
                 $errnoMsg=<<<EOF

出现了警告错误，如下:
产生警告的文件: {$this->filename}
产生警告的信息: {$this->message}
产生警告的行号: {$this->line}
时间: $time
-----------------------------

EOF;
        if(NOTICE_TYPE==3){
            $address = NOTICE_LOGADDR;
        }else{
            $address = EMAIL;
        }
        error_log($errnoMsg, NOTICE_TYPE, $address);//错误通知
         
     }


     //通知级别错误
     public function dealNotice(){
        $time = date('Y-m-d H:i:s');
        $errnoMsg=<<<EOF

出现了通知错误，如下:
产生通知的文件: {$this->filename}
产生通知的信息: {$this->message}
产生通知的行号: {$this->line}
时间: $time
-----------------------------

EOF;
        
        if(NOTICE_TYPE==3){
            $address = NOTICE_LOGADDR;
        }else{
            $address = EMAIL;
        }
        
        error_log($errnoMsg, NOTICE_TYPE, $address);//错误通知

     }


    //致命错误
    public static function deadly_error()
    {       
        
       
           // 致命错误捕获
            if ($e = error_get_last()) {
                  ob_start();
      
                  $time = date('Y-m-d H:i:s');
                  $errnoMsg=<<<EOF

出现了致命错误，如下:
产生错误的文件: {$e['file']}
产生错误的信息: {$e['message']}
产生错误的行号: {$e['line']}
错误级别: {$e['type']}
时间: { $time}
-----------------------------
EOF;
     
            if(NOTICE_TYPE==3){
                $address = NOTICE_LOGADDR;
            }else{
                $address = EMAIL;
            }

            error_log($errnoMsg, NOTICE_TYPE, $address);//错误通知
                   
        }
    }

    //自定义异常
    public  static function myException($error){
        //开启内存缓冲
        ob_start();
        $time = date('Y-m-d H:i:s');
        $errnoMsg=<<<EOF

未捕获异常，如下:
异常文件: {$error->file}
异常信息: {$error->message}
行号: {$error->line}
code: {$error->code}
时间: { $time}
-----------------------------
EOF;
        
        if(NOTICE_TYPE==3){
            $address = NOTICE_LOGADDR;
        }else{
            $address = EMAIL;
        }

        error_log($errnoMsg, NOTICE_TYPE, $address);//错误通知
        
    }

}
 
    