<?php
namespace app\index\controller;

use \think\Controller;
use app\index\model\User;
use app\index\model\Post;
use app\index\model\Interact;
use app\index\model\InteractReply;

class PostApi extends Controller
{

    public function _initialize()
    {
        //设置请求头
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
    }

    public function post_list($id = 1){
        $post = new Post();
        $list = $post->order('id','desc')->where('tag_id',$id)->select();

        foreach ($list as $l){
            $user = User::get($l->user_id);
            $l->username = $user['username'];
        }

//        $this->assign('list',$list);
//        return $this->fetch('./post/list');

        return json(['ret'=>1,'list'=>$list]);

    }

    public function detail($id = 1){

        $post = Post::get($id);
        $user = User::get($post->user_id);
        $post->username = $user->username;

        $interact = new Interact();

        $reply = new InteractReply();

        $interact_list = $interact->where('post_id', $id)->order('id','desc')->select();
        foreach ($interact_list as $interact){

            $username = User::get($interact->from_user_id)->username;

            $interact->username = $username;

            $reply_interact_list = $reply->where('interact_id',$interact->id)->order('id','desc')->select();

            foreach ($reply_interact_list as $r){

                $from_username = User::get($interact->from_user_id)->username;
                $r->from_username = $from_username;
                if($r->at_user_id){

                    $user = User::get($r->at_user_id);
                    $r->at_username = $user->username;

                }
            }

            $interact->reply_list = $reply_interact_list;

        }



        return json(['ret'=>1,'post'=>$post,'interact_list'=>$interact_list,'username'=>'小小鸟']);
//        $this->assign('interact_list',$interact_list);
//        $this->assign('post',$post);
//        $this->assign('username',session('username'));
//        return $this->fetch('./post/detail');

    }

    public function publish()
    {
        $tag_arr = db('tags')->select();

        $this->assign('tag_arr',$tag_arr);
        $this->assign('name','ThinkPHP');
        $this->assign('username',session('username'));
        return $this->fetch('./post/publish');
    }

    public function publish_post()
    {
        $title = input('title','');
        $tag_id = input('tag_id','');
        $content = input('content','');
        $params = [
            'title' => $title,
            'content' => $content,
            'user_id' => session('user_id'),
            'tag_id' => $tag_id
        ];


        $post = new Post();

        $post->title = $title;
        $post->content = $content;
        $post->tag_id = $tag_id;
        $post->user_id = session('user_id');
        $post->create_at = time();

        if($post->save()){

            return ['ret' => 1,'message' => '发布成功'];

        }else{

            return ['ret' => -1,'message' => '发布失败'];

        }

    }

    public function reply_post()
    {
        $content = input('content','');
        $type = input('type','');
        $post_id = input('post_id','');
        $params = [
            'content' => $content,
            'from_user_id' => 215512,
            'type' => $type,
            'post_id' => $post_id
        ];

        $interact = new Interact();

        $interact->content = $content;
        $interact->from_user_id = session('user_id');
        $interact->type = $type;
        $interact->post_id = $post_id;
        $interact->create_at = time();

        if($interact->save()){

            return json(['ret' => 1,'message' => '发布成功']);

        }else{

            return json(['ret' => -1,'message' => '发布失败']);

        }

    }

    public function reply_post_interact()
    {
        $content = input('content','');
        $type = input('type','');
        $interact_id = input('interact_id','');
        $at_user_id = input('at_user_id','');

        $params = [
            'content' => $content,
            'from_user_id' => session('user_id'),
            'type' => $type,
            'interact_id' => $interact_id,
            'at_user_id' => $at_user_id
        ];


        $reply = new InteractReply();

        $reply->content = $content;
        $reply->from_user_id = session('user_id');
        $reply->type = $type;
        $reply->interact_id = $interact_id;
        $reply->create_at = time();
        $reply->at_user_id = $at_user_id;

        if($reply->save()){

            return ['ret' => 1,'message' => '发布成功'];

        }else{

            return ['ret' => -1,'message' => '发布失败'];

        }

    }



}
