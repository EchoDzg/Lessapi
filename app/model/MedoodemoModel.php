<?php
namespace app\model;

use core\lib\medoodb;

/*
|--------------------------------------------------------------------------
| @name 本类继承自Medoo 实例
| @describe 文档地址:https://medoo.lvtao.net/doc.php
|--------------------------------------------------------------------------
| 
| Don't make things too complicated.
| WE CAN DO IT MORE SIMPLE
| Author: 听听风  <907226763@qq.com>
|
*/
class MedoodemoModel extends medoodb
{
    public $table = "books";//表名

    public function lists()
    {
        $ret =  $this->select($this->table,'*');
        return $ret;
    }

    public function first($id)
    {
        $ret =  $this->get($this->table,'*',array(
            'id' => $id
        ));
        return $ret;
    }

  

}