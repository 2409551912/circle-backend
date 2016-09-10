<?php
namespace app\index\controller;

use \think\Controller;
use \think\Log;

//引入模型
use app\index\model\User;
use app\index\model\Post;

class Index extends Controller
{
    public function index()
    {

        $post = new Post();
        $tag_arr = $post->column('tag_id');
        foreach ($tag_arr as $t){

            $list[$t]['list'] = $post->order('id','desc')->where('tag_id',$t)->limit(10)->select();
            $tag = db('tags')->where('id',$t)->value('tag');

            $list[$t]['tag'] = $tag;
        }
        
        $this->assign('list',$list);
        $this->assign('username',session('username'));

        return $this->fetch('./index');

    }
    public function login(){

        $account = input('account','');
        $password = input('password','');

        $user = User::get(['account' => $account]);

        $is_check = password_verify($password,$user->password);

        if($is_check){
            session('account', $user->account);
            session('user_id', $user->id);
            session('username', $user->username);

            return ['ret'=>1,'message'=>'登陆成功'];

        }else{

            return ['ret'=>-1,'message'=>'密码错误'];

        }

        
    }
    public function exit_account(){
        session(null);
        $this->redirect('/');
    }
}
