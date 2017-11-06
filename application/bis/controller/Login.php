<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/13
 * Time: 下午2:51
 */

namespace app\bis\controller;

use think\Controller;
use think\Session;

class Login extends Controller{

    public function index(){


        //判断session
        if(session('loginUser','','bis')){
           $this->redirect('bis/index/index');
        }

        if(request()->isPost()){

            $data = input('post.');

            //数据校验
            $validate = validate('BisAccount');
            $res  = $validate->scene('check')->check($data);

            if(!$res){
                $this->error($validate->getError());
            }


            //根据用户名获取信息
            $result = model('BisAccount')->get([
                'username' => $data['username'],
            ]);

            if(!$result){
                $this->error('该用户不存在');
            }

            //匹配密码
            if(md5($data['password'].$result->code) != $result->password){
                $this->error('登录失败,密码不正确');
            }

            //存入session
            session('loginUser',$result,'bis');
            $this->success('登录成功','bis/index/index');

        }

        return $this->fetch();
    }

    //退出登录
    public function loginOut()
    {
        //session置空
        Session::delete('loginUser','bis');


        $this->redirect('login/index');
    }

    public function test(){

        $to = '943910611@qq.com';
        $title = '测试一下';
        $content = '您的账号非法使用中,<a style="color: red;" href="http://baidu.com">点击查看</a>';

        $res = \phpMailer\Email::send($to,$title,$content);

        if(!$res){
            $this->error('邮箱发送失败');
        }

        $this->success('邮箱发送成功','login/index');

    }

}