<?php
return [

    //模板参数替换
    'view_replace_str'       => array(
        '__CSS__'    => '/dlgx/public/admin/css',
        '__JS__'     => '/dlgx/public/admin/js',
        '__IMAGES__' => '/dlgx/public/admin/images',
        '__PUBLIC__' => '/dlgx/public',
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
    ],
   //公告状态
    'notice_status' => [
        '1' => '正常',
        '2' => '关闭'
    ],
   //社团审核状态
    'verify_status' => [
        '1' => '审核中',
        '2' => '已通过',
        '3' => '已拒绝'
    ],
    //社团审核状态
    'club_status' => [
        '2' => '通过',
        '3' => '拒绝',
    ],
   //社团审核级别
    'club_level' => [
        '1' => '兴趣社团',
        '2' => '院级组织',
        '3' => '校级组织',
    ],
  //视频管理审核级别
    'video_status' => [
        '1' => '正常',
        '2' => '关闭'
		] ,
/**
     * 七牛上传配置
*/
        'ACCESSKEY'=>'77TFY2VYN65eFsy9gi0m0wp7l2BiUmZ1SknbcLW0',
        'SECRETKEY'=>'s6D2Cf6ZnCWCkcamaim-FlCQNo-ekHxeD-ge-3pt',
        'BUCKET'=>'dlgx',//上传空间名称
        'DOMAIN'=>'http://odfgs4sbe.bkt.clouddn.com'
];
