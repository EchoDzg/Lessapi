<?php
namespace core;
/*
|--------------------------------------------------------------------------
| Lessapi核心类 
|--------------------------------------------------------------------------
|
| Don't make things too complicated.
| WE CAN DO IT MORE SIMPLE
| Author: 听听风  <907226763@qq.com>
|
*/
use core\lib\conf;
class Lessapi
{
    public static $classMap = array();
    public $assign;
    
    /**
     * 启动框架 function
     *
     * @return void
     */
    static public function run()
    {
        $start = microtime(true);
        ini_set('always_populate_raw_post_data',1);
        if(DEBUG) {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
            ini_set('display_errors','on');
        } else {
            error_reporting(0);
            
            if(conf::get('SWITCH','log')){ //错误日志配置
                // error_log("Oh no! We are out of FOOs!", 1, "907226763@qq.com");
                register_shutdown_function(array('\core\lib\errortoexception','deadly_error'));//处理致命错误
                set_error_handler(array('\core\lib\errortoexception','ordinary_error'));//处理普通报错
                set_exception_handler(array('\core\lib\errortoexception','myException'));//用户定义的异常处理函数(未捕获的)
            }
        }

        \core\lib\log::init();
      
        $route = new \core\lib\route();
        $ctrlClass = $route->Controller;
        $action = $route->action;
      
        $ControllerFile = APP.'/Controllers/'.$ctrlClass.'Controller.php';
         
        $ControllerClass =  '\\'. MODULE . '\Controllers\\' . $ctrlClass.'Controller';
         
        if(is_file($ControllerFile)) {
            include $ControllerFile;
            $ctrl  =  new $ControllerClass();
            $ctrl->$action();
            $end = microtime(true);
            $Expenses = $end-$start;
            $memory = 'Now memory_get_usage: ' . (memory_get_usage()/1024) .'kb';
            \core\lib\log::log('Controller:'.$ctrlClass.'  '.'action:'.$action."  time: {$Expenses}"." {$memory}",'expenses');
        } else {
            throw new \Exception('找不到控制器'.$ctrlClass);
        }
    }

    //自动加载方法
    static public function load($class)
    {
        
        if(isset($classMap[$class])) {
            return true;
        } else {
            $class = str_replace('\\','/',$class);
            $file = PROJECT_PATH.'/'.$class.'.php';
           
            if (is_file($file)) {
                include $file;
                self::$classMap[$class] = $class;
                 
            }   else{
                return false;
            }
        }
      
    }

    public function assign($name,$value)
    {
        $this->assign[$name] = $value;
    }
 
    /**
       * 视图层渲染
       *  
     */
     public function display($file)
        {
            $filePath=APP.'/views/'.$file;
            // dump($value);
            if(is_file($filePath)){
                $smarty = new \Smarty;
                $smarty->setTemplateDir(APP.'/views/'); //设置模板目录
                $smarty->setCompileDir(PROJECT_PATH.'comp/');
                $smarty->left_delimiter  = '<{';
                $smarty->right_delimiter = '}>';
                if($this->assign){
                    $smarty->assign($this->assign);
                }
                $smarty->display($file);
            }
     }

     /**
      * 表单验证 function
      *
      * @param [type] $request 请求参数
      * @param [type] $type 验证规则
      * @param [type] $arr  验证参数
      * @return void
      */
     public function validate($request,$type,$arr){

          $v = new \Valitron\Validator($request);
          $v->rule($type, $arr);
          if(!$v->validate()) {
             // 打印错误
             die(json_encode($v->errors()));
          }
     }

     /**
      * json方法 function
      *
      * @param [type] $code 状态码
      * @param [type] $info 提示信息
      * @param array $data 返回数据
      * @return void
      */
     public function json($code,$info,$data=array()){
         header('Content-type: application/json');
         $arr = array (
             'code' => $code,
             'info' => $info,
             'data' => is_array($data)?$data:""
         );
         echo json_encode($arr);
     }

}