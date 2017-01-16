/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : thinkyou

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-11-25 18:01:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `think_addons`
-- ----------------------------
DROP TABLE IF EXISTS `think_addons`;
CREATE TABLE `think_addons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) NOT NULL COMMENT '插件名，英文',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '插件名称',
  `description` text COMMENT '插件描述',
  `type` tinyint(2) DEFAULT '0' COMMENT '插件类型, 1:网站；8;微信',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态；1开启；',
  `config` text COMMENT '插件配置',
  `hooks` varchar(255) DEFAULT NULL COMMENT '实现的钩子;以“，”分隔',
  `has_admin` tinyint(2) DEFAULT '0' COMMENT '插件是否有后台管理界面',
  `author` varchar(50) DEFAULT '' COMMENT '插件作者',
  `version` varchar(20) DEFAULT '' COMMENT '插件版本号',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '插件安装时间',
  `listorder` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
-- Records of think_addons
-- ----------------------------
INSERT INTO `think_addons` VALUES ('1', 'Demo', '插件演示', '插件演示', '0', '1', '{\"text\":\"hello,ThinkCMF!\",\"password\":\"\",\"select\":\"1\",\"checkbox\":1,\"radio\":\"1\",\"textarea\":\"\\u8fd9\\u91cc\\u662f\\u4f60\\u8981\\u586b\\u5199\\u7684\\u5185\\u5bb9\"}', 'footer', '1', 'ThinkCMF', '1.0', '0', '0');

-- ----------------------------
-- Table structure for `think_auth_access`
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_access`;
CREATE TABLE `think_auth_access` (
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(255) NOT NULL COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) DEFAULT NULL COMMENT '权限规则分类，请加应用前缀,如admin_',
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限授权表';

-- ----------------------------
-- Records of think_auth_access
-- ----------------------------

