SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `dlgx_activity` (
  `id` int(11) NOT NULL,
  `act_name` varchar(255) NOT NULL COMMENT '活动名称',
  `act_intro` varchar(255) NOT NULL COMMENT '活动简介',
  `act_list_img` varchar(255) NOT NULL COMMENT '活动列表图',
  `act_detail_img` varchar(255) NOT NULL COMMENT '活动详情图',
  `act_create_time` int(11) NOT NULL COMMENT '创建时间',
  `act_release_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `act_start_time` int(11) NOT NULL COMMENT '开始时间',
  `act_end_time` int(11) NOT NULL COMMENT '结束时间',
  `act_address` varchar(255) NOT NULL COMMENT '活动地点',
  `act_money` int(11) NOT NULL COMMENT '活动费用',
  `act_from_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布社团ID，0表示官方'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_activity` (`id`, `act_name`, `act_intro`, `act_list_img`, `act_detail_img`, `act_create_time`, `act_release_time`, `act_start_time`, `act_end_time`, `act_address`, `act_money`, `act_from_id`) VALUES
(2, '大乐个学上线啦！', '大乐个学上线啦！', 'http://odfgs4sbe.bkt.clouddn.com/activity_list.png', 'http://odfgs4sbe.bkt.clouddn.com/activity_detail.png', 0, 1472641999, 1472572800, 1476028800, '大乐个学', 0, 0);

CREATE TABLE `dlgx_act_join` (
  `id` int(11) NOT NULL,
  `act_id` int(11) NOT NULL COMMENT '活动ID',
  `member_id` int(11) NOT NULL COMMENT '会员ID',
  `join_time` int(11) NOT NULL COMMENT '参加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_act_join` (`id`, `act_id`, `member_id`, `join_time`) VALUES
(22, 2, 3, 1474100334);

CREATE TABLE `dlgx_area` (
  `id` int(11) NOT NULL,
  `area_name` varchar(255) NOT NULL COMMENT '地区名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_area` (`id`, `area_name`) VALUES
(1, '芜湖'),
(2, '杭州');

CREATE TABLE `dlgx_club` (
  `id` int(11) NOT NULL,
  `club_icon` varchar(255) DEFAULT NULL COMMENT '社团团标',
  `club_name` varchar(255) NOT NULL COMMENT '社团名称',
  `club_level` int(11) NOT NULL COMMENT '社团级别：1.兴趣社团2.院级组织3.校级组织',
  `club_intro` varchar(255) NOT NULL COMMENT '社团简介',
  `club_school` varchar(255) NOT NULL COMMENT '社团学校',
  `club_owner_id` int(11) NOT NULL COMMENT '社团团长ID',
  `club_status` int(1) NOT NULL DEFAULT '1' COMMENT '社团状态：1.启用2.禁用',
  `club_create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_club` (`id`, `club_icon`, `club_name`, `club_level`, `club_intro`, `club_school`, `club_owner_id`, `club_status`, `club_create_time`) VALUES
(2, NULL, '社团联合会', 3, '（暂无简介）', '浙江大学', 3, 1, 0);

CREATE TABLE `dlgx_club_apply` (
  `id` int(11) NOT NULL,
  `club_icon` varchar(255) DEFAULT NULL COMMENT '社团团标',
  `club_name` varchar(255) NOT NULL COMMENT '社团名称',
  `club_level` int(1) NOT NULL COMMENT '社团级别：1.兴趣社团2.院级组织3.校级组织',
  `club_intro` varchar(255) NOT NULL DEFAULT '（暂无简介）' COMMENT '社团简介',
  `club_school` varchar(255) NOT NULL COMMENT '社团学校',
  `club_owner_id` int(11) NOT NULL COMMENT '社团团长ID',
  `club_owner_idcard` varchar(255) NOT NULL COMMENT '社团团长身份证号',
  `apply_time` int(11) NOT NULL COMMENT '申请时间',
  `verify_status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：1.审核中2.已通过3.已拒绝',
  `verify_idea` varchar(255) DEFAULT NULL COMMENT '审核意见'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_club_apply` (`id`, `club_icon`, `club_name`, `club_level`, `club_intro`, `club_school`, `club_owner_id`, `club_owner_idcard`, `apply_time`, `verify_status`, `verify_idea`) VALUES
(1, NULL, '社团联合会', 3, '（暂无简介）', '浙江大学', 3, '10086', 1474116645, 2, NULL);

CREATE TABLE `dlgx_club_join` (
  `id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL COMMENT '社团ID',
  `member_id` int(11) NOT NULL COMMENT '会员ID',
  `apply_time` int(11) NOT NULL COMMENT '申请时间',
  `verify_status` int(1) NOT NULL DEFAULT '1' COMMENT '审核状态：1.审核中2.已通过3.已拒绝'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_club_join` (`id`, `club_id`, `member_id`, `apply_time`, `verify_status`) VALUES
(6, 2, 4, 1474119796, 0);

CREATE TABLE `dlgx_member` (
  `id` int(11) NOT NULL,
  `member_openid` varchar(255) NOT NULL COMMENT '微信openid',
  `member_icon` varchar(255) NOT NULL COMMENT '会员头像',
  `member_name` varchar(255) NOT NULL COMMENT '会员名称',
  `member_intro` varchar(255) NOT NULL DEFAULT '（暂无简介）' COMMENT '会员简介',
  `real_name` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `member_sex` int(1) DEFAULT NULL COMMENT '性别：1.男2.女',
  `member_school` varchar(255) DEFAULT NULL COMMENT '学校',
  `member_department` varchar(255) DEFAULT NULL COMMENT '院系',
  `member_class` varchar(255) DEFAULT NULL COMMENT '专业班级',
  `member_tel` varchar(11) DEFAULT NULL COMMENT '手机',
  `member_idcard` varchar(18) DEFAULT NULL COMMENT '身份证号',
  `last_login_time` int(11) NOT NULL COMMENT '最近登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '最近登录IP',
  `login_times` int(11) NOT NULL COMMENT '登录次数',
  `member_create_time` int(11) NOT NULL COMMENT '注册时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_member` (`id`, `member_openid`, `member_icon`, `member_name`, `member_intro`, `real_name`, `member_sex`, `member_school`, `member_department`, `member_class`, `member_tel`, `member_idcard`, `last_login_time`, `last_login_ip`, `login_times`, `member_create_time`) VALUES
(3, 'ovo_Wv9unNunV_aCCoXVyRtOFw2I', 'http://wx.qlogo.cn/mmopen/NXsNg5c1niaXCcjXCBBkUDDHeEyMaibT422ydJV81PqWP2pBdQTPLOEeaAUdfOOLicf8F6bjLeQV0oEKbTIBjVX8a2HomPIcbFc/0', 'Luyadr', '（暂无简介）', '卢阳安', 1, '浙江大学', '信息工程学院', '信管121班', '18868196393', NULL, 1474095468, '127.0.0.1', 1, 1474095468),
(4, 'ovo_Wv9unNunV_aCCoXVyRtOFw2I', 'http://wx.qlogo.cn/mmopen/NXsNg5c1niaXCcjXCBBkUDDHeEyMaibT422ydJV81PqWP2pBdQTPLOEeaAUdfOOLicf8F6bjLeQV0oEKbTIBjVX8a2HomPIcbFc/0', '123', '（暂无简介）', '姚靖雯', 2, '浙江大学', '信息工程学院', '信管121班', '18868196613', NULL, 1474095468, '127.0.0.1', 1, 1474095468);

CREATE TABLE `dlgx_node` (
  `id` int(11) NOT NULL,
  `node_name` varchar(255) NOT NULL COMMENT '节点名称',
  `module_name` varchar(255) NOT NULL COMMENT '模块名称',
  `controller_name` varchar(255) NOT NULL COMMENT '控制器名称',
  `action_name` varchar(255) NOT NULL COMMENT '方法名称',
  `is_menu` int(1) NOT NULL COMMENT '是否是菜单项：1.不是2.是',
  `father_node_id` int(11) NOT NULL COMMENT '父节点ID',
  `style` varchar(255) DEFAULT NULL COMMENT '样式'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_node` (`id`, `node_name`, `module_name`, `controller_name`, `action_name`, `is_menu`, `father_node_id`, `style`) VALUES
(1, '系统管理', '#', '#', '#', 2, 0, 'fa fa-desktop'),
(2, '后台管理', '#', '#', '#', 2, 0, 'fa fa-users'),
(3, '业务管理', '#', '#', '#', 2, 0, 'fa fa-edit'),
(4, '节点列表', 'admin', 'node', 'index', 2, 1, ''),
(5, '数据备份/还原', 'admin', 'data', 'index', 2, 1, ''),
(6, '角色列表', 'admin', 'role', 'index', 2, 2, ''),
(7, '用户列表', 'admin', 'user', 'index', 2, 2, ''),
(8, '官方活动', 'admin', 'activity', 'index', 2, 3, ''),
(9, '官方公告', 'admin', 'notice', 'index', 2, 3, ''),
(10, '社团审核', 'admin', 'corporation', 'index', 2, 3, ''),
(11, '添加节点', 'admin', 'node', 'add', 1, 1, ''),
(12, '编辑节点', 'admin', 'node', 'edit', 1, 1, ''),
(13, '删除节点', 'admin', 'node', 'del', 1, 1, ''),
(15, '数据备份', 'admin', 'data', 'backup', 1, 1, ''),
(16, '数据还原', 'admin', 'data', 'recover', 1, 1, ''),
(17, '添加角色', 'admin', 'role', 'add', 1, 2, ''),
(18, '编辑角色', 'admin', 'role', 'edit', 1, 2, ''),
(19, '删除角色', 'admin', 'role', 'del', 1, 2, ''),
(20, '添加用户', 'admin', 'user', 'add', 1, 2, ''),
(21, '编辑用户', 'admin', 'user', 'edit', 1, 2, ''),
(22, '删除用户', 'admin', 'user', 'del', 1, 2, ''),
(23, '添加活动', 'admin', 'activity', 'add', 1, 3, ''),
(24, '编辑活动', 'admin', 'activity', 'edit', 1, 3, ''),
(25, '删除活动', 'admin', 'activity', 'del', 1, 3, ''),
(26, '添加公告', 'admin', 'notice', 'add', 1, 3, ''),
(27, '编辑公告', 'admin', 'notice', 'edit', 1, 3, ''),
(28, '删除公告', 'admin', 'notice', 'del', 1, 3, ''),
(29, '分配权限', 'admin', 'role', 'givepermission', 1, 2, ''),
(31, '视频管理', 'admin', 'video', 'index', 2, 3, ''),
(32, '添加视频', 'admin', 'video', 'add', 1, 3, NULL),
(33, '编辑视频', 'admin', 'video', 'edit', 1, 3, NULL),
(34, '图片上传', 'admin', 'activity', 'upload', 1, 3, NULL),
(35, '视频上传', 'admin', 'video', 'upload', 1, 3, NULL);

CREATE TABLE `dlgx_notice` (
  `id` int(11) NOT NULL,
  `notice_title` varchar(255) NOT NULL COMMENT '公告标题',
  `notice_content` text NOT NULL COMMENT '公告内容',
  `notice_from_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布社团ID，0表示官方',
  `notice_release_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间，0表示不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_notice` (`id`, `notice_title`, `notice_content`, `notice_from_id`, `notice_release_time`) VALUES
(2, '大乐个学上线啦！', '大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！', 0, 1472560409);

CREATE TABLE `dlgx_role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL COMMENT '角色名称',
  `permission_node` varchar(255) DEFAULT NULL COMMENT '权限节点'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_role` (`id`, `role_name`, `permission_node`) VALUES
(1, '超级管理员', '');

CREATE TABLE `dlgx_school` (
  `id` int(11) NOT NULL,
  `area_id` int(255) NOT NULL COMMENT '地区ID',
  `school_name` varchar(255) NOT NULL COMMENT '学校名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_school` (`id`, `area_id`, `school_name`) VALUES
(1, 2, '浙江大学'),
(3, 1, '安徽师范大学');

CREATE TABLE `dlgx_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `real_name` varchar(255) NOT NULL COMMENT '真实姓名',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `last_login_time` int(11) NOT NULL COMMENT '最近登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '最近登陆IP',
  `login_times` int(11) NOT NULL COMMENT '登录次数',
  `status` int(1) NOT NULL COMMENT '状态：1.启用2.禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_user` (`id`, `username`, `password`, `real_name`, `role_id`, `last_login_time`, `last_login_ip`, `login_times`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '大乐个学', 1, 1473752216, '0.0.0.0', 48, 1);

CREATE TABLE `dlgx_video` (
  `id` int(11) NOT NULL,
  `video_name` varchar(255) NOT NULL COMMENT '视频名称',
  `video_url` varchar(255) NOT NULL COMMENT '视频链接',
  `video_release_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间，0表示不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dlgx_video` (`id`, `video_name`, `video_url`, `video_release_time`) VALUES
(1, '大乐个学', 'http://odfgs4sbe.bkt.clouddn.com/20160913.mp4', 1474089989);

ALTER TABLE `dlgx_activity`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_act_join`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_area`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_club`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_club_apply`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_club_join`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_member`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_node`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_notice`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_school`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dlgx_video`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `dlgx_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `dlgx_act_join`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
ALTER TABLE `dlgx_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `dlgx_club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `dlgx_club_apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `dlgx_club_join`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `dlgx_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `dlgx_node`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
ALTER TABLE `dlgx_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `dlgx_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `dlgx_school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `dlgx_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `dlgx_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
