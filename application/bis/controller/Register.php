<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/13
 * Time: 下午2:51
 */


namespace app\bis\controller;

use think\Controller;

class Register extends Controller{

    public function index(){

//        dump(input('param.'));
        $cities = model('City')->getNormalCitiesByParentId();
        return $this->fetch('', [
            'cities' => $cities
        ]);
    }

    public function showcity(){


       $city_id = input('post.city_id',0,'intval');

        $cities = model('City')->getNormalCitiesByParentId($city_id);


        $this->result($cities,'1','haha');
    }
}