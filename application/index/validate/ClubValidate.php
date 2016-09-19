<?php
namespace app\index\validate;

use think\Validate;

class ClubValidate extends Validate
{
    protected $rule = [
        ['club_name', 'require|unique:club,club_apply', ['社团名称不能为空','该社团已存在']],
        ['club_owner_idcard', 'require', '身份证号码不能为空']
    ];

}