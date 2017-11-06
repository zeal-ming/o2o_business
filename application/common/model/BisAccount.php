<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 下午4:43
 */
namespace app\common\model;

use think\Model;

class BisAccount extends Model{
//    protected $autoWriteTimestamp = true;

    public function add($data){
        $data['status'] = 0;

        $this->save($data);

        return $this->id;
    }

    public function getAccountUsername($username){

        $data = [
            'username' => $username
        ];

        return $this->where($data)->select();
    }

}