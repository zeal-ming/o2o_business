<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/13
 * Time: 下午2:51
 */


namespace app\bis\controller;

use think\Controller;
use think\Db;
use think\Exception;

class Register extends Controller
{

    public function index()
    {

        $cities = model('City')->getNormalCitiesByParentId();
        $categories = model('Category')->getAllFirstNormalCategories();
        return $this->fetch('', [
            'cities' => $cities,
            'categories' => $categories
        ]);
    }

    public function showcity()
    {


        $city_id = input('post.city_id', 0, 'intval');

        $cities = model('City')->getNormalCitiesByParentId($city_id);


        $this->result($cities, '1', 'haha');
    }

    public function getCategories()
    {

        $parent_id = input('post.id');

        $res = model('Category')->getAllFirstNormalCategories($parent_id);

        if (!$res) {
            $this->result('', '0', '获取二级分类失败');
        }

        $this->result($res, '1', '成功');
    }


    public function regist()
    {

        $data = input('post.','','htmlentities');

//        dump($data);

        //校验商户信息
        $accountValidate = validate('BisAccount');

        $acountRes = $accountValidate->scene('add')->check($data);

        if (!$acountRes) {
            $this->error($accountValidate->getError());
        }


        //验证该商户是否存在
        if (model('BisAccount')->getAccountUsername($data['username'])) {
            $this->error('该用户已存在');
        }

        //数据校验
        $validate = validate('Bis');

        $res = $validate->scene('add')->check($data);

        if (!$res) {
            $this->error($validate->getError());
        }

        //数据校验BisLocation
        $validateLocation = validate('BisLocation');

        $validateLocation->scene('add')->check($data);
        if (!$res) {
            $this->error($validateLocation->getError());
        }

        //判断地理信息位置
        $locationResult = \Map::getLngLat($data['address']);

        if (!$locationResult || $locationResult['result']['precise'] == 0) {
            $this->error('地理信息不精确,请重新填写');
        }

        //准备bis表的数据
        $bisData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => $data['description'],
            'city_id' => $data['city_id'],
            'city_path' => $data['city_id'] . ',' . $data['se_city_id'],
            'bank_info' => $data['bank_info'],
            'bank_name' => $data['bank_name'],
            'bank_user' => $data['bank_user'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel']
        ];


        DB::startTrans();

        try {


            //提交到数据库
            $bisId = model('Bis')->add($bisData);
            if (!$bisId) {
//                $this->error('提交失败');
                throw new Exception('Bis失败');
            }

            //准备分类信息字符串,提供给category_path字段使用
//            $arr = $data['se_category_id'];
            $se_categories_string = '';
            if (!empty($data['se_category_id'])) {

                $arr = $data['se_category_id'];

                $se_categories_string = implode('|', $arr);
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
                'is_main' => 1,
                'api_address' => $data['address'],
                'city_id' => $data['city_id'],
                'city_path' => $data['city_id'] . $data['se_city_id'],
                'category_path' => $data['city_id'] . ',' . $se_categories_string,
                'bank_info' => $data['bank_info']

            ];

            //存入数据库
            $res = model('BisLocation')->add($locationData);

            if (!$res) {
                throw new Exception('BisLocation失败');

            }
            //随机生成code : 思维整数
            $data['code'] = mt_rand(1000, 10000);

            //准备商户信息
            $accountData = [
                'username' => $data['username'],
                'password' => md5($data['password'] . $data['code']),
                'code' => $data['code'],
                'bis_id' => $bisId,
                'is_main' => 1
            ];


            //将商户信息存入数据库
            $resultFromAccount = model('BisAccount')->add($accountData);

            if (!$resultFromAccount) {
                throw new Exception('resultFromAccount失败');
            }

//            if(!$resultFromAccount){
//                $this->error('失败');
//            }

            DB::commit();

            //发送邮件通知
            $title = '商城申请入驻审核通知';
            $url = request()->domain() . url('bis/register/waiting', ['id' => $bisId]);
            $content = '您的店铺信息正在审核中,<a href="' . $url . '">查看状态</a>';
            \phpMailer\Email::send($data['email'], $title, $content);
            $this->success('成功', url('register/waiting', ['id' => $bisId]));

        } catch (Exception $exception) {

            Db::rollback();

            $this->error($exception->getMessage());
//            echo $exception->getMessage();
        }
    }


    public function waiting($id)
    {
        if (empty($id)) {
            return '';
        }

        $detail = model('Bis')->get($id);
        return $this->fetch('', [
            'detail' => $detail
        ]);
    }

}