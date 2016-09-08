<?php
namespace app\index\model;

use think\Model;

class Post extends Model
{
    protected $table = 'post';
    protected $pk = 'id';

    protected function initialize()
    {
        parent::initialize();
    }

}
?>