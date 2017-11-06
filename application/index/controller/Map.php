<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/28
 * Time: 上午11:10
 */

namespace app\index\controller;

use think\Controller;

class Map extends Controller {

    public function getMapImage($location){

        if(!$location){
            return '';
        }

        return \Map::getStaticImage($location);
    }
}