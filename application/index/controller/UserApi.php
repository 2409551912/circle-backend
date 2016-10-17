<?php
namespace app\index\controller;

use \think\Controller;


//引入模型
use app\index\model\User;

class UserApi extends Controller
{

    public function _initialize()
    {
        //设置请求头
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
    }

    public function register(){

        $account = input('account','');
        $password = input('password','');
        $username = input('username','');

        $user = new User();

        if(!empty($user->where('account',$account)->find())){
            return json(['ret'=>-1,'message'=>'该用户名已注册']);
        }

        $user->account  = $account;
        $user->username  = $username;
        $user->password = password_hash($password, PASSWORD_DEFAULT, array("cost" => 4));
        $user->save();

        return json(['ret'=>1,'message'=>'操作完成']);

    }
}
