<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
// 自定义函数区

//状态映射
function status($status)
{
    if ($status == 1) {
        return "<label class='label label-success radius'>正常</label>";

    } else if ($status == 0) {
        return "<label class='label label-danger radius'>待审核</label>";
    } else if ($status == -1) {
        return "<label class='label label-danger radius'>删除</label>";
    } else if ($status == 2) {
        return "<label class='label label-danger radius'>未通过</label>";
    }


}

//设置分页方法
function pagination($pageObj)
{
    if (!$pageObj) {
        return '';
    }

    $result = "<div class='cl pd-5 bg-1 bk-gray mt-20 tp5-o2o'>" . $pageObj->render() . "</div>";

    return $result;
}

//网络请求的方法: curl
/**
 * @param $url 请求的url
 * @param int $type type=0表示get, 1表示post
 * @param array $data 请求时的数据 (post时使用)
 */
function doCurl($url, $type = 0, $data = [])
{

    //初始化curl
    $ch = curl_init();

    //设置相关参数
    curl_setopt($ch, CURLOPT_URL, $url);

    //CURLOPT_RETURNTRANSFER 设置以文本流的形式返回
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //CURLOPT_HEADER是否返回头部信息
    curl_setopt($ch, CURLOPT_HEADER, 0);

    //判断请求方式
    if ($type == 1) {
        curl_setopt($ch, CURLOPT_POST, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    //执行请求
    $result = curl_exec($ch);

    //关闭请求
    curl_close($ch);

    return $result;


}

//gen
function bisRegister($status)
{

    $str = '';

    if ($status == 0) {
        $str = '正在审核中,稍后会向您发送邮件,请关注邮件';
    } else if ($status == 2) {
        $str = '审核未通过,您提交的材料不符合要求';
    } else {
        $str = '该申请已经被删除';
    }

    return $str;
}

//根据category_path处理子分类信息
function getCategoryDetailByPath($category_path)
{

    if (empty($category_path)) {
        return '';
    }

    if (preg_match('/,/', $category_path)) {

        //先按照,号切割字符串
        $tempArray = explode(',', $category_path);
        $categoryID = $tempArray[0];

        //选出所有选过的的分类
        $tempSeArray = explode('|', $tempArray[1]);

        //选出所有栏目下的分类
        $allCategories = model('Category')->getAllFirstNormalCategories(intval($categoryID));

        //循环组合input标签
        $htmlString = '';

        for ($i = 0; $i < count($allCategories); $i++) {


            if (in_array($allCategories[$i]['id'], $tempSeArray)) {

                $htmlString .= "<input type='checkbox' name='se_category_id[]' value='" . $allCategories[$i]['id'] . "'checked />";

                $htmlString .= "<label>" . $allCategories[$i]['name'] . "</label>";

            } else {

                $htmlString .= "<input type='checkbox' name='se_category_id[]' value='" . $allCategories[$i]['id'] . "''/>";

                $htmlString .= "<label>" . $allCategories[$i]['name'] . "</label>";

            }

        }

        return $htmlString;
    } else {

        $categoryID = intval($category_path);
        return '';
    }
}

function checkMain($status)
{

    if ($status == 1) {
        return "<label class='label label-success radius'>总店</label>";
    } else if ($status == 0) {
        return "<label class='label label-secondary radius'>分店</label>";
    }
}

function getCityNameById($city_id)
{
    if (empty($city_id)) {
        return;
    }

    $city = model('City')->get($city_id);
    return $city->name;
}

function getCategoryNameById($category_id)
{
    if (empty($category_id)) {
        return;
    }
    $category = model('Category')->get($category_id);
    return $category->name;
}

//获取当前客户端的IP地址
function get_client_ip($type = 0)
{
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_REAL_IP'])) {//nginx 代理模式下，获取客户端真实IP
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos) unset($arr[$pos]);
        $ip = trim($arr[0]);
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

function countLocation($location_ids){

    if(!$location_ids){
        return 1;
    }

    $arr = explode(',',$location_ids);
    return count($arr);
}

