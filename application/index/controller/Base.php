<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/25
 * Time: 上午10:15
 */

namespace app\index\controller;

use think\Controller;

class Base extends Controller{

    protected $city;
    protected $account;

    protected function _initialize()
    {
        //获取城市信息
        $cities = model('City')->getAllSeCities();
        $user = session('o2o_user','','ming');
        $this->account = $user;

        //获取head应该显示的当前城市
        $city = $this->getCity($cities);


        //获取分类信息
        $reCommentArr = $this->getRecommendCategory();

        //设置title
        $this->assign('recs', $reCommentArr);
        $this->assign('city', $city);       //当前城市
        $this->assign('user',$user);        //当前用户
        $this->assign('cities', $cities);       //所有城市
        //获取当前控制器名称字符串并返回页面
        $this->assign('controller', strtolower(request()->controller()));
        $this->assign('title','911团购网');
//        $this->getCategoriesToIndex();
    }

    //获取用户在首页点击的城市
    public function getCity($cities){

        $defaultName = '';
        //遍历数组
        foreach ($cities as $city){

            //对象转换数组
            $city = $city->toArray();

            if($city['is_default'] == 1){
                $defaultName = $city['uname'];
                break;
            }
        }

        $defaultName = $defaultName ? $defaultName : 'dalian';
        //根据定位获取城市
        if(!input('city') && session('o2o_city','','o2o')){
            $current_city = session('o2o_city','','o2o');

        } else {

            $cityName = input('city', $defaultName, 'trim');
            $current_city = model('City')->get(['uname'=>$cityName]);

            session('o2o_city',$current_city, 'o2o');
        }

        $this->city = $current_city;

        return $current_city;
    }
    //获取前端一二级栏目组合
//    public function getCategoriesToIndex(){
//
//        //获取组织好的数据
//        $all_categories = [];
//
//
//        //获取一级栏目,获取5条数据
//        $first_categories = model('Category')->getAllCategoriesTo();
//
//        foreach ($first_categories as $val){
//
//            //获取每条记录的数组
//            $categories_arr = $val->toArray();
//
////            dump($categories_arr);
//
//            //临时一级栏目ID
//            $temp_id = $categories_arr['id'];
//            //new个新数组,存储一级栏目
//            $temp_arr = Array();
//
//            $temp_arr[] = $categories_arr['name'];
//
//            //根据一级栏目ID获取二级栏目
//            $se_categories = model('Category')->getFirstNormalCategories($parent_id = $temp_id);
//
////            dump($temp_id);
//            //获取二级栏目数组
//            foreach ($se_categories as $val){
//
//                $val = $val->toArray();
////                dump($val['parent_id']);
////                dump($val);
//                $se_arr['id'] = $val['id'];
//                $se_arr['name'] = $val['name'];
//
//                $temp_arr2[] = $se_arr;
//            }
//
//
//            $temp_arr[] = $temp_arr2;
//
//
//            $all_categories[$temp_id] = $temp_arr;
//
//        }
//
////        print_r($all_categories);
//
//    }

    //获取分类组合信息
    public function getRecommendCategory()
    {
        //存放所有一级分类的ID
        $parent_ids = array();

        //存放二级分类的信息数组
        $seCatArray = [];

        //存放最终结果的大数组
        $reCommentArr = [];

        //只要五个
        $cats = model('Category')->getCategoryByParentId(0,5);

        foreach ($cats as $cat){
            $parent_ids[] = $cat->id;
        }

        //根据ids获取所有的二级分类
        $seCats = model('Category')->getSeCatsByParentIds($parent_ids);

        foreach ($seCats as $seCat){
            $seCatArray[$seCat->parent_id][] = [
                'id' => $seCat->id,
                'name' => $seCat->name,
            ];
        }

        foreach ($cats as $cat) {
            $reCommentArr[$cat->id] = [$cat->name,empty($seCatArray[$cat->id])?'':$seCatArray[$cat->id]];
        }
        return $reCommentArr;
    }
    
}