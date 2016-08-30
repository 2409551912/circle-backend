<?php
namespace app\index\controller;

use \think\Controller;

class Post extends Controller
{
    public function publish()
    {
        $this->assign('name','ThinkPHP');
        return $this->fetch('./post/publish');
    }
}
