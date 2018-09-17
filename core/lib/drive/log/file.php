<?php
namespace core\lib\drive\log;
//文件系统
use core\lib\conf;
class file
{
    public $path;//存储路径
    public $switch;//开关
    public function __construct()
    {
        $conf = conf::get('OPTION','log');
        $this->path = $conf['PATH'];
        $this->switch = conf::get('SWITCH','log');
    }

    public function log($msg,$file = 'log')
    {
        
        if( $this->switch ){
            date_default_timezone_set("PRC");
            if(!is_dir($this->path.date('Ymd'))) {
                mkdir($this->path.date('Ymd'),'0777',true);
            }
            
            file_put_contents($this->path.date('Ymd').'/'.$file.'.log',date('Y-m-d H:i:s').' '.json_encode($msg).PHP_EOL,FILE_APPEND);
        }
    }
}