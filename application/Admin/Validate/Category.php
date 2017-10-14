<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/12
 * Time: 上午9:38
 */

namespace app\admin\validate;

use think\Validate;

class Category extends Validate{

    //设置规则
    protected $rule = [

        //必须是数字,并且约束范围
        'status' => 'number|in:1, 0, -1',
        'name' => 'require|max:15',
        'parent_id' => 'number',
        'id' => 'number',
        'listorder' => 'number'
    ];

    //错误提示消息
    protected $message = [
        'status.number' => "类型必须是数字",
        'status.in' => '数值超过规定范围',
        'name.require' => '姓名不能为空',
        'name.max' => '范围不能超过15',
        'parent_id.number' => '必须是数字',
        'id.number' => '必须是数字',
        'listorder.number' => '必须是数字'
    ];

    //设置场景
    protected $scene = [
        'add' => ['name','parent_id'],
        'status' => ['status','id'],
        'update' => ['name','id','parent_id'],
        'listorder' => ['id', 'listorder']
    ];
}