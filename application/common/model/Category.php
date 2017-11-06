<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/11
 * Time: 下午4:53
 */

namespace app\common\model;

use think\Model;

class Category extends Model
{

//  自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    //获取分类(分页)
    public function getFirstNormalCategories($parent_id = 0)
    {

        //条件:
        $data = [
            'status' => ['neq', -1],
            'parent_id' => $parent_id
        ];

        //排序:
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->paginate(5);
    }

    //获取所有分类栏目(不分页)
    public function getAllFirstNormalCategories($parent_id = 0)
    {

        //条件:
        $data = [
            'status' => ['neq', -1],
            'parent_id' => $parent_id
        ];

        //排序:
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->select();
    }

    //获取栏目
//    public function getAllCategoriesTo(){
//
//        $data = [
//            'status' => 1
//        ];
//
//        $order = [
//            'listorder' => 'desc',
//            'id' => 'desc',
//        ];
//
//        return $this->where($data)->order($order)->limit(5)->select();
//    }
    //根据parent_id和limit查询分类

    public function getCategoryByParentId($parent_id = 0, $limit = 5){

        $data = [
            'status' => 1,
            'parent_id' => $parent_id
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        $result = $this->where($data)->order($order);

        if($limit){
            $result = $result->limit($limit);
        }

        $result = $result->select();

        return $result;
    }

    //根据parent_id数组获取所有二级分类
    public function getSeCatsByParentIds($parentIds = []){

        $data = [
            'status' => 1,
            'parent_id' => ['in', implode(',',$parentIds)]
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];

        return $this->where($data)->order($order)->select();
    }
}



