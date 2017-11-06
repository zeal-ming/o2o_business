<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/19
 * Time: 上午9:41
 */

namespace app\common\validate;

use think\Validate;

class Branch extends Validate{

    protected $rule = [
        'name' => 'require',
        'city_id' => 'require',
        'logo' => 'require',
        'address' => 'require',
        'tel' => 'require',
        'contact' => 'require',
        'open_time' => 'require',
        'content' => 'require',
        'category_id' => 'require'
    ];

    protected $message = [
        'name.require' => '名字不能为空',
        'city_id.require' => '请选择城市',
        'address.require' => '地址不能为空',
        'logo.require' => '请上传图片',
        'tel.require' => '电话号码不能为空',
        'contact.require' => '联系人姓名不能为空',
        'open_time.require' => '开业时间不能为空',
        'category_id.require' => '请选择分类信息',
        'content.require' => '内容不能为空',

    ];

    protected $scene = [
        'add' => ['name','city_id','logo','address','tel','contact','open_time','content','category_id']
    ];


}