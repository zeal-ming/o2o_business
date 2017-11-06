<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 下午3:15
 */

namespace app\common\validate;

use think\Validate;

class Bis extends Validate{

    protected $rule = [
        'name' => 'require|max:80',
        'email' => 'email',
        'logo' => 'require',
        'licence_logo' => 'require',
        'description' => 'require',
        'bank_info' => 'require',
        'bank_name' => 'require',
        'bank_user' => 'require',
        'faren' => 'require',
        'faren_tel' => 'require',
        'city_id' => 'require',
        'se_city_id' => 'require'
    ];

    protected $message = [

        'name.require' => '店名不能为空',
        'email.require' => '邮箱格式错误',
        'logo.require' => '缩略图不能为空',
        'licence_logo' => '营业执照不能为空',
        'description.require' => '商家介绍不能为空',
        'bank_info.require' => '银行卡号不能为空',
        'bank_name.require' => '开户行姓名不能为空',
        'bank_user.require' => '开户人不能为空',
        'faren.require' => '法人姓名不能为空',
        'faren_tel.require' => '法人电话不能为空',
        'city_id.require' => '省份不能为空',
        'se_city_id.require' => '城市不能为空'
    ];

    protected $scene = [

        'add' => ['name','email','logo','licence_logo','description','bank_info','bank_name','bank_user','faren','faren_tel','city_id','se_city_id']
    ];
}