<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 下午5:14
 */

namespace app\common\validate;

use think\Validate;

class BisLocation extends Validate {
    protected $rule = [
      'tel' => 'require',
        'contact' => 'require',
        'open_time' => 'require',
        'content' => 'require',
        'category_id' => 'require'
    ];

    protected $message = [

        'tel.require' => '电话号码不能为空',
        'contact.require' => '联系人姓名不能为空',
        'open_time.require' => '开业时间不能为空',
        'category_id.require' => '请选择分类信息',
        'content.require' => '内容不能为空',

    ];

    protected $scene = [
        'add' => ['tel','contact','open_time','content','category_id']
    ];

}