<?php
namespace core\lib;
use core\lib\conf;
use Medoo\Medoo;
/*
|--------------------------------------------------------------------------
| 数据库操作类
|--------------------------------------------------------------------------
|
| Don't make things too complicated.
| WE CAN DO IT MORE SIMPLE
| Author: 听听风  <907226763@qq.com>
|
*/
class medoodb extends Medoo
{
    public function __construct()
    {
        $database = conf::all('db');
        parent::__construct($database);  
    }
}