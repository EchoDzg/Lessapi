<?php
namespace app\Controllers;
use \core\Lessapi as BaseController;
use \app\model\MedoodemoModel; //Medoo模型 操作Mysql示例
use \app\model\PDOdemoModel; //PDO模型 操作Mysql示例
/*
|--------------------------------------------------------------------------
| 控制器示例
|--------------------------------------------------------------------------
| 
| Don't make things too complicated.
| WE CAN DO IT MORE SIMPLE
| Author: 听听风  <907226763@qq.com>
|
*/
class  indexController extends BaseController
{

    /**
     * 调用视图示例，为了不提高更多的学习成本,采用smarty3模板引擎
     * 如不需要视图,进入composer.json 中自由移除即可。
     * @return void
     */
    public function index(){
        $data = array(
            'title' => 'Lessapi',
            'describe' => '精简,高效的 PHP API开发框架(简单业务简单实现，复杂业务自由实现)'
        );
        $this->assign('data',$data);
        $this->display('index/index.html');
    }

    /**
     * 接口实例 function
     * 访问方式一: 域名/index/quest?id=3
     * 访问方式二: 域名/index/quest/id/3
     * @return void
     */
    public function quest(){
        $model  = new MedoodemoModel;
        $id = request('id');// 不传参数，则返回全部
        $res = $model->first($id);
        $this->json(2000,'返回成功',$res);
    }

    /**
     * Medoo模型 操作Mysql示例
     * 路由地址:域名/index/MedooModel
     * @return void
     */
    public function MedooModel(){
        $model  = new MedoodemoModel;
        $res = $model->lists();
        dump($res);
    }

    /**
     * PDO模型 操作Mysql示例
     * 路由地址:域名/index/PDOModel
     * @return void
     */
    public function PDOModel(){
        $model  = new PDOdemoModel;
        $res = $model->lists();
        dump($res);
    }

}   