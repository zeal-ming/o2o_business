<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/19
 * Time: 下午3:45
 */

namespace app\common\validate;

use think\Validate;

class Deal extends Validate{

    protected $rule = [
        'name' => 'require',
        'city_id' => 'require',
        'category_id' => 'require',
        'image' => 'require',
        'start_time' => 'require',
        'end_time' => 'require',
        'total_count' => 'require|number',
        'origin_price' => 'require',
        'coupons_begin_time' => 'require',
        'coupons_end_time' => 'require',
        'description' => 'require',
        'notes' => 'require'
    ];

    protected $message = [
        'name.require' => '用户名不能为空',
        'city_id.require' => '请选择城市',
        'image.require' => '请选择上传图片',
        'start_time.require' => '请填写开始时间',
        'end_time.require' => '请填写结束时间',
        'total_count.require' => '请填写总量',
        'total_count.number' => '总量必须是数字',
        'origin_price.require' => '填填写价格',
        'coupons_begin_time.require' => '请填写优惠券生效',
        'coupons_end_time.require' => '请填写优惠券结束时间',
        'description.require' => '请填写描述',
        'notes.require' => '请填写简介'

    ];

    protected $scene = [
        'add' => ['name', 'city_id', 'image', 'start_time', 'end_time', 'total_count', 'origin_price', 'current_price', 'coupons_begin_time', 'coupons_end_time', 'description', 'notes']
    ];

}