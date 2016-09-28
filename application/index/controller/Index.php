<?php



namespace app\index\controller;

use \think\Controller;
use \think\Log;

//引入模型
use app\index\model\User;
use app\index\model\Post;

class Index extends Controller
{

    public function _initialize()
    {
        //设置请求头
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
    }

    public function index()
    {

        $post = new Post();
        $tag_arr = $post->column('tag_id');
        foreach ($tag_arr as $t){

            $list[$t]['list'] = $post->order('id','desc')->where('tag_id',$t)->limit(10)->select();
            $tag = db('tags')->where('id',$t)->value('tag');

            $list[$t]['tag'] = $tag;
        }

//        $this->assign('list',$list);
//        $this->assign('username',session('username'));


        
        return $this->fetch('./index');

//        return json($list);

    }


    //主页动态模块
    public function index_post()
    {

        $post = new Post();


        $tag_arr = $post->column('tag_id');
        foreach ($tag_arr as $key => $t){

            $list[$t]['list'] = $post->order('id','desc')->where('tag_id',$t)->limit(10)->select();
            $tag = db('tags')->where('id',$t)->value('tag');

            $list[$t]['tag'] = $tag;
            $list[$t]['tag_id'] = $t;

        }

//        $this->assign('list',$list);
//        $this->assign('username',session('username'));

//        return $this->fetch('./index');

//        return $_GET['callback']."(".json_encode(['ret' => '1','list' => $list]).")";


        return json(['ret' => '1','list' => $list]);

    }

    public function login(){

        $account = input('account','');
        $password = input('password','');

        $user = User::get(['account' => $account]);

        $is_check = password_verify($password,$user->password);



        if($is_check){

            //需要优化的地方
            session('account', $user->account);
            session('user_id', $user->id);
            session('username', $user->username);
            return json(['ret'=>1,'message'=>'登陆成功','user_id'=>$user->id,'username'=>$user->username]);

        }else{

            return json(['ret'=>-1,'message'=>'密码错误']);

        }

        
    }
    public function exit_account(){
        session(null);
        $this->redirect('/');
    }

    public function is_login(){

        if(!empty(session('username'))){

            return json(['ret'=>1,'is_login'=>session('username')]);

        }else{

            return json(['ret'=>-1,'is_login'=>session('username')]);

        }


    }
}
