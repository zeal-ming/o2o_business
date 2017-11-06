<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/24
 * Time: 上午10:03
 */

namespace app\common\model;


use think\Model;

class User extends Model{

    public function add($data){

        $this->save($data);

        return $this->id;
    }
}