-- ----------------------------
-- Table structure for `think_config`
-- ----------------------------
DROP TABLE IF EXISTS `think_config`;
CREATE TABLE `think_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_config
-- ----------------------------
INSERT INTO `think_config` VALUES ('1', 'WEB_SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1378898976', '1479717973', '1', 'ThinkYou后台管理框架', '1');
INSERT INTO `think_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '网站搜索引擎描述', '1378898976', '1478489350', '1', 'ThinkYou后台管理框架', '3');
INSERT INTO `think_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '网站搜索引擎关键字', '1378898976', '1478489315', '1', 'ThinkYou, ThinkYou后台, ThinkYou后台管理', '2');
INSERT INTO `think_config` VALUES ('4', 'WEB_SITE_CLOSE', '4', '关闭站点', '1', '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1378898976', '1478487220', '1', '1', '4');
INSERT INTO `think_config` VALUES ('9', 'CONFIG_TYPE_LIST', '3', '配置类型列表', '8', '', '主要用于数据解析和页面表单的生成', '1378898976', '1478508819', '1', '0:数字\n1:字符\n2:文本\n3:数组\n4:枚举', '13');
INSERT INTO `think_config` VALUES ('10', 'WEB_SITE_ICP', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '1378900335', '1478489378', '1', '沪ICP备12007941号-2', '5');
INSERT INTO `think_config` VALUES ('20', 'CONFIG_GROUP_LIST', '3', '配置分组', '8', '', '', '1379228036', '1478508958', '1', '1:基本\r\n2:用户\r\n3:评论\r\n4:上传\r\n5:备份\r\n\r\n6:邮件\r\n7:过滤\r\n8:系统', '12');
INSERT INTO `think_config` VALUES ('21', 'HOOKS_TYPE', '3', '钩子的类型', '8', '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', '1379313397', '1478508857', '1', '1:视图\n2:控制器', '14');
INSERT INTO `think_config` VALUES ('39', 'REPLAY_NEED_CHECK', '4', '评论审核', '3', '0:需要审核\n1:不需要审核', '', '1478505439', '1478506948', '1', '1', '10');
INSERT INTO `think_config` VALUES ('40', 'REPLAY_TIME_INTERVAL', '0', '评论时间间隔', '3', '', '单位:秒', '1478506521', '1478507967', '1', '60', '11');
INSERT INTO `think_config` VALUES ('25', 'LIST_ROWS', '0', '后台数据每页记录数', '8', '', '', '1379503896', '1478508039', '1', '10', '8');
INSERT INTO `think_config` VALUES ('26', 'USER_ALLOW_REGISTER', '4', '是否允许用户注册', '2', '0:关闭注册\n1:允许注册', '', '1379504487', '1478507991', '1', '1', '6');
INSERT INTO `think_config` VALUES ('28', 'DATA_BACKUP_PATH', '1', '备份根路径', '5', '', '路径必须以 / 结尾', '1381482411', '1479697652', '1', './Data/', '16');
INSERT INTO `think_config` VALUES ('29', 'DATA_BACKUP_PART_SIZE', '0', '数据库备份卷大小', '5', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1381482488', '1381729564', '1', '20971520', '18');
INSERT INTO `think_config` VALUES ('30', 'DATA_BACKUP_COMPRESS', '4', '备份文件是否启用压缩', '5', '0:不压缩\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1381713345', '1479698299', '1', '1', '17');
INSERT INTO `think_config` VALUES ('43', 'UPLOAD_IMAGE_SIZE', '0', '图片最大值', '4', '', '', '1479717055', '1479717055', '1', '10240', '0');
INSERT INTO `think_config` VALUES ('44', 'UPLAOD_IMAGE_TYPE', '1', '图片类型', '4', '', '', '1479717142', '1479721080', '1', 'jpg,jpeg,png,gif', '0');
INSERT INTO `think_config` VALUES ('45', 'UPLAOD_ATTACH_SIZE', '0', '附件最大值', '4', '', '', '1479717189', '1479717262', '1', '10240', '0');
INSERT INTO `think_config` VALUES ('46', 'UPLOAD_ATTACH_TYPE', '1', '附件类型', '4', '', '', '1479717246', '1479717246', '1', 'txt,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar', '0');
INSERT INTO `think_config` VALUES ('47', 'SENSITIVE_WORD_FIELTER', '2', '敏感词', '7', '', '', '1479718202', '1479718202', '1', '', '0');
INSERT INTO `think_config` VALUES ('41', 'REPLAY_LIST_ROWS', '0', '评论列表每页条数', '3', '', '', '1478507819', '1478507819', '1', '10', '9');

-- ----------------------------
-- Table structure for `think_menu`
-- ----------------------------
DROP TABLE IF EXISTS `think_menu`;
CREATE TABLE `think_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `app` char(20) NOT NULL COMMENT '应用名称app',
  `model` char(20) NOT NULL COMMENT '控制器',
  `action` char(20) NOT NULL COMMENT '操作名称',
  `data` char(50) NOT NULL COMMENT '额外参数',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`),
  KEY `model` (`model`)
) ENGINE=MyISAM AUTO_INCREMENT=208 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of think_menu
-- ----------------------------
INSERT INTO `think_menu` VALUES ('162', '0', 'Admin', 'Menu', 'default', '', '0', '1', '菜单管理', 'fa-list', '', '3');
INSERT INTO `think_menu` VALUES ('163', '162', 'Admin', 'Menu', 'index', '', '1', '1', '后台菜单', '', '', '0');
INSERT INTO `think_menu` VALUES ('164', '163', 'Admin', 'Menu', 'add', '', '1', '0', '添加菜单', '', '', '0');
INSERT INTO `think_menu` VALUES ('165', '163', 'Admin', 'Menu', 'edit', '', '1', '0', '编辑菜单', '', '', '0');
INSERT INTO `think_menu` VALUES ('166', '163', 'Admin', 'Menu', 'delete', '', '1', '0', '删除菜单', '', '', '0');
INSERT INTO `think_menu` VALUES ('167', '163', 'Admin', 'Menu', 'sort', '', '1', '0', '菜单排序', '', '', '0');
INSERT INTO `think_menu` VALUES ('168', '173', 'Admin', 'Config', 'index', '', '1', '1', '配置管理', '', '', '0');
INSERT INTO `think_menu` VALUES ('170', '168', 'Admin', 'Config', 'edit', '', '1', '0', '编辑配置', '', '', '0');
INSERT INTO `think_menu` VALUES ('169', '168', 'Admin', 'Config', 'add', '', '1', '0', '添加配置', '', '', '0');
INSERT INTO `think_menu` VALUES ('171', '168', 'Admin', 'Config', 'delete', '', '1', '0', '删除配置', '', '', '0');
INSERT INTO `think_menu` VALUES ('172', '168', 'Admin', 'Config', 'sort', '', '1', '0', '配置排序', '', '', '0');
INSERT INTO `think_menu` VALUES ('173', '0', 'Admin', 'Setting', 'default', '', '0', '1', '设置', 'fa-cogs', '', '1');
INSERT INTO `think_menu` VALUES ('174', '173', 'Admin', 'Config', 'group', '', '1', '1', '网站信息', '', '', '0');
INSERT INTO `think_menu` VALUES ('175', '164', 'Admin', 'Menu', 'do_add', '', '1', '0', '提交添加', '', '', '0');
INSERT INTO `think_menu` VALUES ('176', '165', 'Admin', 'Menu', 'do_edit', '', '1', '0', '提交编辑', '', '', '0');
INSERT INTO `think_menu` VALUES ('177', '169', 'Admin', 'Config', 'do_add', '', '1', '0', '提交添加', '', '', '0');
INSERT INTO `think_menu` VALUES ('178', '170', 'Admin', 'Config', 'do_edit', '', '1', '0', '提交编辑', '', '', '0');
INSERT INTO `think_menu` VALUES ('179', '0', 'User', '1', '1', '', '0', '1', '用户管理', 'fa-group', '', '2');
INSERT INTO `think_menu` VALUES ('180', '179', 'User', '2', '2', '', '0', '1', '管理组', '', '', '0');
INSERT INTO `think_menu` VALUES ('181', '180', 'Admin', 'Rbac', 'index', '', '1', '1', '角色管理', '', '', '0');
INSERT INTO `think_menu` VALUES ('182', '181', 'Admin', 'Rbac', 'add', '', '1', '0', '添加角色', '', '', '0');
INSERT INTO `think_menu` VALUES ('183', '182', 'Admin', 'Rbac', 'do_add', '', '1', '0', '提交添加', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('184', '181', 'Admin', 'Rbac', 'edit', '', '1', '0', '编辑角色', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('185', '184', 'Admin', 'Rbac', 'do_edit', '', '1', '0', '提交编辑', ' ', '', '0');
INSERT INTO `think_menu` VALUES ('186', '181', 'Admin', 'Rbac', 'authority', '', '1', '0', '角色授权', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('187', '186', 'Admin', 'Rbac', 'do_authority', '', '1', '0', '提交授权', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('188', '181', 'Admin', 'Rbac', 'delete', '', '1', '0', '删除角色', '', '', '0');
INSERT INTO `think_menu` VALUES ('189', '180', 'Admin', 'User', 'index', '', '1', '1', '管理员', '', '', '0');
INSERT INTO `think_menu` VALUES ('190', '189', 'Admin', 'User', 'add', '', '1', '0', '管理员添加', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('191', '190', 'Admin', 'User', 'do_add', '', '1', '0', '提交添加', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('192', '189', 'Admin', 'User', 'edit', '', '1', '0', '管理员编辑', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('193', '192', 'Admin', 'User', 'do_edit', '', '1', '0', '提交编辑', ' ', '', '0');
INSERT INTO `think_menu` VALUES ('194', '189', 'Admin', 'User', 'delete', '', '1', '0', '删除管理员', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('195', '189', 'Admin', 'User', 'ban', '', '1', '0', '拉黑', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('196', '189', 'Admin', 'User', 'cancelban', '', '1', '0', '启用', ' ', ' ', '0');
INSERT INTO `think_menu` VALUES ('197', '0', 'Admin', '1', '1', '', '0', '1', '扩展工具', 'fa-cloud', '', '4');
INSERT INTO `think_menu` VALUES ('198', '197', 'Admin', 'Addons', 'index', '', '1', '1', '插件管理', '', '', '0');
INSERT INTO `think_menu` VALUES ('199', '197', 'Admin', 'Route', 'index', '', '1', '1', '路由管理', '', '', '0');
INSERT INTO `think_menu` VALUES ('200', '199', 'Admin', 'Route', 'add', '', '1', '0', '添加路由', '', '', '0');
INSERT INTO `think_menu` VALUES ('201', '200', 'Admin', 'Route', 'do_add', '', '1', '0', '提交添加', '', '', '0');
INSERT INTO `think_menu` VALUES ('202', '199', 'Admin', 'Route', 'edit', '', '1', '0', '编辑路由', '', '', '0');
INSERT INTO `think_menu` VALUES ('203', '202', 'Admin', 'Route', 'do_edit', '', '1', '0', '提交编辑', '', '', '0');
INSERT INTO `think_menu` VALUES ('204', '199', 'Admin', 'Route', 'delete', '', '1', '0', '路由删除', '', '', '0');
INSERT INTO `think_menu` VALUES ('205', '199', 'Admin', 'Route', 'sort', '', '1', '0', '排序', '', '', '0');
INSERT INTO `think_menu` VALUES ('206', '199', 'Admin', 'Route', 'open', '', '1', '0', '开启', '', '', '0');
INSERT INTO `think_menu` VALUES ('207', '199', 'Admin', 'Route', 'ban', '', '1', '0', '禁用', '', '', '0');

-- ----------------------------
-- Table structure for `think_role`
-- ----------------------------
DROP TABLE IF EXISTS `think_role`;
CREATE TABLE `think_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '角色名称',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` int(3) NOT NULL DEFAULT '0' COMMENT '排序字段',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of think_role
-- ----------------------------
INSERT INTO `think_role` VALUES ('1', '超级管理员', '1', '拥有网站最高管理员权限！', '1329633709', '1329633709', '0');
INSERT INTO `think_role` VALUES ('2', '测试', '1', 'only for test', '1473155449', '0', '0');

-- ----------------------------
-- Table structure for `think_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_role_user`;
CREATE TABLE `think_role_user` (
  `role_id` int(11) unsigned DEFAULT '0' COMMENT '角色 id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

-- ----------------------------
-- Records of think_role_user
-- ----------------------------
INSERT INTO `think_role_user` VALUES ('2', '2');

-- ----------------------------
-- Table structure for `think_route`
-- ----------------------------
DROP TABLE IF EXISTS `think_route`;
CREATE TABLE `think_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '路由id',
  `full_url` varchar(255) DEFAULT NULL COMMENT '完整url， 如：portal/list/index?id=1',
  `url` varchar(255) DEFAULT NULL COMMENT '实际显示的url',
  `listorder` int(5) DEFAULT '0' COMMENT '排序，优先级，越小优先级越高',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1：启用 ;0：不启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='url路由表';

