<?php

return array(
    'DRIVE' => 'file', //驱动类型
    'OPTION' => array(
        'PATH' => PROJECT_PATH.'/data/log/' //保存路径
    ),

    'SWITCH' => true, // 开启收集日志(包含访问的接口地址,性能耗时,内存占用),如下面设置的通知类型为1,则不会收集错误日志,而是以邮件的形式发送.

    //如果开启了调试模式,则不会产生错误日志和邮件通知
    
    'EXCEPTION' => array(//异常，错误处理
        'NOTICE_TYPE'  => 3, //  通知类型  3： 日志形式(默认类型) 1： 邮件(采用error_log发送邮件,必须安装sendmail) 
        'EMAIL' => '907226763@qq.com' //通知邮箱地址
    ),
);
 