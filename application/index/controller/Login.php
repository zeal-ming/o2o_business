<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/23
 * Time: 下午4:16
 */

namespace app\index\controller;

use think\Controller;

class Login extends Controller{

    public function login(){

        $user = session('o2o_user','','ming');

        if($user){
            $this->redirect('index/index');
        }
       return $this->fetch();
    }

    //检查登录
    public function check(){

        if(request()->isPost())
        {
            $data = input('post.');
            //数据校验
            $validate = validate('BisAccount');

            $res = $validate->scene('check')->check($data);

            if(!$res){
                $this->error($validate->getError());
            }

            //根据用户名获取用户信息
            $res = model('User')->get(['username'=>$data['username']]);

            if(!$res){
                $this->error('该用户不存在');
            }

            if($res->status != 1){
                $this->error('该账号未激活,请前往邮箱激活');
            }

            //判断密码
            if($res->password != md5($data['password'].$res->code)){
                $this->error('密码错误');
            }

            //获取用户端IP地址
            model('User')->save([
                'last_login_time' => time(),
                'last_login_ip' => get_client_ip()
            ],['id'=>$res->id]);

            //存入session
            session('o2o_user',$res,'ming');

            //界面跳转
            $this->success('登录成功',url('index/index'));
        }

    }

    //退出登录
    public function logOut(){

        //清空session
        session(null, 'ming');

        //跳转到登录界面
        $this->redirect('login/login');
    }


}