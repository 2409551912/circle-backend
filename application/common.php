<?php


/**
 * 登录认证类
 * Class Auth
 *
 */
use app\index\model\User;
use \Redis\Redis;
class Auth {


    private static $_user;

    /**
     * 单例模式获取当前登录用户
     * @return object
     */
    protected static function getInstance() {

        if( ! self::$_user) {
            $bang_token = input('bang_token', '');
            $account = input('bang_account', '');
            $session_token = Redis::hGet("bang_session", $account);

            if( $session_token && $bang_token && ($session_token === $bang_token) )
            {
                $user = new User;
                $user = $user->where('account', $account)->find();
            }


            if( isset($user) ) {

                self::$_user = $user;

            } else {

                self::$_user = [];
            }



//            $me_user = [];
//            if( $ret && $ret->code == 0 ) {
//                $me_user = $ret->body->user;
//            }
//
//            self::$_user = $me_user;

        }


        return self::$_user;
    }






    /**
     * 返回当前登录用户信息
     * @return object
     */
    public static function user() {
        return self::getInstance();
    }


    /**
     * 返回当前登录用户ID
     * @return string
     */
    public static function id() {

        if( self::getInstance() ) {
            return self::getInstance()->id;
        }

        return 0;
    }

}
