<?php
namespace app\index\controller;

use \think\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->assign('name','ThinkPHP');
        return $this->fetch('./index');
    }
    public function register(){
        var_dump('ha');
    }
}
