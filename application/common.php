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
    if($status == 1)
    {
        return "<label class='label label-success radius'>正常</label>";
    } else if($status == 0) {
        return "<label class='label label-danger radius'>待审核</label>";
    } else if($status == -1) {
        return "<label class='label label-danger radius'>未通过</label>";
    }
}

//设置分页方法

function pagination($pageObj){
    if(!$pageObj){
        return '';
    }

    $result = "<div class='cl pd-5 bg-1 bk-gray mt-20 tp5-o2o'>".$pageObj->render()."</div>";

    return $result;
}

//网络请求的方法: curl
/**
 * @param $url 请求的url
 * @param int $type type=0表示get, 1表示post
 * @param array $data 请求时的数据 (post时使用)
 */
function doCurl($url, $type = 0, $data = []){

    //初始化curl
    $ch  =  curl_init();

    //设置相关参数
    curl_setopt($ch, CURLOPT_URL, $url);

    //CURLOPT_RETURNTRANSFER 设置以文本流的形式返回
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //CURLOPT_HEADER是否返回头部信息
    curl_setopt($ch, CURLOPT_HEADER, 0);

    //判断请求方式
    if($type == 1) {

        curl_setopt($ch, CURLOPT_POST, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    //执行请求
    $result = curl_exec($ch);

    //关闭请求
    curl_close($ch);

    return $result;


}