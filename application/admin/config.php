<?php
return [

    //模板参数替换
    'view_replace_str'       => array(
        '__CSS__'    => '/dlgx/public/admin/css',
        '__JS__'     => '/dlgx/public/admin/js',
        '__IMAGES__' => '/dlgx/public/admin/images',
        '__PUBLIC__' => '/dlgx/public/',
    ),

    //管理员状态
    'user_status' => [
        '1' => '正常',
        '2' => '禁用'
    ],

    //角色状态
    'role_status' => [
        '1' => '启用',
        '2' => '禁用'
    ]

];
