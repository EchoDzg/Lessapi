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
class pdodb extends \PDO
{
    public function __construct()
    {
        $database = conf::all('db');
        $dsn = "mysql:host={$database['server']};dbname={$database['database_name']}";
        $usename = $database['username'];
        $passwd = $database['password'];
        try {
            parent::__construct($dsn,$usename,$passwd);
        }catch(\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        
    }
}