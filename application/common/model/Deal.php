<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/19
 * Time: 下午2:17
 */

namespace app\common\model;

use think\Model;

class Deal extends Model{

    public function getAllNormalDeals($bisId = 0){

        $data = [
            'status' => 1,
            'bis_id' => $bisId
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];

        return $this->where($data)->order($order)->paginate();
    }

    public function getDealByCondition($data = []){

//        $data['status'] = 1;

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->paginate();

    }

    //通过一级栏目搜索
    public function getNormalDealByCategoryId($category_id, $limit, $city_id){

        $data = [
          'se_city_id' => $city_id,
            'category_id' => $category_id,
            'status' => 1,
            'start_time' => ['lt', time()],
            'end_time' => ['gt',time()],

        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        $res = $this->where($data)->order($order);

        if($limit > 0){
            $res = $res->limit($limit);
        }

        return $res = $res->select();

    }

    //通过一级,二级栏目搜索
    public function getDealBySeAndFirId($condition, $order){

        //准备条件
        $data = [
            'status' => 1,
            'start_time' => ['lt', time()],
            'end_time' => ['gt',time()],
        ];


        //准备排序
        $newOrder = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        //合并数组
        $newOrder = array_merge($order,$newOrder);



        //如果category_id se_category_id不为0,正常赋值,赋值,不作为条件查询(即查出所有)
        if($condition['category_id']){
           $data['category_id'] = $condition['category_id'];
        }

        if($condition['se_category_id']){
            $data['se_category_id'] = $condition['se_category_id'];
        }

        $res = $this->where($data)->order($newOrder);

        if($condition['limit'] > 0){
            $res = $res->limit($condition['limit'] );
        }

        return $res = $res->select();

    }

    //通过搜索框,搜索相关商家或者商品,返回商家列表
    public function getDealBySearchName($name){

        $data = [
            'name' => ['like','%'.$name.'%']
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->select();
    }


}