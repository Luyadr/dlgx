-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-09-13 08:16:23
-- 服务器版本： 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dlgx`
--

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_activity`
--

CREATE TABLE `dlgx_activity` (
  `id` int(11) NOT NULL,
  `act_name` varchar(255) NOT NULL COMMENT '名称',
  `act_intro` varchar(255) NOT NULL COMMENT '简介',
  `act_list_img` varchar(255) NOT NULL COMMENT '列表图',
  `act_detail_img` varchar(255) NOT NULL COMMENT '详情图',
  `act_release_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `act_start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `act_end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `act_address` varchar(255) NOT NULL COMMENT '地点',
  `act_money` int(11) NOT NULL DEFAULT '0' COMMENT '费用',
  `act_member_num` int(11) NOT NULL DEFAULT '0' COMMENT '会员数量',
  `act_from_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布社团ID，默认0为官方',
  `act_status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1.发布2.不发布',
  `act_corp_id` varchar(255) NOT NULL COMMENT '承办社团ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dlgx_activity`
--

INSERT INTO `dlgx_activity` (`id`, `act_name`, `act_intro`, `act_list_img`, `act_detail_img`, `act_release_time`, `act_start_time`, `act_end_time`, `act_address`, `act_money`, `act_member_num`, `act_from_id`, `act_status`, `act_corp_id`) VALUES
(2, '大乐个学', '大乐个学大乐个学大乐个学大乐个学大乐个学', 'http://od6cy404z.bkt.clouddn.com/41871201609091931246731.png', '0', 1472641999, 1472572800, 1472659199, '大乐个学大乐个学大乐个学', 5000, 0, 0, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_area`
--

CREATE TABLE `dlgx_area` (
  `id` int(11) NOT NULL,
  `area_name` varchar(255) NOT NULL COMMENT '地区名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dlgx_area`
--

INSERT INTO `dlgx_area` (`id`, `area_name`) VALUES
(1, '芜湖'),
(2, '杭州');

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_corporation`
--

CREATE TABLE `dlgx_corporation` (
  `id` int(11) NOT NULL,
  `corp_name` varchar(255) NOT NULL COMMENT '名称',
  `corp_img` varchar(255) NOT NULL COMMENT '团标',
  `corp_level` int(11) NOT NULL DEFAULT '1' COMMENT '级别：1.兴趣社团2.院级组织3.校级组织',
  `corp_intro` varchar(255) NOT NULL COMMENT '简介',
  `corp_status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：1.待审核2.通过',
  `corp_owner_id` int(11) NOT NULL COMMENT '团长ID',
  `corp_create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dlgx_corporation`
--

INSERT INTO `dlgx_corporation` (`id`, `corp_name`, `corp_img`, `corp_level`, `corp_intro`, `corp_status`, `corp_owner_id`, `corp_create_time`) VALUES
(1, '大乐个学', 'hello', 1, '大乐个学大乐个学大乐个学大乐个学大乐个学', 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_member`
--

CREATE TABLE `dlgx_member` (
  `id` int(11) NOT NULL,
  `member_name` varchar(255) DEFAULT NULL COMMENT '名称',
  `member_sex` int(1) DEFAULT NULL COMMENT '性别',
  `member_school` varchar(255) DEFAULT NULL COMMENT '学校',
  `member_department` varchar(255) DEFAULT NULL COMMENT '院系',
  `member_class` varchar(255) DEFAULT NULL COMMENT '专业班级',
  `member_tel` varchar(11) DEFAULT NULL COMMENT '手机',
  `last_login_time` int(11) NOT NULL COMMENT '最近登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '最近登录IP',
  `member_create_time` int(11) NOT NULL COMMENT '注册时间',
  `member_type` int(1) NOT NULL DEFAULT '1' COMMENT '类型：1.成员2.团长',
  `member_idcard` varchar(18) DEFAULT NULL COMMENT '身份证号',
  `member_openid` varchar(255) NOT NULL COMMENT '微信openid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_node`
--

CREATE TABLE `dlgx_node` (
  `id` int(11) NOT NULL,
  `node_name` varchar(255) NOT NULL COMMENT '节点名称',
  `module_name` varchar(255) NOT NULL COMMENT '模块名称',
  `controller_name` varchar(255) NOT NULL COMMENT '控制器名称',
  `action_name` varchar(255) NOT NULL COMMENT '方法名称',
  `is_menu` int(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项：1.不是2.是',
  `father_node_id` int(11) NOT NULL COMMENT '父节点ID',
  `style` varchar(255) DEFAULT NULL COMMENT '样式'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dlgx_node`
--

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

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_notice`
--

CREATE TABLE `dlgx_notice` (
  `id` int(11) NOT NULL,
  `notice_title` varchar(255) NOT NULL COMMENT '标题',
  `notice_from_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布社团ID，默认0为官方',
  `notice_release_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `notice_content` text NOT NULL COMMENT '内容',
  `notice_status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：1.发布2.不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
) ;

--
-- 转存表中的数据 `dlgx_notice`
--

INSERT INTO `dlgx_notice` (`id`, `notice_title`, `notice_from_id`, `notice_release_time`, `notice_content`, `notice_status`) VALUES
(2, '大乐个学上线啦！', 0, 1472560409, '大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！大乐个学上线啦！', 1);

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_role`
--

CREATE TABLE `dlgx_role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL COMMENT '角色名称',
  `permission_node` varchar(255) DEFAULT NULL COMMENT AS `权限节点`
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dlgx_role`
--

INSERT INTO `dlgx_role` (`id`, `role_name`, `permission_node`) VALUES
(1, '超级管理员', ''),
(2, '管理员', '3');

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_school`
--

CREATE TABLE `dlgx_school` (
  `id` int(11) NOT NULL,
  `area_id` int(255) NOT NULL COMMENT '地区ID',
  `school_name` varchar(255) NOT NULL COMMENT '学校名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dlgx_school`
--

INSERT INTO `dlgx_school` (`id`, `area_id`, `school_name`) VALUES
(1, 2, '浙江大学'),
(2, 2, '浙江工业大学'),
(3, 1, '安徽师范大学'),
(4, 1, '皖南医学院');

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_user`
--

CREATE TABLE `dlgx_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `login_times` int(11) NOT NULL DEFAULT '0'COMMENT '登录次数',
  `last_login_time` int(11) NOT NULL DEFAULT '0'COMMENT '最近登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '最近登陆IP',
  `real_name` varchar(255) NOT NULL COMMENT '真实姓名',
  `status` int(1) NOT NULL DEFAULT '1'COMMENT '状态：1.启用2.禁用',
  `role_id` int(11) NOT NULL COMMENT '角色ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
) ;

--
-- 转存表中的数据 `dlgx_user`
--

INSERT INTO `dlgx_user` (`id`, `username`, `password`, `login_times`, `last_login_time`, `last_login_ip`, `real_name`, `status`, `role_id`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 48, 1473752216, '0.0.0.0', '大乐个学', 1, 1),
(2, 'Luyadr', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, '', 'Luyadr', 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `dlgx_video`
--

CREATE TABLE `dlgx_video` (
  `id` int(11) NOT NULL,
  `video_name` varchar(255) NOT NULL COMMENT '描述',
  `video_url` varchar(255) NOT NULL COMMENT '链接',
  `video_time` int(11) NOT NULL COMMENT '时长',
  `video_size` varchar(255) NOT NULL COMMENT '大小',
  `video_release_time` int(11) NOT NULL COMMENT '发布时间',
  `video_status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：1.发布2.不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dlgx_activity`
--
ALTER TABLE `dlgx_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dlgx_area`
--
ALTER TABLE `dlgx_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dlgx_corporation`
--
ALTER TABLE `dlgx_corporation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dlgx_member`
--
ALTER TABLE `dlgx_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dlgx_node`
--
ALTER TABLE `dlgx_node`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dlgx_role`
--
ALTER TABLE `dlgx_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dlgx_school`
--
ALTER TABLE `dlgx_school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dlgx_user`
--
ALTER TABLE `dlgx_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dlgx_video`
--
ALTER TABLE `dlgx_video`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dlgx_activity`
--
ALTER TABLE `dlgx_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `dlgx_area`
--
ALTER TABLE `dlgx_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `dlgx_corporation`
--
ALTER TABLE `dlgx_corporation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `dlgx_member`
--
ALTER TABLE `dlgx_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `dlgx_node`
--
ALTER TABLE `dlgx_node`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- 使用表AUTO_INCREMENT `dlgx_notice`
--
ALTER TABLE `dlgx_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `dlgx_role`
--
ALTER TABLE `dlgx_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `dlgx_school`
--
ALTER TABLE `dlgx_school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `dlgx_user`
--
ALTER TABLE `dlgx_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `dlgx_video`
--
ALTER TABLE `dlgx_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
