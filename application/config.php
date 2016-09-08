<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [

    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,


    // 视图输出字符串内容替换
    'view_replace_str'       => [

        'PUBLIC_PATH' => 'http://123.249.54.19:8085',
//        'ROOT_PATH' => 'http://123.249.54.19:8085'
    ],

    //路由配置
    'url_route_on'  =>  true,
    'url_route_must'=>  true,
    'default_ajax_return'    => 'json',

    'session'                => [
        'auto_start'     => true,
    ],





];
