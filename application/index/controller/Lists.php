<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/27
 * Time: 下午2:33
 */

namespace app\index\controller;


class Lists extends Base {

    public function index()
    {

        //获取一二级栏目ID
        $category_id = input('id',0, 'intval');
        $se_category_id = input('se_id',0,'intval');

//        dump($category_id);
//        dump($se_category_id);

        //获取一级栏目
        $categories = model('Category')->getAllFirstNormalCategories();

        //获取二级栏目子分类
        if(!$category_id){
            //不存在.默认为1
            $se_categories = model('Category')-> getAllFirstNormalCategories(1);
        } else {
            $se_categories = model('Category')-> getAllFirstNormalCategories($category_id);

        }


        //根据条件(一级,二级,城市,限制条数),排序(销量,价格,最新发布)获取列表
        $condition = [
            'category_id' => $category_id,
            'se_category_id' => $se_category_id,
            'limit' => 20,          //固定20条
            'city_id' => $this->city->id
        ];

        //获取排序值.默认0  (1升序(asc),0降序(desc))
        $sort_sales = input('sort_sales',0,'intval');
        $sort_price = input('sort_price',0, 'intval');

        //判断点击了哪个排序
        $flag = input('flag','sales');

        //排序排第一个,后面会被忽略(解决:从前台传回来一个flag,根据flag判断点击的是哪个)

        //设置默认排序(销售最高的)
        $order = [
            'buy_count' => 'desc'
        ];
        if($flag == 'price'){
            $sort_str = $sort_price ? 'asc' : 'desc';
            unset($order['buy_count']);
            $order['current_price'] = $sort_str ;

//            dump('price:'. $order['current_price']);
        }
        if($flag == 'sales'){

            $sort_str = $sort_sales ? 'asc' : 'desc';
            $order['buy_count'] = $sort_str ;

//            dump('sales:'.$sort_sales);
        }

        //如果id, se_id 为空情况
        $lists = model('Deal')->getDealBySeAndFirId($condition, $order);

//    dump($se_category_id);
        return $this->fetch('',[
            'title' => $this->city->name.'团购',
            'lists' => $lists,
            'categories' => $categories,
            'se_categories' => $se_categories,
            'category_id' => $category_id,
            'se_category_id' => $se_category_id,
            'sort_sales' => $sort_sales,
            'sort_price' => $sort_price
        ]);

    }

    //通过搜索框搜索,获取团购列表
    public function search(){

        $name = input('search-text');

        if(!$name){
           $this->redirect('index/index');
        }

        $res = model('Deal')->getDealBySearchName($name);

        dump($res);
    }
}