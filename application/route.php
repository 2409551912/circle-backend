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
        '/index_post' => ['Index/index_post', ['method' => 'get']],

        //帖子
        '/post/publish'=>['PostApi/publish',['method' => 'get']],
        '/post/publish_post'=>['PostApi/publish_post',['method' => 'post']],
        '/post/list/:id'=>['PostApi/post_list',['method' => 'get']],
        '/post/detail/:id'=>['PostApi/detail',['method' => 'get']],
        '/post/reply_post'=>['PostApi/reply_post',['method' => 'post']],
        '/post/reply_post_interact'=>['PostApi/reply_post_interact',['method' => 'post']],
        '/post/like'=>['PostApi/like',['method' => 'post']],


        '/login' => ['Index/login',['method' => 'post']],
        '/exit' => ['Index/exit_account',['method' => 'get']],
        '/is_login' => ['Index/is_login',['method' => 'get']],

        '/user/register' => ['UserApi/register',['method' => 'post']],
    ],

];
