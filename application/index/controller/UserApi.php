<?php
namespace app\index\controller;

use \think\Controller;


//引入模型
use app\index\model\User;

class UserApi extends Controller
{
    public function register(){

        $account = input('account','');
        $password = input('password','');

        $user = new User();
        $user->account  = $account;
        $user->password = password_hash($password, PASSWORD_DEFAULT, array("cost" => 4));
        $user->save();

        return ['ret'=>1,'message'=>'操作完成'];

    }
}
