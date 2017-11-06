<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/20
 * Time: 上午10:57
 */

namespace app\admin\controller;


use think\Controller;

class Deal extends Controller{

    private $obj;

    protected function _initialize()
    {
        $this->obj = model('Deal');
    }

    public function index(){

        $data = input('post.');
        $con_data = [];

        //判断$data是否为空,以返回数组
        if(empty($data)){

           $data = [
               'category_id' => 0,
               'city_id' => 0,
               'start_time' => '',
               'end_time' => '',
               'name' => '',
               'status' => 3
           ];
        }
        
        //状态赋值
        $con_data['status'] = $data['status'];

        if($con_data['status'] == 3){
            $con_data['status'] = ['neq', 3];
        }


        //判断是否存在条件
        //商品栏目
        if(!empty($data['category_id'])){

            $con_data['category_id'] = $data['category_id'];

        }

        //城市
        if(!empty($data['city_id'])){
            $con_data['se_city_id'] = $data['city_id'];
        }

        //开始时间
        if(!empty($data['start_time']))
        {
            $con_data['start_time'] = [

                'gt',strtotime($data['start_time'])
            ];
        }

        //结束时间
        if(!empty($data['end_time']))
        {
            $con_data['end_time'] = [
                'lt',strtotime($data['end_time'])
            ];
        }

        if(!empty($data['start_time']) && !empty($data['end_time'])){

            if(strtotime($data['start_time']) > strtotime($data['end_time'])){

                $con_data['start_time'] = [
                    'gt',strtotime($data['end_time'])
                ];

                $con_data['end_time'] = [
                    'lt',strtotime($data['start_time'])
                ];

//                dump($con_data['start_time']);
            }

        }

        //名字
        if(!empty($data['name'])){

            $con_data['name'] = [
                'like','%'.$data['name'].'%'
            ];
        }

        //获取deal信息
        $deals = $this->obj->getDealByCondition($con_data);

        //分类信息
        $categories = model('Category')->getAllFirstNormalCategories();

        //二级城市
        $se_cities = model('City')->getAllSeCities();

        //获取所有的状态
//        $status = $this->obj->field('status')->select();
        $status = [
            1,0,-1,2
        ];

//        dump($status[0]['status']);

        return $this->fetch('',[
            'deals' => $deals,
            'categories' => $categories,
            'cities' => $se_cities,
            'data' => $data,
            'status' => $status
        ]);

    }

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

    //商户团购商品审核
    public function verify(){

        $data = input('post.');
        $con_data = [];

        //判断$data是否为空,以返回数组
        if(empty($data)){
            $data = [
                'category_id' => 0,
                'city_id' => 0,
                'start_time' => '',
                'end_time' => '',
                'name' => '',
            ];
        }

        //状态赋值
//        $con_data['status'] = $data['status'];
//
//        if($con_data['status'] == 3){
//            $con_data['status'] = ['neq', 3];
//        }


        //判断是否存在条件
        //商品栏目
        if(!empty($data['category_id'])){

            $con_data['category_id'] = $data['category_id'];

        }

        //城市
        if(!empty($data['city_id'])){
            $con_data['se_city_id'] = $data['city_id'];
        }

        //开始时间
        if(!empty($data['start_time']))
        {
            $con_data['start_time'] = [

                'gt',strtotime($data['start_time'])
            ];
        }

        //结束时间
        if(!empty($data['end_time']))
        {
            $con_data['end_time'] = [
                'lt',strtotime($data['end_time'])
            ];
        }

        if(!empty($data['start_time']) && !empty($data['end_time'])){

            if(strtotime($data['start_time']) > strtotime($data['end_time'])){

                $con_data['start_time'] = [
                    'gt',strtotime($data['end_time'])
                ];

                $con_data['end_time'] = [
                    'lt',strtotime($data['start_time'])
                ];

//                dump($con_data['start_time']);
            }

        }

        //名字
        if(!empty($data['name'])){

            $con_data['name'] = [
                'like','%'.$data['name'].'%'
            ];
        }

        $con_data['status'] = [
            'in' , [0, 1]
        ];

        //获取deal信息
        $deals = $this->obj->getDealByCondition($con_data);

        //分类信息
        $categories = model('Category')->getAllFirstNormalCategories();

        //二级城市
        $se_cities = model('City')->getAllSeCities();

        //获取所有的状态
//        $status = $this->obj->field('status')->select();
        $status = [
            1,0,-1,2
        ];

//        dump($status[0]['status']);

        return $this->fetch('',[
            'deals' => $deals,
            'categories' => $categories,
            'cities' => $se_cities,
            'data' => $data,
            'status' => $status
        ]);

    }

}