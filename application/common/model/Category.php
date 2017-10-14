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

        return $this->where($data)->order($order)->paginate();
    }

    public function getAllFirstNormalCategories()
    {

        //条件:
        $data = [
            'status' => ['neq', -1],
            'parent_id' => 0
        ];

        //排序:
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->select();
    }


}



