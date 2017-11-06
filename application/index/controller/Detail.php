<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/27
 * Time: 下午3:27
 */

namespace app\index\controller;

class Detail extends Base {

    public function index(){

        //获取某个商品的具体信息
        $id = input('id', 0, 'intval');

        $detail = model('Deal')->get($id);

        //获取location_ids
        $shops = $detail->location_ids;

        $shop_arr = explode(',', $shops);
        $data = [];
        foreach ($shop_arr as $shop){

            $data[] = model('BisLocation')->get(intval($shop));
        }

        //获取栏目
        $category = model('Category')->get(['id'=>$detail->category_id]);
//        dump($detail);
        return $this->fetch('',[
            'title' => $detail->name,
            'detail' => $detail,
            'category' => $category,
            'location' => $data[0]['xpoint'].','.$data[0]['ypoint']
        ]);
    }



}