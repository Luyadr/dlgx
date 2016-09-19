<?php
namespace app\admin\validate;

use think\Validate;

class NoticeValidate extends Validate
{
    protected $rule = [
        ['notice_title', 'unique:notice', '该标题已存在']
    ];
}