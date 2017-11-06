<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/23
 * Time: 上午10:04
 */

namespace app\admin\controller;


use think\Controller;

class Featured extends Controller{

    private $obj;

    protected function _initialize()
    {
        $this->obj = model('Featured');
    }

    public function index(){

        if(request()->isPost()){

            $type = input('type', 0, 'intval');
            $featureds = $this->obj->getFeaturedByType($type);

        }
        else {

            $featureds = $this->obj->getAllFeatured();
            $type = 0;
        }

        $types = config('featured.featured_type');

        return $this->fetch('',[
            'data' => $featureds,

            'types' => $types,
            'type' => $type,
        ]);

    }

    //修改状态
    public function status(){

        $id = input('id',0, 'intval');
        $status = input('status', 0, 'intval');

        //修改状态
        $res = $this->obj->save(['status'=>$status],['id'=>$id]);

        if(!$res)
        {
            $this->error('状态更新失败');
        }

        $this->success('状态更新成功');

    }

    //添加
    public function add(){

        if(request()->isPost()){

            $data = input('post.');
            //校验

            //入库
            $res = $this->obj->save($data);

            if(!$res){
                $this->error('失败');
            }

            $this->success('成功');

        } else {

           $type = config('featured.featured_type');

            return $this->fetch('',[
                'types' => $type
            ]);

        }

    }



}