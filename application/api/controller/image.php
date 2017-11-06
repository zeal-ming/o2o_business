<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 上午9:16
 */

namespace app\api\controller;

use think\Controller;
use think\Request;

class Image extends Controller{

    public function upload(){


//        实例化一个请求类
        $file = Request::instance()->file('file');

//        dump($file);

        $info = $file->move('upload');

        if($info && $info->getPathname()){

            return show(1, 'success','/'.$info->getPathname());


        }

        return show(0, 'upload failed');
    }
}