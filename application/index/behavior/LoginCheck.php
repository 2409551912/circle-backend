<?php

namespace app\index\behavior;


/**
 * 检查是否已登录
 * Class LoginCheck
 * @package app\index\behavior
 */
class LoginCheck {


    public function run(&$route){


        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');

        // 未登录
        if( empty(\Auth::user()) ) {

            json([ 'ret' => 0, 'body' => '未登录' ])->send();

            if (function_exists('fastcgi_finish_request')) {
                // 提高页面响应
                fastcgi_finish_request();
            }

            exit;

        }

        return true;
    }
}