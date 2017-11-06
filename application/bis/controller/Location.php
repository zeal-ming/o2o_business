<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/18
 * Time: 下午4:53
 */
namespace app\bis\controller;


class Location extends Base {

    private $bisLocationObj;

    public function _initialize()
    {
        $this->bisLocationObj = model("BisLocation");
    }

    public function index(){

        $bis_id = $this->getLoginUser()->bis_id;

        $location = $this->bisLocationObj->where(['bis_id'=>$bis_id])->paginate(3);

        return $this->fetch('',[
            'location' => $location
        ]);

    }

    public function add(){

        if($this->request->isPost()){

            $data = input('post.');

            //判断地理信息位置
            $locationResult = \Map::getLngLat($data['address']);

            if (!$locationResult || $locationResult['result']['precise'] == 0) {
                $this->error('地理信息不精确,请重新填写');
            }

//            dump($this->getLoginUser());
            $bisId = $this->getLoginUser()->bis_id;
//            dump($bisId);
            //去库操作
            $se_categories_string = '';
            if (!empty($data['se_category_id'])) {

                $arr = $data['se_category_id'];

                $se_categories_string = ','.implode('|', $arr);
            }

            //数据校验
            $validate = validate('Branch');

            $vRes = $validate->scene('add')->check($data);

            if(!$vRes){
                $this->error($validate->getError());
            }

            //准备bisLocation表的数据
            $locationData = [
                'name' => $data['name'],
                'logo' => $data['logo'],
                'address' => $data['address'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'xpoint' => $locationResult['result']['location']['lng'],
                'ypoint' => $locationResult['result']['location']['lat'],
                'bis_id' => $bisId,
                'open_time' => $data['open_time'],
                'content' => $data['content'],
                'is_main' => 0,
                'api_address' => $data['address'],
                'city_id' => $data['city_id'],
                'city_path' => $data['city_id'] . $data['se_city_id'],
                'category_path' => $data['city_id'] . $se_categories_string,

            ];

            //存入数据库
            $res = $this->bisLocationObj->add($locationData);

            if(!$res){
                $this->error('门店信息添加失败');
            }

            $this->success('门店信息添加成功');

        } else {

            $cities = model('City')->getNormalCitiesByParentId();
            $categories = model('Category')->getAllFirstNormalCategories();
            return $this->fetch('', [
                'cities' => $cities,
                'categories' => $categories
            ]);

        }

    }

    public function status(){

        $status = input('status',0,'intval');

        $id = input('id',0, 'intval');

        $res = $this->bisLocationObj->save(
            ['status'=>$status],
            ['id'=>$id]
        );

        if(!$res){
            $this->error('下架失败');
        }

        $this->success('下架成功');
    }

    public function detail(){

        $id = input('id',0,'intval');

        $res = $this->bisLocationObj->get(['id'=>$id]);

        $cities = model('City')->getNormalCitiesByParentId();
        $categories = model('Category')->getAllFirstNormalCategories();

//        dump($res);
        //获取二级栏目分类
        $categories_string = $res['category_path'];
        $se_categories = '';

        if($categories){
            $categories_array = explode(',', $categories_string);
            $se_categories = explode('|', $categories_array[1]);

        }

        //获取二级城市
        $se_city_string = $res['city_path'];
        $se_city = '';
        if($se_city_string){

            $se_city_array = explode(',',$se_city_string);
            $se_city_id = $se_city_array[1];

            $se_city = model('City')->get(['id'=>$se_city_id]);
        }

//        dump($se_categories);

        return $this->fetch('',[
            'location' => $res,
            'cities' => $cities,
            'categories' => $categories,
            'se_categories' => $se_categories,
            'se_city' => $se_city,
        ]);
    }
}