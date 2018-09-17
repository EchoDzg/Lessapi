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
        ini_set('always_populate_raw_post_data',1);
        
        if(DEBUG) {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
            ini_set('display_errors','on');
        } else {
            ini_set('display_errors','off');
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
            \core\lib\log::log('Controller:'.$ctrlClass.'  '.'action:'.$action);
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