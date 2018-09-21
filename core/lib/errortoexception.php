<?php namespace core\lib;
use core\lib\conf;
use core\lib\ThrowableError;
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
    public static $e = array();

    public function __construct($message,$filename,$line,$vars){
        $this->message=$message;
        $this->filename=$filename;
        $this->line=$line;
        $this->vars=$vars;
        self::$e = array(
            'file' =>$this->filename,
            'message' =>$this->message,
            'line' => $this->line,
            'type' => ''
        );
        
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
        
        self::execute('警告错误','Warning error',self::$e);
     }


     //通知级别错误
     public static function dealNotice(){
       
        self::execute('通知错误','Notification error',self::$e);
     }


    //致命错误
    public static function deadly_error()
    {       
        
       
           // 致命错误捕获
            if ($e = error_get_last()) {
               
                self::execute('致命错误','Fatal error',$e);
            }
    }

    //自定义异常
    public  static function myException($e){
   
        if (!$e instanceof \Exception) {
            $error = new ThrowableError($e);
        }
       
        self::execute('未捕获异常','Uncaptured exception',$error );
        
    }


    public static function execute($type='',$typeEnglish='',$e){
        ob_start();
      
        $time = date('Y-m-d H:i:s');
        $errnoMsg=<<<EOF

出现了{$type}错误，如下:
产生{$type}的文件: {$e['file']}
产生{$type}的信息: {$e['message']}
产生{$type}的行号: {$e['line']}
{$type}级别: {$e['type']}
时间: { $time}
-----------------------------
EOF;

  if(NOTICE_TYPE==3){
      $address = NOTICE_LOGADDR;
  }else if(NOTICE_TYPE==0){
      ini_set('log_errors',1);
      ini_set('error_log','syslog');
      $address = null;
      $errnoMsg=<<<EOF
      {$typeEnglish} occurred as follows:
      Error file: {$e['file']}
      Erroneous information: {$e['message']}
      Wrong line number: {$e['line']}
      error level: {$e['type']}
      time:  $time
EOF;

  }else{
      $address = EMAIL;
  }
  
        error_log($errnoMsg, NOTICE_TYPE, $address);//错误通知
    }

}
 
    