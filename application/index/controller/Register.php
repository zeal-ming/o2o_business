<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/23
 * Time: 下午4:17
 */

namespace app\index\controller;

use think\Controller;

class Register extends Controller{

    public function register(){
       return $this->fetch();
    }

    public function add(){

        if(request()->isPost()){
            $data = input('post.');

            //数据校验
            $validate = validate('User');
            $res = $validate->scene('add')->check($data);

            //验证码判断
            if(!captcha_check($data['verifyCode'])){
                $this->error('验证码不正确');
            }

            if(!$res){
                $this->error($validate->getError());
            }

            //入库操作
            $data['code'] = mt_rand(1000, 10000);
            $data['password'] = md5($data['password'].$data['code']);
            $data['username'] = $data['userName'];
            unset($data['userName']);
            unset($data['verifyCode']);
            $res = model('User')->add($data);

            if(!$res){
                $this->error('注册失败');
            } else {

                $to = $data['email'];
                $title = 'o2o平台账号激活';
                $content = "请点击以下链接激活账号<a href='http://index.php/index/register/waiting?id='".$res." target='_blank'>激活链接</a>";

                \phpMailer\Email::send($to,$title,$content);
            }

            //准备邮箱地址
            $emailHost = explode('@', $data['email'])[1];
            $emailHost = "http://mail.".$emailHost;
            //最好测试连接能否连通

            $this->success('请前往邮箱进行账号激活',$emailHost,'',5);
        }
    }

    public function waiting($id){

        if(empty($id)){
            return '';
        }
        //根据ID激活某个账号
        model('User')->save(['status'=>1],['id'=>$id]);
        return $this->fetch();
    }
    //前端检测用户名是否存在的方法
    public function checkName(){

        if(request()->isPost()){
            $username = input('username');

           $res = model('User')->get(['username'=>$username]);

           if($res){

               $this->result('','0','该用户名已存在');
           }
           else {

               $this->result('',1,'该用户名可以使用');
           }
        }
    }

}