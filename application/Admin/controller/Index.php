<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Controller{

    public function index(){
        return $this->fetch('index/index');
    }

    public function welcome(){
//        $r = request();

//        print_r('当前控制器是:'.$r->controller().'<br>');
//        print_r('当前模块是:'.$r->module().'<br>');
//        print_r('当前操作:'.$r->action().'<br>');
//        print_r('请求方法:'.$r->method().'<br>');
//        print_r('请求类型:'.$r->type().'<br>');
//        print_r('请求ip地址:'.$r->ip().'<br>');
//        print_r('是否是Ajax请求:'.'<pre>'.$r->isAjax().'</pre>'.<br>');
//        print_r($r);
//        print_r('请求参数:'.$r->param().'<br>');
//        print_r('请求紧紧包含name:'.$r->only(['name']).'<br>');

            $res = \Map::getLngLat('大连市沙河口区软件园3号楼');

            print_r($res);
        return '欢迎来到o2o平台';
    }
}