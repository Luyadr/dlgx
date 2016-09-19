<?php
namespace app\admin\validate;

use think\Validate;

class UserValidate extends Validate
{
    protected $rule = [
        ['user_name', 'unique:role', '该用户已存在']
    ];
}