-- ----------------------------
-- Records of think_route
-- ----------------------------

-- ----------------------------
-- Table structure for `think_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_user`;
CREATE TABLE `think_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码；sp_password加密',
  `user_nicename` varchar(50) NOT NULL DEFAULT '' COMMENT '用户美名',
  `user_email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `user_url` varchar(100) NOT NULL DEFAULT '' COMMENT '用户个人网站',
  `avatar` varchar(255) DEFAULT NULL COMMENT '用户头像，相对于upload/avatar目录',
  `sex` smallint(1) DEFAULT '0' COMMENT '性别；0：保密，1：男；2：女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `signature` varchar(255) DEFAULT NULL COMMENT '个性签名',
  `last_login_ip` varchar(16) DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00' COMMENT '最后登录时间',
  `create_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00' COMMENT '注册时间',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '' COMMENT '激活码',
  `user_status` int(11) NOT NULL DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `user_type` smallint(1) DEFAULT '1' COMMENT '用户类型，1:admin ;2:会员',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of think_user
-- ----------------------------
INSERT INTO `think_user` VALUES ('1', 'admin', '###c318eabc9e0abae29cf340f9882e5e5f', 'admin', '569697210@qq.com', '', null, '0', '2016-09-27', '', '0.0.0.0', '2016-10-25 11:33:50', '2016-08-23 05:48:26', '', '1', '0', '1', '0', '');
INSERT INTO `think_user` VALUES ('2', 'test', '###c318eabc9e0abae29cf340f9882e5e5f', '', 'wang569697210@qq.com', '', null, '0', null, null, '0.0.0.0', '2016-09-06 17:59:52', '2016-09-06 17:51:38', '', '1', '0', '1', '0', '');
