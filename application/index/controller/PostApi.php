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

        $auth_id = 1;


       // var_dump(\Auth::user()->account);die;
        $interact = new Interact();

        if($interact->where(['from_user_id' => $auth_id,'post_id'=>$id,'type'=>2])->value('status')){

            $is_like = 1;

        }else{

            $is_like = 0;

        }

        $reply = new InteractReply();

        $interact_list = $interact->where('post_id', $id)->where('type',1)->order('id','desc')->select();
        foreach ($interact_list as $interact){

            $username = User::get($interact->from_user_id)->username;

            $interact->username = $username;


            //添加点赞字段
            if($is_like_interact = $reply->where(['from_user_id'=>1,'interact_id'=>$interact->id,'type'=>2])->value('status')){

                $interact->is_like = $is_like_interact;
            }else{

                $interact->is_like = 0;

            }

            //评论统计字段
            $comment_count = $reply->where(['interact_id'=>$interact->id,'type'=>1])->count();

            $interact->comment_count = $comment_count;

            //热度字段
            $like_count = $reply->where(['interact_id'=>$interact->id,'type'=>2,'status'=>1])->count();

            $interact->hot = $comment_count + $like_count;

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



        return json(['ret'=>1,'post'=>$post,'interact_list'=>$interact_list,'username'=>'小小鸟','is_like'=>$is_like]);
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

    /**
     * @评论接口
     */

    public function reply_post()
    {
        $content = input('content','');
        $type = input('type','');
        $post_id = input('post_id','');

        $params = [
            'content' => $content,
            'from_user_id' => \Auth::id(),
            'type' => $type,
            'post_id' => $post_id
        ];


        $result = $this->validate(
            $params,
            [
                'type'  => 'require',
                'post_id'   => 'require',
                'from_user_id' =>'require'
            ]);

        if(true !== $result){
            // 验证失败 输出错误信息
            return json(['ret'=>-1,'message'=>'参数验证失败']);
            
        }


        $interact = new Interact();

        $interact->content = $content;
        $interact->from_user_id = 1;
        $interact->type = $type;
        $interact->post_id = $post_id;
        $interact->create_at = time();

        if($interact->save()){

            return json(['ret' => 1,'message' => '发布成功']);

        }else{

            return json(['ret' => -1,'message' => '发布失败']);

        }

    }

    /**
     * 回复接口
     */

    public function reply_post_interact()
    {
        $content = input('content','');
        $type = input('type','');
        $interact_id = input('interact_id','');
        $at_user_id = input('at_user_id','');

        $params = [
            'content' => $content,
            'from_user_id' => 1,
            'type' => $type,
            'interact_id' => $interact_id,
            'at_user_id' => $at_user_id
        ];

        $result = $this->validate(
            $params,
            [
                'interact_id' => 'require',
                'type' =>'require'
            ]
        );

        if(true !== $result){
            // 验证失败 输出错误信息
            abort(400, '参数异常', ['ret' => -1,'body' => $result]);
        }

        $reply = new InteractReply();

        if($type == 1){

            $reply->content = $content;
            $reply->from_user_id = 1;
            $reply->type = $type;
            $reply->interact_id = $interact_id;
            $reply->create_at = time();
            $reply->at_user_id = $at_user_id;

        }else{

            if($reply->where(['from_user_id' => 1,'interact_id'=>$interact_id,'type'=>2])->find()){

                $reply = $reply->where(['from_user_id' => 1,'interact_id'=>$interact_id,'type'=>2])->find();
                
                if($reply->status){
                    $reply->status = 0;
                }else{
                    $reply->status = 1;
                }

            }else{

                $reply->from_user_id = 1;

                $reply->type = $type;


                $reply->interact_id = $interact_id;
                $reply->create_at = time();

            }


        }


        if($reply->save()){

            return json(['ret' => 1,'message' => '发布成功']);

        }else{

            return json(['ret' => -1,'message' => '发布失败']);

        }

    }



    /**
     * 点赞接口
     * $params post_id 帖子id
     * $params from_user_id 点赞者id
     */
    public function like(){

        $post_id = input('post_id','');
        $from_user_id = input('from_user_id','');

        $from_user_id = 1;
        $params = [

            'post_id' => $post_id,
            'from_user_id' => 1,
            'type' => 2,
            'create_at' => time()

        ];

        $result = $this->validate(
           $params,
            [
                'post_id' => 'require',
            ]
        );

        if(true !== $result){
            // 验证失败 输出错误信息
            abort(400, '参数异常', ['ret' => -1,'body' => $result]);
        }


        $interact = new Interact();

        if($interact->where(['from_user_id' => $from_user_id,'post_id'=>$post_id,'type'=>2])->find()){

            $interact = $interact->where(['from_user_id' => $from_user_id,'post_id'=>$post_id,'type'=>2])->find();

            if($interact->status){
                $interact->status = 0;
            }else{
                $interact->status = 1;
            }

        }else {

            $interact->post_id = $post_id;
            $interact->from_user_id = 1;
            $interact->type = 2;
            $interact->create_at = time();

        }
        $interact->save();

        return json(['ret'=>1,'is_like' =>$interact->status]);
        

    }



}
