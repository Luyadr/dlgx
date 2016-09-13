<?php
namespace app\admin\validate;

use think\Validate;

class MemberValidate extends Validate
{
    protected $rule = [
        ['real_name', 'require', '姓名不能为空'],
    ];

}