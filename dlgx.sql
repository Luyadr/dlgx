# Host: localhost  (Version 5.7.11)
# Date: 2016-09-22 15:10:59
# Generator: MySQL-Front 5.4  (Build 1.21)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "dlgx_act_join"
#

DROP TABLE IF EXISTS `dlgx_act_join`;
CREATE TABLE `dlgx_act_join` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `act_id` int(11) NOT NULL COMMENT '活动ID',
  `member_id` int(11) NOT NULL COMMENT '会员ID',
  `join_time` int(11) NOT NULL COMMENT '参加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_act_join"
#


#
# Structure for table "dlgx_activity"
#

DROP TABLE IF EXISTS `dlgx_activity`;
CREATE TABLE `dlgx_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `act_name` varchar(255) NOT NULL COMMENT '活动名称',
  `act_intro` varchar(255) NOT NULL COMMENT '活动简介',
  `act_list_img` varchar(255) NOT NULL COMMENT '活动列表图',
  `act_detail_img` varchar(255) NOT NULL COMMENT '活动详情图',
  `act_create_time` int(11) NOT NULL COMMENT '创建时间',
  `act_release_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间，0表示不发布',
  `act_start_time` int(11) NOT NULL COMMENT '开始时间',
  `act_end_time` int(11) NOT NULL COMMENT '结束时间',
  `act_address` varchar(255) NOT NULL COMMENT '活动地点',
  `act_money` int(11) NOT NULL COMMENT '活动费用',
  `act_from_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布社团ID，0表示官方',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_activity"
#

INSERT INTO `dlgx_activity` VALUES (1,'大乐个学上线啦!','大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!','http://odfgs4sbe.bkt.clouddn.com/activity_list.png','http://odfgs4sbe.bkt.clouddn.com/activity_detail.png',1474438202,1474438202,1474387200,1474473600,'大乐个学',0,0);

#
# Structure for table "dlgx_area"
#

DROP TABLE IF EXISTS `dlgx_area`;
CREATE TABLE `dlgx_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(255) NOT NULL COMMENT '地区名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_area"
#

INSERT INTO `dlgx_area` VALUES (1,'芜湖'),(2,'杭州');

#
# Structure for table "dlgx_club"
#

DROP TABLE IF EXISTS `dlgx_club`;
CREATE TABLE `dlgx_club` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_icon` varchar(255) DEFAULT NULL COMMENT '社团团标',
  `club_name` varchar(255) NOT NULL COMMENT '社团名称',
  `club_level` int(11) NOT NULL COMMENT '社团级别：1.兴趣社团2.院级组织3.校级组织',
  `club_intro` varchar(255) NOT NULL COMMENT '社团简介',
  `club_school` varchar(255) NOT NULL COMMENT '社团学校',
  `club_owner_id` int(11) NOT NULL COMMENT '社团团长ID',
  `club_status` int(1) NOT NULL DEFAULT '1' COMMENT '社团状态：1.启用2.禁用',
  `club_create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_club"
#

INSERT INTO `dlgx_club` VALUES (1,'','社团联合会',3,'（暂无简介）','浙江大学',8,1,1474440451);

#
# Structure for table "dlgx_club_apply"
#

DROP TABLE IF EXISTS `dlgx_club_apply`;
CREATE TABLE `dlgx_club_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_icon` varchar(255) DEFAULT NULL COMMENT '社团团标',
  `club_name` varchar(255) NOT NULL COMMENT '社团名称',
  `club_level` int(1) NOT NULL COMMENT '社团级别：1.兴趣社团2.院级组织3.校级组织',
  `club_intro` varchar(255) NOT NULL DEFAULT '（暂无简介）' COMMENT '社团简介',
  `club_school` varchar(255) NOT NULL COMMENT '社团学校',
  `club_owner_id` int(11) NOT NULL COMMENT '社团团长ID',
  `club_owner_idcard` varchar(255) NOT NULL COMMENT '社团团长身份证号',
  `apply_time` int(11) NOT NULL COMMENT '申请时间',
  `verify_status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：1.审核中2.已通过3.已拒绝',
  `verify_idea` varchar(255) DEFAULT NULL COMMENT '审核意见',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_club_apply"
#

INSERT INTO `dlgx_club_apply` VALUES (1,'','社团联合会',3,'（暂无简介）','浙江大学',8,'330724199403020337',1474439473,2,'ok');

#
# Structure for table "dlgx_club_join"
#

DROP TABLE IF EXISTS `dlgx_club_join`;
CREATE TABLE `dlgx_club_join` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL COMMENT '社团ID',
  `member_id` int(11) NOT NULL COMMENT '会员ID',
  `apply_time` int(11) NOT NULL COMMENT '申请时间',
  `verify_status` int(1) NOT NULL DEFAULT '1' COMMENT '审核状态：1.审核中2.已通过3.已拒绝',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_club_join"
#


#
# Structure for table "dlgx_image"
#

DROP TABLE IF EXISTS `dlgx_image`;
CREATE TABLE `dlgx_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) NOT NULL COMMENT '图片名称',
  `image_url` varchar(255) NOT NULL COMMENT '图片链接',
  `image_create_time` int(11) NOT NULL COMMENT '图片创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_image"
