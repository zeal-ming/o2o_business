<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/13
 * Time: 下午2:51
 */

namespace app\bis\controller;

use think\Controller;

class Login extends Controller{

    public function index(){
        return $this->fetch();
    }
}