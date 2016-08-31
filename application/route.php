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
    '__pattern__' => [
        'name' => '\w+',
    ],
    '/' => ['Index/index', ['method' => 'get']],
    '[index]'     => [
        '/' => ['Index/index', ['method' => 'get']],
        '/post/publish'=>['Post/publish',['method' => 'get']],
        '/login' => ['Index/login',['method' => 'get']],

        '/user/register' => ['User/register',['method' => 'post']]
    ],

];
