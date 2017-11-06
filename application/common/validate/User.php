<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/24
 * Time: 上午9:28
 */

namespace app\common\validate;

use think\Validate;

class User extends Validate{

    protected $rule = [
        'userName' => 'require|max:30',
        'password' => 'require',
        'email' => 'require|email',
        'verifyCode' => 'require'
    ];

    protected $message = [
        'userName.require' => '用户名不能为空',
        'userName.max' => '用户名不能超过30',
        'password.require' => '密码不能为空',
        'email.require' => '邮箱不能为空',
        'email.email' => '邮箱格式不对',
        'verifyCode.require' => '验证码不能为空',
    ];

    protected $scene = [
        'add' => ['userName','password','email','verifyCode']
    ];


}