#


#
# Structure for table "dlgx_member"
#

DROP TABLE IF EXISTS `dlgx_member`;
CREATE TABLE `dlgx_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_openid` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '微信openid',
  `member_icon` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '会员头像',
  `member_name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '会员名称',
  `member_intro` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '（暂无简介）' COMMENT '会员简介',
  `real_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '真实姓名',
  `member_sex` int(1) DEFAULT NULL COMMENT '性别：1.男2.女',
  `member_school` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '学校',
  `member_department` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '院系',
  `member_class` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '专业班级',
  `member_tel` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '手机',
  `member_idcard` varchar(18) CHARACTER SET utf8 DEFAULT NULL COMMENT '身份证号',
  `last_login_time` int(11) NOT NULL COMMENT '最近登录时间',
  `last_login_ip` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '最近登录IP',
  `login_times` int(11) NOT NULL COMMENT '登录次数',
  `member_create_time` int(11) NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

#
# Data for table "dlgx_member"
#

INSERT INTO `dlgx_member` VALUES (8,'okwqYuHtN4ILnUbpWwB8SgnrRMxM','http://wx.qlogo.cn/mmopen/M9FNTEk9xmSeiaa0rELiaAnV701jxRzphj5MtyuaOfz0GqfWTs26mv3ssQ5oPHibcKskficUUTsw9SJLqunnrd9hL6IMNzMrXXhM/0','Luyadr','（暂无简介）','卢阳安',1,'浙江大学','信息工程学院','信管121班','18868196393',NULL,1474463288,'127.0.0.1',11,1474350298),(9,'okwqYuAnhTGU9YiR0BruEX8hgL5w','http://wx.qlogo.cn/mmopen/PiajxSqBRaEJDaB2QJMSHGokpfI6kYaolg4fSwbTLKnwv8NRITYMPeviak5CgeWIHaiaaiaAhvfibeJujibDEIIOSX4g/0','s:7:\"@阿楠\";','（暂无简介）',NULL,1,NULL,NULL,NULL,NULL,NULL,1474444636,'127.0.0.1',2,1474353981),(10,'okwqYuIKfvxmagWwV9yJ6ty4JKjY','http://wx.qlogo.cn/mmopen/hz6YBYkvRQ110qCdsBufav655AogkOGX0TCsUfichLbmTZwUqsrqo8fQKRaKPUvyWQM3Jx64xzPEribWD5ktmGOQ/0','小黄酱黄晨昱','（暂无简介）',NULL,1,NULL,NULL,NULL,NULL,NULL,1474463123,'127.0.0.1',6,1474443068),(11,'okwqYuJBWbfwpIlvltu1SY2zx5lM','http://wx.qlogo.cn/mmopen/PiajxSqBRaEKvFPFdN0UE0dKIW0vvQmgslN1oUXxmRt7ictTdLw3QHYQMttPibjAOcgtwjjlLhO3b2J3ysuntzRicg/0','花生米','（暂无简介）',NULL,1,NULL,NULL,NULL,NULL,NULL,1474451811,'127.0.0.1',1,1474451811);

#
# Structure for table "dlgx_node"
#

