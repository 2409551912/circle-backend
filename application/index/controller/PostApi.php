<?php
namespace app\index\controller;

use \think\Controller;
use app\index\model\User;
use app\index\model\Post;


class PostApi extends Controller
{
    public function post_list($id = 1){
        $post = new Post();
        $list = $post->order('id','desc')->where('tag_id',$id)->select();

        foreach ($list as $l){
            $user = User::get($l->user_id);
            $l->username = $user['username'];
        }


        $this->assign('list',$list);
        return $this->fetch('./post/list');

    }

    public function detail($id = 1){

        $post = Post::get($id);
        $user = User::get($post->user_id);
        $post->username = $user->username;

        $this->assign('post',$post);
        return $this->fetch('./post/detail');

    }

    public function publish()
    {
        $tag_arr = db('tags')->select();

        $this->assign('tag_arr',$tag_arr);
        $this->assign('name','ThinkPHP');
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

}
