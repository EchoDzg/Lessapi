<?php
namespace app\model;

use core\lib\pdodb;
/*
|--------------------------------------------------------------------------
| @name 本类继承自PDO 实例
| @describe PDO本身就是一个高度封装的数据库操作类 会PDO即刻可简单上手，无需更多学习成本。
|--------------------------------------------------------------------------
| 
| Don't make things too complicated.
| WE CAN DO IT MORE SIMPLE
| Author: 听听风  <907226763@qq.com>
|
*/
class PDOdemoModel extends pdodb
{
    public $table = "books";//表名

    public function lists()
    {
        $sql = "select * from {$this->table}";
        $res = $this->query($sql)->fetchAll();
        return $res;
    }

   
}