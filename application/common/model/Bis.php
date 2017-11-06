<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 下午4:43
 */
namespace app\common\model;

use think\Model;

class Bis extends Model{
//    protected $autoWriteTimestamp = true;

        public function add($data){
            $data['status'] = 0;
            $this->save($data);

            return $this->id;
        }

        //查出所有商户列表
        public function getBisByStatus($status){

            $data = [
                'status' => $status
            ];

            $order  = [
                'listorder' => 'desc',
                'id' => 'desc'
            ];

            return $this->where($data)->order($order)->paginate(5);
        }
}