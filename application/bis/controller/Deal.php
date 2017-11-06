<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/19
 * Time: 下午2:10
 */

namespace app\bis\controller;

class Deal extends Base {

    private $obj;

    public function _initialize()
    {
        $this->obj = model('Deal');
    }

    public function index()
    {
        //获取登录用户的信息
        $bis_id = $this->getLoginUser()->bis_id;
        $deals = $this->obj->getAllNormalDeals(intval($bis_id));

        dump(model('Deal')->getLastSql());
        return $this->fetch('',[
            'deals' => $deals
        ]);
    }

    public function add(){

        //获取当前登录商户的信息
        $bis_id = $this->getLoginUser()->bis_id;

        if(request()->isPost()){

            $data = input('post.');

            dump($data['se_category_id']);
            //数据校验
//            $validate = validate('Deal');
//            $res = $validate->scene('add')->check($data);
//
//            if(!$res){
//                $this->error($validate->getError());
//            }

            //准备分类信息字符串,提供给category_path字段使用
            $se_categories_string = '';
            $se_single_categorie_string = '';

            if (!empty($data['se_category_id'])) {

                //获取二级栏目ID
                $arr = $data['se_category_id'];

                //拼接二级栏目分类
                $se_single_categorie_string = implode('|',$arr);

                //拼接二级栏目分类,加上主栏目
                $se_categories_string = $data['category_id'].','.$se_single_categorie_string;
            }

            dump('二级:'.$se_single_categorie_string);
            dump('二级加:'.$se_categories_string);

            //准备勾选了那些分店信息的数据
            $locationId_string = '';
            if(!empty($data['location_ids']))
            {
                $locationId_string = implode(',',$data['location_ids']);
            }

            //准备数据
            $dealData = [
                'name' => $data['name'],
                'city_id' => $data['city_id'],
                'city_path' => $data['city_id'].','.$data['se_city_id'],
                'se_city_id' => $data['se_city_id'],
                'category_id' => $data['category_id'],
                'se_category_id' => $se_single_categorie_string,
                'category_path' => $se_categories_string,
                'bis_id' => $bis_id,
                'location_ids' => $locationId_string,
                'image' => $data['image'],
                'description' => $data['description'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'total_count' => $data['total_count'],
                'coupons_begin_time'=>strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'bis_account_id' => $this->getLoginUser()->id,
                'notes' => $data['notes']
            ];

            //入库操作
            $res = model('Deal')->save($dealData);

            if(!$res){
                $this->error('添加失败');
            }

            $this->success('添加成功');

        } else {

            //获取城市信息
            $cities = model('City')->getNormalCitiesByParentId();
            $categories = model('Category')->getAllFirstNormalCategories();

            //获取当前商户的所有门店信息
            $locations = model('BisLocation')->where(['bis_id'=>$bis_id])->select();

            return $this->fetch('', [
                'cities' => $cities,
                'categories' => $categories,
                'locations' => $locations,

            ]);
        }
    }

    public function detail(){

        //获取id
        $id = input('id', 0, 'intval');

        $deal = $this->obj->get($id);


        //获取城市信息
        $cities = model('City')->getNormalCitiesByParentId();
        $categories = model('Category')->getAllFirstNormalCategories();

        //获取二级城市
        $se_city_string = $deal['city_path'];
        $se_city_id = 0;
        $se_cities = '';
        if($se_city_string){

            $se_city_array = explode(',',$se_city_string);
            $se_city_id = $se_city_array[1];

            $se_cities = model('City')->getNormalCitiesByParentId($deal['city_id']);

        }

//        dump($se_cities);
        //获取二级栏目分类
        $categories_string = $deal['category_path'];
        $se_categories = '';

        if($categories){
            $categories_array = explode(',', $categories_string);
            $se_categories = explode('|', $categories_array[1]);

        }

        //获取登录用户的信息
        $bis_id = $this->getLoginUser()->bis_id;

        //获取当前商户的所有门店信息
        $locations = model('BisLocation')->where(['bis_id'=>$bis_id])->select();
        return $this->fetch('', [
            'cities' => $cities,
            'se_city_id' => $se_city_id,
            'se_cities' => $se_cities,

            'categories' => $categories,
            'se_categories' => $se_categories,

            'locations' => $locations,
            'deal' => $deal,

        ]);
    }
}