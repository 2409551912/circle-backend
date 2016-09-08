<?php
namespace app\index\model;

use think\Model;

class User extends Model
{
    protected $table = 'user';
    protected $pk = 'id';

    protected function initialize()
    {
        parent::initialize();
    }
}
?>