DROP TABLE IF EXISTS `dlgx_node`;
CREATE TABLE `dlgx_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(255) NOT NULL COMMENT '节点名称',
  `module_name` varchar(255) NOT NULL COMMENT '模块名称',
  `controller_name` varchar(255) NOT NULL COMMENT '控制器名称',
  `action_name` varchar(255) NOT NULL COMMENT '方法名称',
  `is_menu` int(1) NOT NULL COMMENT '是否是菜单项：1.不是2.是',
  `father_node_id` int(11) NOT NULL COMMENT '父节点ID',
  `style` varchar(255) DEFAULT NULL COMMENT '样式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_node"
#

INSERT INTO `dlgx_node` VALUES (1,'系统管理','#','#','#',2,0,'fa fa-desktop'),(2,'后台管理','#','#','#',2,0,'fa fa-users'),(3,'业务管理','#','#','#',2,0,'fa fa-edit'),(4,'节点列表','admin','node','index',2,1,''),(5,'数据备份/还原','admin','data','index',2,1,''),(6,'角色列表','admin','role','index',2,2,''),(7,'用户列表','admin','user','index',2,2,''),(8,'官方活动','admin','activity','index',2,3,''),(9,'官方公告','admin','notice','index',2,3,''),(11,'添加节点','admin','node','add',1,1,''),(12,'编辑节点','admin','node','edit',1,1,''),(13,'删除节点','admin','node','del',1,1,''),(15,'数据备份','admin','data','backup',1,1,''),(16,'数据还原','admin','data','recover',1,1,''),(17,'添加角色','admin','role','add',1,2,''),(18,'编辑角色','admin','role','edit',1,2,''),(19,'删除角色','admin','role','del',1,2,''),(20,'添加用户','admin','user','add',1,2,''),(21,'编辑用户','admin','user','edit',1,2,''),(22,'删除用户','admin','user','del',1,2,''),(23,'添加活动','admin','activity','add',1,3,''),(24,'编辑活动','admin','activity','edit',1,3,''),(25,'删除活动','admin','activity','del',1,3,''),(26,'添加公告','admin','notice','add',1,3,''),(27,'编辑公告','admin','notice','edit',1,3,''),(28,'删除公告','admin','notice','del',1,3,''),(29,'分配权限','admin','role','givepermission',1,2,''),(31,'视频管理','admin','video','index',2,3,''),(32,'添加视频','admin','video','add',1,3,''),(33,'编辑视频','admin','video','edit',1,3,''),(37,'社团管理','admin','club','index',2,3,''),(38,'添加社团','admin','club','add',1,3,''),(39,'编辑社团','admin','club','edit',1,3,''),(40,'删除社团','admin','club','del',1,3,''),(41,'社团审核','admin','club','apply',2,3,''),(42,'编辑社团审核','admin','club','editapply',1,3,''),(43,'图片管理','admin','image','index',2,3,''),(44,'图片上传','admin','image','upload',1,3,''),(45,'图片删除','admin','image','del',1,3,'');

#
# Structure for table "dlgx_notice"
#

DROP TABLE IF EXISTS `dlgx_notice`;
CREATE TABLE `dlgx_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_title` varchar(255) NOT NULL COMMENT '公告标题',
  `notice_content` text NOT NULL COMMENT '公告内容',
  `notice_from_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布社团ID，0表示官方',
  `notice_release_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间，0表示不发布',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_notice"
#

INSERT INTO `dlgx_notice` VALUES (1,'大乐个学','大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!大乐个学上线啦!',0,1474438282);

#
# Structure for table "dlgx_role"
#

DROP TABLE IF EXISTS `dlgx_role`;
CREATE TABLE `dlgx_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL COMMENT '角色名称',
  `permission_node` varchar(255) DEFAULT NULL COMMENT '权限节点',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_role"
#

INSERT INTO `dlgx_role` VALUES (1,'超级管理员','');

#
# Structure for table "dlgx_school"
#

DROP TABLE IF EXISTS `dlgx_school`;
CREATE TABLE `dlgx_school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(255) NOT NULL COMMENT '地区ID',
  `school_name` varchar(255) NOT NULL COMMENT '学校名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_school"
#

INSERT INTO `dlgx_school` VALUES (1,2,'浙江大学'),(3,1,'安徽师范大学');

#
# Structure for table "dlgx_send_code"
#

DROP TABLE IF EXISTS `dlgx_send_code`;
CREATE TABLE `dlgx_send_code` (
  `member_id` int(11) NOT NULL,
  `msg_code` int(4) NOT NULL COMMENT '短信验证码',
  `send_time` int(11) NOT NULL COMMENT '发送时间',
  `today` int(11) NOT NULL COMMENT '当天',
  `send_times` int(11) NOT NULL COMMENT '发送次数',
  `check_times` int(11) NOT NULL COMMENT '验证次数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_send_code"
#

INSERT INTO `dlgx_send_code` VALUES (8,9935,1474463294,1474387200,4,5),(10,2885,1474444468,1474387200,1,0);

#
# Structure for table "dlgx_user"
#

DROP TABLE IF EXISTS `dlgx_user`;
CREATE TABLE `dlgx_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `real_name` varchar(255) NOT NULL COMMENT '真实姓名',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `last_login_time` int(11) NOT NULL COMMENT '最近登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '最近登陆IP',
  `login_times` int(11) NOT NULL COMMENT '登录次数',
  `status` int(1) NOT NULL COMMENT '状态：1.启用2.禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_user"
#

INSERT INTO `dlgx_user` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','大乐个学',1,1474528069,'127.0.0.1',74,1);

#
# Structure for table "dlgx_video"
#

DROP TABLE IF EXISTS `dlgx_video`;
CREATE TABLE `dlgx_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_name` varchar(255) NOT NULL COMMENT '视频名称',
  `video_url` varchar(255) NOT NULL COMMENT '视频链接',
  `video_release_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间，0表示不发布',
  `video_create_time` int(11) NOT NULL COMMENT '视频创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "dlgx_video"
#

INSERT INTO `dlgx_video` VALUES (1,'大乐个学','http://odfgs4sbe.bkt.clouddn.com/20160913.mp4',1474469306,1474438304);
