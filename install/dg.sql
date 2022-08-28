CREATE DATABASE IF NOT EXISTS `daogou_server`;

USE `daogou_server`;

DROP TABLE IF EXISTS `bs_admin`;

CREATE TABLE `bs_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `account` varchar(32) NOT NULL DEFAULT '' COMMENT '登录账号',
  `pwd` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(10) NOT NULL DEFAULT '' COMMENT '随机盐',
  `add_time` int(10) DEFAULT '0',
  `up_time` int(10) unsigned DEFAULT '0',
  `user_desc` varchar(255) DEFAULT '' COMMENT '简单描述',
  `role_id` int(10) unsigned DEFAULT '0' COMMENT '角色编号',
  `uid` varchar(50) DEFAULT '' COMMENT '唯一标识',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-禁用，1-启用',
  `pwd_err_count` tinyint(1) NOT NULL DEFAULT '0' COMMENT '密码错误次数',
  `loginCount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_admin` VALUES("1","小微","admin","自己看代码加密填充","Q30oFK20Es","1638252433","1655880940","test","0","bs515a10462d9e486294741398f8a224f5","1","0","83");



DROP TABLE IF EXISTS `bs_admin_action_log`;

CREATE TABLE `bs_admin_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text,
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员uid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=620 DEFAULT CHARSET=utf8mb4 COMMENT='管理员操作日志';




DROP TABLE IF EXISTS `bs_admin_login_log`;

CREATE TABLE `bs_admin_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS `bs_admin_menu`;

CREATE TABLE `bs_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '菜单名称',
  `fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0-已禁用，1-启用中',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1-菜单类型，0-功能类型（不在左侧显示）',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1-显示“new”字样',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '菜单链接',
  `qx_str` varchar(100) NOT NULL DEFAULT '' COMMENT '权限标识',
  `class_name` varchar(100) NOT NULL DEFAULT '' COMMENT 'css样式class',
  `sort` int(10) DEFAULT '0' COMMENT '越大越靠前',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4 COMMENT='后台管理菜单';

INSERT INTO `bs_admin_menu` VALUES("2","管理员","0","1","1","0","/admin/auth.auser/index","@admin@auth@auser@index","fa-users","-1");
INSERT INTO `bs_admin_menu` VALUES("9","权限菜单","2","1","1","0","/admin/auth.index/menu","@admin@auth@index@menu","fa-project-diagram","0");
INSERT INTO `bs_admin_menu` VALUES("11","操作菜单","9","1","0","0","/admin/auth.index/action","@admin@auth@index@action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("12","操作管理员","23","1","1","0","/admin/auth.auser/action","@admin@auth@auser@action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("23","管理员列表","2","1","1","0","/admin/auth.auser/index","@admin@auth@auser@index","fa-users","0");
INSERT INTO `bs_admin_menu` VALUES("24","角色管理","2","1","1","0","/admin/auth.auser/role","@admin@auth@auser@role","fa-user-tag","0");
INSERT INTO `bs_admin_menu` VALUES("25","角色操作","24","1","0","0","/admin/auth.auther/role_action","@admin@auth@auther@role_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("27","操作表单","23","1","0","0","/admin/auth.auser/form","@admin@auth@auser@form","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("28","权限管理","24","1","0","0","/admin/auth.auser/role_set","@admin@auth@auser@role_set","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("29","权限操作","24","1","0","0","/admin/auth.auser/role_auth_action","@admin@auth@auser@role_auth_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("30","操作表单","9","1","0","0","/admin/auth.index/form","@admin@auth@index@form","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("32","订单管理","0","1","1","0","/admin/order.index/index","@admin@order@index@index","fa-database","998");
INSERT INTO `bs_admin_menu` VALUES("33","订单列表","32","1","1","0","/admin/order.index/index","@admin@order@index@index","fa-list-ul","0");
INSERT INTO `bs_admin_menu` VALUES("36","商城设置","0","1","1","0","/admin/shop.nav/index","@admin@shop@nav@index","fa-cart-plus","0");
INSERT INTO `bs_admin_menu` VALUES("37","轮播图管理","36","1","1","0","/admin/shop.banner/index","@admin@shop@banner@index","fa-images","1");
INSERT INTO `bs_admin_menu` VALUES("38","导航管理","36","1","1","0","/admin/shop.nav/index","@admin@shop@nav@index","fa-location-arrow","1");
INSERT INTO `bs_admin_menu` VALUES("39","公告管理","36","1","1","0","/admin/shop.notice/index","@admin@shop@notice@index","fa-volume-up","1");
INSERT INTO `bs_admin_menu` VALUES("40","基本配置","36","1","1","0","/admin/shop.setting/index","@admin@shop@setting@index","fa-tools","1");
INSERT INTO `bs_admin_menu` VALUES("41","会员管理","0","1","1","0","/admin/user.index/index","@admin@user@index@index","fa-users","1");
INSERT INTO `bs_admin_menu` VALUES("42","会员列表","41","1","1","0","/admin/user.index/index","@admin@user@index@index","fa-user-friends","2");
INSERT INTO `bs_admin_menu` VALUES("44","财务管理","0","1","1","0","/admin/caiwu.index/credit","@admin@caiwu@index@credit","fa-cog","2");
INSERT INTO `bs_admin_menu` VALUES("46","积分记录","44","1","1","0","/admin/caiwu.index/point","@admin@caiwu@index@point","fa-gift","0");
INSERT INTO `bs_admin_menu` VALUES("47","余额记录","44","1","1","0","/admin/caiwu.index/credit","@admin@caiwu@index@credit","fa-credit-card","0");
INSERT INTO `bs_admin_menu` VALUES("48","日志管理","0","1","1","0","/admin/log.index/verifycode","@admin@log@index@verifycode","fa-clipboard-list","0");
INSERT INTO `bs_admin_menu` VALUES("49","异常日志","48","1","1","0","/admin/log.index/error_log","@admin@log@index@error_log","fa-bug","1");
INSERT INTO `bs_admin_menu` VALUES("50","验证码日志","48","1","1","0","/admin/log.index/verifycode","@admin@log@index@verifycode","fa-comment-dots","1");
INSERT INTO `bs_admin_menu` VALUES("52","操作日志","48","1","1","0","/admin/log.index/admin_log","@admin@log@index@admin_log","fa-hammer","0");
INSERT INTO `bs_admin_menu` VALUES("55","系统设置","0","1","1","0","/admin/system.index/web","@admin@system@index@web","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("56","邮件配置","55","1","1","0","/admin/system.index/email","@admin@system@index@email","fa-at","0");
INSERT INTO `bs_admin_menu` VALUES("57","支付配置","55","1","1","0","/admin/system.index/pay","@admin@system@index@pay","fa-comments-dollar","0");
INSERT INTO `bs_admin_menu` VALUES("58","网站设置","55","1","1","0","/admin/system.index/web","@admin@system@index@web","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("59","设置备注","42","1","0","0","/admin/user.index/action_remark","@admin@user@index@action_remark","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("60","设置状态","42","1","0","0","/admin/user.index/action_status","@admin@user@index@action_status","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("61","公告表单","39","1","0","0","/admin/shop.notice/form","@admin@shop@notice@form","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("62","公告操作","39","1","0","0","/admin/shop.notice/notice_action","@admin@shop@notice@notice_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("63","设置状态","39","1","0","0","/admin/shop.notice/action_status","@admin@shop@notice@action_status","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("64","操作配置","58","1","0","0","/admin/system.index/web_action","@admin@system@index@web_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("65","操作配置","57","1","0","0","/admin/system.index/pay_action","@admin@system@index@pay_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("66","操作配置","56","1","0","0","/admin/system.index/email_action","@admin@system@index@email_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("67","短信配置","55","1","1","0","/admin/system.index/sms","@admin@system@index@sms","fa-sms","0");
INSERT INTO `bs_admin_menu` VALUES("68","操作配置","67","1","0","0","/admin/system.index/sms_action","@admin@system@index@sms_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("69","导航操作","38","1","0","0","/admin/shop.nav/nav_action","@admin@shop@nav@nav_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("70","设置状态","38","1","0","0","/admin/shop.nav/action_status","@admin@shop@nav@action_status","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("71","操作表单","38","1","0","0","/admin/shop.nav/form","@admin@shop@nav@form","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("72","操作表单","37","1","0","0","/admin/shop.banner/form","@admin@shop@banner@form","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("73","轮播操作","37","1","0","0","/admin/shop.banner/banner_action","@admin@shop@banner@banner_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("74","设置状态","37","1","0","0","/admin/shop.banner/action_status","@admin@shop@banner@action_status","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("75","订单详情","33","1","0","0","/admin/order.index/detail","@admin@order@index@detail","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("76","操作发货","33","1","0","0","/admin/order.index/send","@admin@order@index@send","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("77","店铺设置","36","1","1","0","/admin/shop.mall/index","@admin@shop@mall@index","fa-store","0");
INSERT INTO `bs_admin_menu` VALUES("78","上传日志","48","1","1","0","/admin/log.index/upload_log","@admin@log@index@upload_log","fa-print","0");
INSERT INTO `bs_admin_menu` VALUES("79","删除日志","78","1","0","0","/admin/log.index/upload_log_del","@admin@log@index@upload_log_del","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("80","删除日志","49","1","0","0","/admin/log.index/error_log_del","@admin@log@index@error_log_del","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("81","操作配置","40","1","0","0","/admin/shop.setting/config_action","@admin@shop@setting@config_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("82","操作设置","77","1","0","0","/admin/shop.mall/mall_action","@admin@shop@mall@mall_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("83","操作表单","42","1","0","0","/admin/user.index/form","@admin@user@index@form","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("84","操作用户","42","1","0","0","/admin/user.index/edit_user","@admin@user@index@edit_user","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("85","用户充值","42","1","0","0","/admin/user.index/action_recharge","@admin@user@index@action_recharge","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("86","其它功能","0","1","0","0","/admin/index/index","@admin@index@index","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("87","上传图片","86","1","0","0","/admin/upload/image","@admin@upload@image","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("88","后台首页","86","1","0","0","/admin/index/index","@admin@index@index","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("89","权限操作","24","1","0","0","/admin/auth.auser/role","@admin@auth@auser@role","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("90","退款操作","33","1","0","0","/admin/order.index/refund","@admin@order@index@refund","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("91","定时任务","55","1","1","0","/admin/system.tasks/index","@admin@system@tasks@index","fa-flask","6");
INSERT INTO `bs_admin_menu` VALUES("92","操作任务","91","1","0","0","/admin/system.tasks/tasks_action","@admin@system@tasks@tasks_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("93","操作表单","91","1","0","0","/admin/system.tasks/form","@admin@system@tasks@form","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("96","后台首页2","86","1","0","0","/admin/index/index_iframe","@admin@index@index_iframe","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("97","确认提货","33","1","0","0","/admin/order.index/action_tihuo","@admin@order@index@action_tihuo","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("98","虚拟商品发货","33","1","0","0","/admin/order.index/send_virtual","@admin@order@index@send_virtual","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("99","缓存配置","55","1","1","0","/admin/system.index/cache_set","@admin@system@index@cache_set","fa-stopwatch","-1");
INSERT INTO `bs_admin_menu` VALUES("100","重置OPCACHE缓存","99","1","0","0","/admin/system.index/del_cache_opcache","@admin@system@index@del_cache_opcache","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("101","重置数据缓存","99","1","0","0","/admin/system.index/del_cache_data","@admin@system@index@del_cache_data","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("102","清理日志文件","99","1","0","0","/admin/system.index/del_cache_log","@admin@system@index@del_cache_log","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("103","清理模板文件","99","1","0","0","/admin/system.index/del_cache_tpl","@admin@system@index@del_cache_tpl","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("104","IP黑名单","55","1","1","1","/admin/system.index/ip_blacklist","@admin@system@index@ip_blacklist","fa-user-lock","-1");
INSERT INTO `bs_admin_menu` VALUES("105","IP黑名单操作","104","1","0","0","/admin/system.index/ip_blacklist_action","@admin@system@index@ip_blacklist_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("106","安全配置","55","1","1","1","/admin/system.index/safe","@admin@system@index@safe","fa-shield-alt","-1");
INSERT INTO `bs_admin_menu` VALUES("107","配置操作","106","1","0","0","/admin/system.index/safe_action","@admin@system@index@safe_action","fa-shield-alt","0");
INSERT INTO `bs_admin_menu` VALUES("108","登录记录","23","1","0","0","/admin/auth.auser/login_log","@admin@auth@auser@login_log","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("109","登录记录","41","1","1","0","/admin/user.index/login_log","@admin@user@index@login_log","fa-clipboard-list","0");
INSERT INTO `bs_admin_menu` VALUES("110","iframe默认页面","86","1","0","0","/admin/index/default_index","@admin@index@default_index","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("111","应用中心","0","1","1","1","/admin/extend.index/index","@admin@extend@index@index","fa-cubes","999");
INSERT INTO `bs_admin_menu` VALUES("112","应用列表","111","1","1","0","/admin/extend.index/index","@admin@extend@index@index","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("113","应用管理","111","1","1","0","/admin/extend.index/manager","@admin@extend@index@manager","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("114","上传应用","113","1","0","0","/admin/extend.index/upload_app","@admin@extend@index@upload_app","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("115","编辑应用信息","113","1","0","0","/admin/extend.index/edit_app","@admin@extend@index@edit_app","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("116","启用禁用操作","113","1","0","0","/admin/extend.index/set_status","@admin@extend@index@set_status","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("118","系统文章","55","1","1","0","/admin/system.article/index","@admin@system@article@index","fa-newspaper","-2");
INSERT INTO `bs_admin_menu` VALUES("119","文章操作","118","1","0","0","/admin/system.article/action","@admin@system@article@action","fa-newspaper","0");
INSERT INTO `bs_admin_menu` VALUES("120","快捷改状态","118","1","0","0","/admin/system.article/action_status","@admin@system@article@action_status","fa-newspaper","0");
INSERT INTO `bs_admin_menu` VALUES("121","操作表单","118","1","0","0","/admin/system.article/form","@admin@system@article@form","fa-newspaper","0");
INSERT INTO `bs_admin_menu` VALUES("122","其他相关","0","1","1","0","/admin/other.index/feedback","@admin@other@index@feedback","fa-network-wired","-1");
INSERT INTO `bs_admin_menu` VALUES("123","留言反馈","122","1","1","0","/admin/other.index/feedback","@admin@other@index@feedback","fa-comment-medical","0");
INSERT INTO `bs_admin_menu` VALUES("124","操作反馈","123","1","0","0","/admin/other.index/feedback_action","@admin@other@index@feedback_action","fa-comment-medical","0");
INSERT INTO `bs_admin_menu` VALUES("125","上传配置","55","1","0","0","/admin/system.index/upload","@admin@system@index@upload","fa-upload","0");
INSERT INTO `bs_admin_menu` VALUES("126","操作配置","125","1","0","0","/admin/system.index/upload_action","@admin@system@index@upload_action","fa-upload","0");
INSERT INTO `bs_admin_menu` VALUES("127","更新应用","113","1","0","0","/admin/extend.index/update_app","@admin@extend@index@update_app","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("128","更新应用设置","113","1","0","0","/admin/extend.index/update_plugin_setting","@admin@extend@index@update_plugin_setting","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("129","修改信息表单","113","1","0","0","/admin/extend.index/form","@admin@extend@index@form","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("130","应用设置表单","113","1","0","0","/admin/extend.index/setting","@admin@extend@index@setting","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("131","打包下载","113","1","0","0","/admin/extend.index/pack","@admin@extend@index@pack","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("132","卸载应用","113","1","0","0","/admin/extend.index/remove","@admin@extend@index@remove","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("133","创建应用操作","113","1","0","0","/admin/extend.index/create_app","@admin@extend@index@create_app","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("134","配置页面","113","1","0","0","/admin/extend.index/setting","@admin@extend@index@setting","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("135","配置更新操作","113","1","0","0","/admin/extend.index/setting_update","@admin@extend@index@setting_update","fa-cubes","0");
INSERT INTO `bs_admin_menu` VALUES("136","消息中心","0","1","0","0","/admin/order.index/msg","@admin@order@index@msg","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("137","操作消息","136","1","0","0","/admin/order.index/msg_action","@admin@order@index@msg_action","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("138","消息统计","136","1","0","0","/admin/order.index/msg_count","@admin@order@index@msg_count","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("139","物流相关","55","1","1","0","/admin/system.index/express","@admin@system@index@express","fa-shipping-fast","-1");
INSERT INTO `bs_admin_menu` VALUES("140","操作物流配置","139","1","0","0","/admin/system.index/express_action","@admin@system@index@express_action","fa-shipping-fast","0");
INSERT INTO `bs_admin_menu` VALUES("141","微信配置","55","1","1","0","/admin/system.index/wechat","@admin@system@index@wechat","fa-comment-dots","0");
INSERT INTO `bs_admin_menu` VALUES("142","微信配置操作","141","1","0","0","/admin/system.index/wechat_action","@admin@system@index@wechat_action","fa-weixin","0");
INSERT INTO `bs_admin_menu` VALUES("143","商户中心","0","1","1","0","/admin/merchant.index/index","@admin@merchant@index@index","fa-solid fa-store","9");
INSERT INTO `bs_admin_menu` VALUES("144","商户列表","143","1","1","0","/admin/merchant.index/index","@admin@merchant@index@index","fa-users","9");
INSERT INTO `bs_admin_menu` VALUES("145","操作表单","144","1","0","0","/admin/merchant.index/form","@admin@merchant@index@form","fa-users","9");
INSERT INTO `bs_admin_menu` VALUES("146","操作商户","144","1","0","0","/admin/merchant.index/action","@admin@merchant@index@action","fa-users","9");
INSERT INTO `bs_admin_menu` VALUES("147","店铺列表","143","1","1","0","/admin/merchant.index/stores","@admin@merchant@index@stores","fa-solid fa-store","8");
INSERT INTO `bs_admin_menu` VALUES("148","登录记录","144","1","0","0","/admin/merchant.index/login_log","@admin@merchant@index@login_log","fa-users","0");
INSERT INTO `bs_admin_menu` VALUES("151","更新软件","86","1","0","0","/admin/index/check_update","@admin@index@check_update","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("152","操作更新","151","1","0","0","/admin/index/start_update","@admin@index@start_update","fa-cog","0");
INSERT INTO `bs_admin_menu` VALUES("153","提现申请","143","1","1","0","/admin/merchant.withdraw/index","@admin@merchant@withdraw@index","fa-credit-card","0");
INSERT INTO `bs_admin_menu` VALUES("154","操作提现申请","153","1","0","0","/admin/merchant.withdraw/withdraw_action","@admin@merchant@withdraw@withdraw_action","fa-credit-card","0");
INSERT INTO `bs_admin_menu` VALUES("155","货款记录","143","1","1","0","/admin/merchant.finance/index","@admin@merchant@finance@index","fa-clipboard-list","1");



DROP TABLE IF EXISTS `bs_admin_msg`;

CREATE TABLE `bs_admin_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` varchar(1000) NOT NULL DEFAULT '',
  `add_time` int(10) DEFAULT '0',
  `msg_type` varchar(20) NOT NULL DEFAULT '' COMMENT '自定义消息类型，order-订单类型，feedback-留言反馈，kefu-客服消息',
  `read_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读时间',
  `is_favorite` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已收藏',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COMMENT='后台管理的消息';





DROP TABLE IF EXISTS `bs_admin_role`;

CREATE TABLE `bs_admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色编号',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_admin_role` VALUES("1","超级管理");
INSERT INTO `bs_admin_role` VALUES("3","财务管理");
INSERT INTO `bs_admin_role` VALUES("4","商品管理");
INSERT INTO `bs_admin_role` VALUES("5","基本体验");



DROP TABLE IF EXISTS `bs_admin_role_auth`;

CREATE TABLE `bs_admin_role_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned DEFAULT '0' COMMENT '角色编号',
  `menu_id` int(10) unsigned DEFAULT '0' COMMENT '菜单编号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1669 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_admin_role_auth` VALUES("80","4","1");
INSERT INTO `bs_admin_role_auth` VALUES("81","4","8");
INSERT INTO `bs_admin_role_auth` VALUES("82","4","22");
INSERT INTO `bs_admin_role_auth` VALUES("83","4","21");
INSERT INTO `bs_admin_role_auth` VALUES("84","4","7");
INSERT INTO `bs_admin_role_auth` VALUES("85","4","4");
INSERT INTO `bs_admin_role_auth` VALUES("86","4","3");
INSERT INTO `bs_admin_role_auth` VALUES("87","3","44");
INSERT INTO `bs_admin_role_auth` VALUES("88","3","47");
INSERT INTO `bs_admin_role_auth` VALUES("89","3","46");
INSERT INTO `bs_admin_role_auth` VALUES("1492","1","136");
INSERT INTO `bs_admin_role_auth` VALUES("1493","1","138");
INSERT INTO `bs_admin_role_auth` VALUES("1494","1","137");
INSERT INTO `bs_admin_role_auth` VALUES("1495","1","122");
INSERT INTO `bs_admin_role_auth` VALUES("1496","1","123");
INSERT INTO `bs_admin_role_auth` VALUES("1497","1","124");
INSERT INTO `bs_admin_role_auth` VALUES("1498","1","111");
INSERT INTO `bs_admin_role_auth` VALUES("1499","1","113");
INSERT INTO `bs_admin_role_auth` VALUES("1500","1","135");
INSERT INTO `bs_admin_role_auth` VALUES("1501","1","134");
INSERT INTO `bs_admin_role_auth` VALUES("1502","1","133");
INSERT INTO `bs_admin_role_auth` VALUES("1503","1","132");
INSERT INTO `bs_admin_role_auth` VALUES("1504","1","131");
INSERT INTO `bs_admin_role_auth` VALUES("1505","1","130");
INSERT INTO `bs_admin_role_auth` VALUES("1506","1","129");
INSERT INTO `bs_admin_role_auth` VALUES("1507","1","128");
INSERT INTO `bs_admin_role_auth` VALUES("1508","1","127");
INSERT INTO `bs_admin_role_auth` VALUES("1509","1","116");
INSERT INTO `bs_admin_role_auth` VALUES("1510","1","115");
INSERT INTO `bs_admin_role_auth` VALUES("1511","1","114");
INSERT INTO `bs_admin_role_auth` VALUES("1512","1","112");
INSERT INTO `bs_admin_role_auth` VALUES("1513","1","86");
INSERT INTO `bs_admin_role_auth` VALUES("1514","1","110");
INSERT INTO `bs_admin_role_auth` VALUES("1515","1","96");
INSERT INTO `bs_admin_role_auth` VALUES("1516","1","88");
INSERT INTO `bs_admin_role_auth` VALUES("1517","1","87");
INSERT INTO `bs_admin_role_auth` VALUES("1518","1","55");
INSERT INTO `bs_admin_role_auth` VALUES("1519","1","141");
INSERT INTO `bs_admin_role_auth` VALUES("1520","1","142");
INSERT INTO `bs_admin_role_auth` VALUES("1521","1","139");
INSERT INTO `bs_admin_role_auth` VALUES("1522","1","140");
INSERT INTO `bs_admin_role_auth` VALUES("1523","1","125");
INSERT INTO `bs_admin_role_auth` VALUES("1524","1","126");
INSERT INTO `bs_admin_role_auth` VALUES("1525","1","118");
INSERT INTO `bs_admin_role_auth` VALUES("1526","1","121");
INSERT INTO `bs_admin_role_auth` VALUES("1527","1","120");
INSERT INTO `bs_admin_role_auth` VALUES("1528","1","119");
INSERT INTO `bs_admin_role_auth` VALUES("1529","1","106");
INSERT INTO `bs_admin_role_auth` VALUES("1530","1","107");
INSERT INTO `bs_admin_role_auth` VALUES("1531","1","104");
INSERT INTO `bs_admin_role_auth` VALUES("1532","1","105");
INSERT INTO `bs_admin_role_auth` VALUES("1533","1","99");
INSERT INTO `bs_admin_role_auth` VALUES("1534","1","103");
INSERT INTO `bs_admin_role_auth` VALUES("1535","1","102");
INSERT INTO `bs_admin_role_auth` VALUES("1536","1","101");
INSERT INTO `bs_admin_role_auth` VALUES("1537","1","100");
INSERT INTO `bs_admin_role_auth` VALUES("1538","1","91");
INSERT INTO `bs_admin_role_auth` VALUES("1539","1","93");
INSERT INTO `bs_admin_role_auth` VALUES("1540","1","92");
INSERT INTO `bs_admin_role_auth` VALUES("1541","1","67");
INSERT INTO `bs_admin_role_auth` VALUES("1542","1","68");
INSERT INTO `bs_admin_role_auth` VALUES("1543","1","58");
INSERT INTO `bs_admin_role_auth` VALUES("1544","1","64");
INSERT INTO `bs_admin_role_auth` VALUES("1545","1","57");
INSERT INTO `bs_admin_role_auth` VALUES("1546","1","65");
INSERT INTO `bs_admin_role_auth` VALUES("1547","1","56");
INSERT INTO `bs_admin_role_auth` VALUES("1548","1","66");
INSERT INTO `bs_admin_role_auth` VALUES("1549","1","48");
INSERT INTO `bs_admin_role_auth` VALUES("1550","1","78");
INSERT INTO `bs_admin_role_auth` VALUES("1551","1","79");
INSERT INTO `bs_admin_role_auth` VALUES("1552","1","52");
INSERT INTO `bs_admin_role_auth` VALUES("1553","1","50");
INSERT INTO `bs_admin_role_auth` VALUES("1554","1","49");
INSERT INTO `bs_admin_role_auth` VALUES("1555","1","80");
INSERT INTO `bs_admin_role_auth` VALUES("1556","1","44");
INSERT INTO `bs_admin_role_auth` VALUES("1557","1","47");
INSERT INTO `bs_admin_role_auth` VALUES("1558","1","46");
INSERT INTO `bs_admin_role_auth` VALUES("1559","1","41");
INSERT INTO `bs_admin_role_auth` VALUES("1560","1","109");
INSERT INTO `bs_admin_role_auth` VALUES("1561","1","42");
INSERT INTO `bs_admin_role_auth` VALUES("1562","1","85");
INSERT INTO `bs_admin_role_auth` VALUES("1563","1","84");
INSERT INTO `bs_admin_role_auth` VALUES("1564","1","83");
INSERT INTO `bs_admin_role_auth` VALUES("1565","1","60");
INSERT INTO `bs_admin_role_auth` VALUES("1566","1","59");
INSERT INTO `bs_admin_role_auth` VALUES("1567","1","36");
INSERT INTO `bs_admin_role_auth` VALUES("1568","1","77");
INSERT INTO `bs_admin_role_auth` VALUES("1569","1","82");
INSERT INTO `bs_admin_role_auth` VALUES("1570","1","40");
INSERT INTO `bs_admin_role_auth` VALUES("1571","1","81");
INSERT INTO `bs_admin_role_auth` VALUES("1572","1","39");
INSERT INTO `bs_admin_role_auth` VALUES("1573","1","63");
INSERT INTO `bs_admin_role_auth` VALUES("1574","1","62");
INSERT INTO `bs_admin_role_auth` VALUES("1575","1","61");
INSERT INTO `bs_admin_role_auth` VALUES("1576","1","38");
INSERT INTO `bs_admin_role_auth` VALUES("1577","1","71");
INSERT INTO `bs_admin_role_auth` VALUES("1578","1","70");
INSERT INTO `bs_admin_role_auth` VALUES("1579","1","69");
INSERT INTO `bs_admin_role_auth` VALUES("1580","1","37");
INSERT INTO `bs_admin_role_auth` VALUES("1581","1","74");
INSERT INTO `bs_admin_role_auth` VALUES("1582","1","73");
INSERT INTO `bs_admin_role_auth` VALUES("1583","1","72");
INSERT INTO `bs_admin_role_auth` VALUES("1584","1","32");
INSERT INTO `bs_admin_role_auth` VALUES("1585","1","33");
INSERT INTO `bs_admin_role_auth` VALUES("1586","1","98");
INSERT INTO `bs_admin_role_auth` VALUES("1587","1","97");
INSERT INTO `bs_admin_role_auth` VALUES("1588","1","90");
INSERT INTO `bs_admin_role_auth` VALUES("1589","1","76");
INSERT INTO `bs_admin_role_auth` VALUES("1590","1","75");
INSERT INTO `bs_admin_role_auth` VALUES("1591","1","2");
INSERT INTO `bs_admin_role_auth` VALUES("1592","1","24");
INSERT INTO `bs_admin_role_auth` VALUES("1593","1","89");
INSERT INTO `bs_admin_role_auth` VALUES("1594","1","29");
INSERT INTO `bs_admin_role_auth` VALUES("1595","1","28");
INSERT INTO `bs_admin_role_auth` VALUES("1596","1","25");
INSERT INTO `bs_admin_role_auth` VALUES("1597","1","23");
INSERT INTO `bs_admin_role_auth` VALUES("1598","1","108");
INSERT INTO `bs_admin_role_auth` VALUES("1599","1","27");
INSERT INTO `bs_admin_role_auth` VALUES("1600","1","12");
INSERT INTO `bs_admin_role_auth` VALUES("1601","1","9");
INSERT INTO `bs_admin_role_auth` VALUES("1602","1","30");
INSERT INTO `bs_admin_role_auth` VALUES("1603","1","11");
INSERT INTO `bs_admin_role_auth` VALUES("1604","1","1");
INSERT INTO `bs_admin_role_auth` VALUES("1605","1","94");
INSERT INTO `bs_admin_role_auth` VALUES("1606","1","95");
INSERT INTO `bs_admin_role_auth` VALUES("1607","1","8");
INSERT INTO `bs_admin_role_auth` VALUES("1608","1","22");
INSERT INTO `bs_admin_role_auth` VALUES("1609","1","21");
INSERT INTO `bs_admin_role_auth` VALUES("1610","1","7");
INSERT INTO `bs_admin_role_auth` VALUES("1611","1","4");
INSERT INTO `bs_admin_role_auth` VALUES("1612","1","3");
INSERT INTO `bs_admin_role_auth` VALUES("1613","5","136");
INSERT INTO `bs_admin_role_auth` VALUES("1614","5","138");
INSERT INTO `bs_admin_role_auth` VALUES("1615","5","122");
INSERT INTO `bs_admin_role_auth` VALUES("1616","5","123");
INSERT INTO `bs_admin_role_auth` VALUES("1617","5","111");
INSERT INTO `bs_admin_role_auth` VALUES("1618","5","113");
INSERT INTO `bs_admin_role_auth` VALUES("1619","5","134");
INSERT INTO `bs_admin_role_auth` VALUES("1620","5","112");
INSERT INTO `bs_admin_role_auth` VALUES("1621","5","86");
INSERT INTO `bs_admin_role_auth` VALUES("1622","5","151");
INSERT INTO `bs_admin_role_auth` VALUES("1623","5","110");
INSERT INTO `bs_admin_role_auth` VALUES("1624","5","96");
INSERT INTO `bs_admin_role_auth` VALUES("1625","5","88");
INSERT INTO `bs_admin_role_auth` VALUES("1626","5","55");
INSERT INTO `bs_admin_role_auth` VALUES("1627","5","118");
INSERT INTO `bs_admin_role_auth` VALUES("1628","5","121");
INSERT INTO `bs_admin_role_auth` VALUES("1629","5","106");
INSERT INTO `bs_admin_role_auth` VALUES("1630","5","104");
INSERT INTO `bs_admin_role_auth` VALUES("1631","5","99");
INSERT INTO `bs_admin_role_auth` VALUES("1632","5","91");
INSERT INTO `bs_admin_role_auth` VALUES("1633","5","67");
INSERT INTO `bs_admin_role_auth` VALUES("1634","5","58");
INSERT INTO `bs_admin_role_auth` VALUES("1635","5","78");
INSERT INTO `bs_admin_role_auth` VALUES("1636","5","50");
INSERT INTO `bs_admin_role_auth` VALUES("1637","5","44");
INSERT INTO `bs_admin_role_auth` VALUES("1638","5","47");
INSERT INTO `bs_admin_role_auth` VALUES("1639","5","46");
INSERT INTO `bs_admin_role_auth` VALUES("1640","5","41");
INSERT INTO `bs_admin_role_auth` VALUES("1641","5","42");
INSERT INTO `bs_admin_role_auth` VALUES("1642","5","83");
INSERT INTO `bs_admin_role_auth` VALUES("1643","5","77");
INSERT INTO `bs_admin_role_auth` VALUES("1644","5","40");
INSERT INTO `bs_admin_role_auth` VALUES("1645","5","39");
INSERT INTO `bs_admin_role_auth` VALUES("1646","5","63");
INSERT INTO `bs_admin_role_auth` VALUES("1647","5","61");
INSERT INTO `bs_admin_role_auth` VALUES("1648","5","38");
INSERT INTO `bs_admin_role_auth` VALUES("1649","5","71");
INSERT INTO `bs_admin_role_auth` VALUES("1650","5","37");
INSERT INTO `bs_admin_role_auth` VALUES("1651","5","72");
INSERT INTO `bs_admin_role_auth` VALUES("1652","5","32");
INSERT INTO `bs_admin_role_auth` VALUES("1653","5","33");
INSERT INTO `bs_admin_role_auth` VALUES("1654","5","75");
INSERT INTO `bs_admin_role_auth` VALUES("1655","5","2");
INSERT INTO `bs_admin_role_auth` VALUES("1656","5","24");
INSERT INTO `bs_admin_role_auth` VALUES("1657","5","29");
INSERT INTO `bs_admin_role_auth` VALUES("1658","5","23");
INSERT INTO `bs_admin_role_auth` VALUES("1659","5","27");
INSERT INTO `bs_admin_role_auth` VALUES("1660","5","9");
INSERT INTO `bs_admin_role_auth` VALUES("1661","5","30");
INSERT INTO `bs_admin_role_auth` VALUES("1662","5","1");
INSERT INTO `bs_admin_role_auth` VALUES("1663","5","94");
INSERT INTO `bs_admin_role_auth` VALUES("1664","5","8");
INSERT INTO `bs_admin_role_auth` VALUES("1665","5","22");
INSERT INTO `bs_admin_role_auth` VALUES("1666","5","7");
INSERT INTO `bs_admin_role_auth` VALUES("1667","5","4");
INSERT INTO `bs_admin_role_auth` VALUES("1668","5","3");



DROP TABLE IF EXISTS `bs_article`;

CREATE TABLE `bs_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
  `content` text COMMENT '文章内容',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `up_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1-展示中，0-已下线',
  `count_view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_article` VALUES("4","欢迎体验bs_shop购物商城","&lt;p&gt;&lt;b&gt;这是一个多商户版本，正在开发中&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;b&gt;需要定制联系微信：wei1-top&lt;/b&gt;&lt;/p&gt;","1639145389","1642914822","1","2");
INSERT INTO `bs_article` VALUES("5","新增游客登录，登录赠送100体验余额","&lt;p&gt;如题，大抵就是这样，欢迎测试。&lt;/p&gt;","1640849011","1642914792","0","0");



DROP TABLE IF EXISTS `bs_article_sys`;

CREATE TABLE `bs_article_sys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
  `content` text COMMENT '文章内容',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `up_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1-展示中，0-已下线',
  `count_view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='系统文章内容';

INSERT INTO `bs_article_sys` VALUES("1","注册协议","&lt;p&gt;BS商城用户注册协议本协议是您与BS商城网站（简称;本站;）所有者（以下简称为:BS商城）之间就BS商城网站服务等相关事宜所订立的契约，请您仔细阅读本注册协议，您点击;同意并继续;按钮后，本协议即构成对双方有约束力的法律文件。&lt;/p&gt;\n&lt;p&gt;第1条 本站服务条款的确认和接纳&lt;/p&gt;\n&lt;p&gt;\n1.1本站的各项电子服务的所有权和运作权归BS商城所有。用户同意所有注册协议条款并完成注册程序，才能成为本站的正式用户。用户确认：本协议条款是处理双方权利义务的契约，始终有效，法律另有强制性规定或双方另有特别约定的，依其规定。&lt;br&gt;1.2用户点击同意本协议的，即视为用户确认自己具有享受本站服务、下单购物等相应的权利能力和行为能力，能够独立承担法律责任。&lt;br&gt;1.3如果您在18周岁以下，您只能在父母或监护人的监护参与下才能使用本站。&lt;br&gt;1.4BS商城保留在中华人民共和国大陆地区法施行之法律允许的范围内独自决定拒绝服务、关闭用户账户、清除或编辑内容或取消订单的权利。\n&lt;/p&gt;\n&lt;p&gt;第2条 本站服务&lt;/p&gt;\n2.1BS商城通过互联网依法为用户提供互联网信息等服务，用户在完全同意本协议及本站规定的情况下，方有权使用本站的相关服务。&lt;br&gt;2.2用户必须自行准备如下设备和承担如下开支：（1）上网设备，包括并不限于电脑或者其他上网终端、调制解调器及其他必备的上网装置；（2）上网开支，包括并不限于网络接入费、上网设备租用费、手机流量费等。\n&lt;p&gt;第3条 用户信息&lt;/p&gt;\n3.1用户应自行诚信向本站提供注册资料，用户同意其提供的注册资料真实、准确、完整、合法有效，用户注册资料如有变动的，应及时更新其注册资料。如果用户提供的注册资料不合法、不真实、不准确、不详尽的，用户需承担因此引起的相应责任及后果，并且BS商城保留终止用户使用BS商城各项服务的权利。&lt;br&gt;3.2用户在本站进行浏览、下单购物等活动时，涉及用户真实姓名/名称、通信地址、联系电话、电子邮箱等隐私信息的，本站将予以严格保密，除非得到用户的授权或法律另有规定，本站不会向外界披露用户隐私信息。&lt;br&gt;3.3用户注册成功后，将产生用户名和密码等账户信息，您可以根据本站规定改变您的密码。用户应谨慎合理的保存、使用其用户名和密码。用户若发现任何非法使用用户账号或存在安全漏洞的情况，请立即通知本站并向公安机关报案。&lt;br&gt;3.4用户同意，BS商城拥有通过邮件、短信电话等形式，向在本站注册、购物用户、收货人发送订单信息、促销活动等告知信息的权利。&lt;br&gt;3.5用户不得将在本站注册获得的账户借给他人使用，否则用户应承担由此产生的全部责任，并与实际使用人承担连带责任。&lt;br&gt;3.6用户同意，BS商城有权使用用户的注册信息、用户名、密码等信息，登录进入用户的注册账户，进行证据保全，包括但不限于公证、见证等。\n&lt;p&gt;第4条 用户依法言行义务&lt;/p&gt;\n本协议依据国家相关法律法规规章制定，用户同意严格遵守以下义务：&lt;br&gt;\n（1）不得传输或发表：煽动抗拒、破坏宪法和法律、行政法规实施的言论，煽动颠覆国家政权，推翻社会主义制度的言论，煽动分裂国家、破坏国家统一的的言论，煽动民族仇恨、民族歧视、破坏民族团结的言论；&lt;br&gt;\n（2）从中国大陆向境外传输资料信息时必须符合中国有关法规；&lt;br&gt;\n（3）不得利用本站从事洗钱、窃取商业秘密、窃取个人信息等违法犯罪活动；&lt;br&gt;\n（4）不得干扰本站的正常运转，不得侵入本站及国家计算机信息系统；&lt;br&gt;\n（5）不得传输或发表任何违法犯罪的、骚扰性的、中伤他人的、辱骂性的、恐吓性的、伤害性的、庸俗的，淫秽的、不文明的等信息资料；&lt;br&gt;\n（6）不得传输或发表损害国家社会公共利益和涉及国家安全的信息资料或言论；&lt;br&gt;\n（7）不得教唆他人从事本条所禁止的行为；&lt;br&gt;\n（8）不得利用在本站注册的账户进行牟利性经营活动；&lt;br&gt;\n（9）不得发布任何侵犯他人著作权、商标权等知识产权或合法权利的内容；&lt;br&gt;\n用户应不时关注并遵守本站不时公布或修改的各类合法规则规定。&lt;br&gt;\n本站保有删除站内各类不符合法律政策或不真实的信息内容而无须通知用户的权利。&lt;br&gt;\n若用户未遵守以上规定的，本站有权作出独立判断并采取暂停或关闭用户帐号等措施。用户须对自己在网上的言论和行为承担法律责任。\n&lt;p&gt;第5条 商品信息&lt;/p&gt;\n本站上的商品价格、数量、是否有货等商品信息随时都有可能发生变动，本站不作特别通知。由于网站上商品信息的数量极其庞大，虽然本站会尽最大努力保证您所浏览商品信息的准确性，但由于众所周知的互联网技术因素等客观原因存在，本站网页显示的信息可能会有一定的滞后性或差错，对此情形您知悉并理解；BS商城欢迎纠错，并会视情况给予纠错者一定的奖励。为表述便利，商品和服务简称为;商品;或;货物;。\n&lt;p&gt;第6条 订单&lt;/p&gt;\n6.1在您下订单时，请您仔细确认所购商品的名称、价格、数量、型号、规格、尺寸、联系地址、电话、收货人等信息。收货人与用户本人不一致的，收货人的行为和意思表示视为用户的行为和意思表示，用户应对收货人的行为及意思表示的法律后果承担连带责任。&lt;br&gt;\n6.2除法律另有强制性规定外，双方约定如下：本站上销售方展示的商品和价格等信息仅仅是交易信息的发布，您下单时须填写您希望购买的商品数量、价款及支付方式、收货人、联系方式、收货地址等内容；系统生成的订单信息是计算机信息系统根据您填写的内容自动生成的数据，仅是您向销售方发出的交易诉求；销售方收到您的订单信息后，只有在销售方将您在订单中订购的商品从仓库实际直接向您发出时（ 以商品出库为标志），方视为您与销售方之间就实际直接向您发出的商品建立了交易关系；如果您在一份订单里订购了多种商品并且销售方只给您发出了部分商品时，您与销售方之间仅就实际直接向您发出的商品建立了交易关系；只有在销售方实际直接向您发出了订单中订购的其他商品时，您和销售方之间就订单中该其他已实际直接向您发出的商品才成立交易关系。您可以随时登录您在本站注册的账户，查询您的订单状态。&lt;br&gt;\n6.3由于市场变化及各种以合理商业努力难以控制的因素的影响，本站无法保证您提交的订单信息中希望购买的商品都会有货；如您拟购买的商品，发生缺货，您有权取消订单。\n&lt;p&gt;第7条 配送&lt;/p&gt;\n7.1销售方将会把商品（货物）送到您所指定的收货地址，所有在本站上列出的送货时间为参考时间，参考时间的计算是根据库存状况、正常的处理过程和送货时间、送货地点的基础上估计得出的。&lt;br&gt;\n7.2因如下情况造成订单延迟或无法配送等，销售方不承担延迟配送的责任：&lt;br&gt;\n（1）用户提供的信息错误、地址不详细等原因导致的；&lt;br&gt;\n（2）货物送达后无人签收，导致无法配送或延迟配送的；&lt;br&gt;\n（3）情势变更因素导致的；&lt;br&gt;\n（4）不可抗力因素导致的，例如：自然灾害、交通戒严、突发战争等。\n&lt;p&gt;第8条 所有权及知识产权条款&lt;/p&gt;\n8.1用户一旦接受本协议，即表明该用户主动将其在任何时间段在本站发表的任何形式的信息内容（包括但不限于客户评价、客户咨询、各类话题文章等信息内容）的财产性权利等任何可转让的权利，如著作权财产权（包括并不限于：复制权、发行权、出租权、展览权、表演权、放映权、广播权、信息网络传播权、摄制权、改编权、翻译权、汇编权以及应当由著作权人享有的其他可转让权利），全部独家且不可撤销地转让给BS商城所有，用户同意BS商城有权就任何主体侵权而单独提起诉讼。&lt;br&gt;\n8.2本协议已经构成《中华人民共和国著作权法》第二十五条（条文序号依照2011年版著作权法确定）及相关法律规定的著作财产权等权利转让书面协议，其效力及于用户在BS商城网站上发布的任何受著作权法保护的作品内容，无论该等内容形成于本协议订立前还是本协议订立后。&lt;br&gt;\n8.3用户同意并已充分了解本协议的条款，承诺不将已发表于本站的信息，以任何形式发布或授权其它主体以任何方式使用（包括但不限于在各类网站、媒体上使用）。&lt;br&gt;\n8.4BS商城是本站的制作者,拥有此网站内容及资源的著作权等合法权利,受国家法律保护,有权不时地对本协议及本站的内容进行修改，并在本站张贴，无须另行通知用户。在法律允许的最大限度范围内，小V商城对本协议及本站内容拥有解释权。&lt;br&gt;\n8.5除法律另有强制性规定外，未经BS商城明确的特别书面许可,任何单位或个人不得以任何方式非法地全部或部分复制、转载、引用、链接、抓取或以其他方式使用本站的信息内容，否则，BS商城有权追究其法律责任。&lt;br&gt;\n8.6本站所刊登的资料信息（诸如文字、图表、标识、按钮图标、图像、声音文件片段、数字下载、数据编辑和软件），均是BS商城或其内容提供者的财产，受中国和国际版权法的保护。本站上所有内容的汇编是BS商城的排他财产，受中国和国际版权法的保护。本站上所有软件都是小V商城或其关联公司或其软件供应商的财产，受中国和国际版权法的保护。\n&lt;p&gt;第9条 责任限制及不承诺担保&lt;/p&gt;\n除非另有明确的书面说明,本站及其所包含的或以其它方式通过本站提供给您的全部信息、内容、材料、产品（包括软件）和服务，均是在;按现状;和;按现有;的基础上提供的。&lt;br&gt;\n除非另有明确的书面说明,BS商城不对本站的运营及其包含在本网站上的信息、内容、材料、产品（包括软件）或服务作任何形式的、明示或默示的声明或担保（根据中华人民共和国法律另有规定的以外）。&lt;br&gt;BS商城不担保本站所包含的或以其它方式通过本站提供给您的全部信息、内容、材料、产品（包括软件）和服务、其服务器或从本站发出的电子信件、信息没有病毒或其他有害成分。&lt;br&gt;\n如因不可抗力或其它本站无法控制的原因使本站销售系统崩溃或无法正常使用导致网上交易无法完成或丢失有关的信息、记录等，BS商城会合理地尽力协助处理善后事宜。\n&lt;p&gt;第10条 协议更新及用户关注义务&lt;/p&gt;\n根据国家法律法规变化及网站运营需要，BS商城有权对本协议条款不时地进行修改，修改后的协议一旦被张贴在本站上即生效，并代替原来的协议。用户可随时登录查阅最新协议； 用户有义务不时关注并阅读最新版的协议及网站公告。如用户不同意更新后的协议，可以且应立即停止接受BS商城网站依据本协议提供的服务；如用户继续使用本网站提供的服务的，即视为同意更新后的协议。BS商城建议您在使用本站之前阅读本协议及本站的公告。 如果本协议中任何一条被视为废止、无效或因任何理由不可执行，该条应视为可分的且并不影响任何其余条款的有效性和可执行性。\n&lt;p&gt;第11条 法律管辖和适用&lt;/p&gt;\n本协议的订立、执行和解释及争议的解决均应适用在中华人民共和国大陆地区适用之有效法律（但不包括其冲突法规则）。 如发生本协议与适用之法律相抵触时，则这些条款将完全按法律规定重新解释，而其它有效条款继续有效。 如缔约方就本协议内容或其执行发生任何争议，双方应尽力友好协商解决；协商不成时，任何一方均可向有管辖权的中华人民共和国大陆地区法院提起诉讼。\n&lt;p&gt;第12条 其他&lt;/p&gt;\n12.1BS商城网站所有者是指在政府部门依法许可或备案的BS商城网站经营主体。&lt;br&gt;\n12.2BS商城尊重用户和消费者的合法权利，本协议及本网站上发布的各类规则、声明等其他内容，均是为了更好的、更加便利的为用户和消费者提供服务。本站欢迎用户和社会各界提出意见和建议，BS商城将虚心接受并适时修改本协议及本站上的各类规则。&lt;br&gt;\n12.3本协议内容中以黑体、加粗、下划线、斜体等方式显著标识的条款，请用户着重阅读。&lt;br&gt;\n12.4您点击本协议下方的;同意并继续;按钮即视为您完全接受本协议，在点击之前请您再次确认已知悉并完全理解本协议的全部内容。","1639145389","1640849792","1","0");



DROP TABLE IF EXISTS `bs_banner`;

CREATE TABLE `bs_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '-1-已下线，0-正常',
  `url` varchar(1000) NOT NULL DEFAULT '' COMMENT '链接',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `s_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始展示时间',
  `e_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_banner` VALUES("3","abc","0","/mall/order/all_orders.html","/static/mall/upload/ban3.jpg","1634822944","1667478091");
INSERT INTO `bs_banner` VALUES("4","测试","0","/mall/user/index.html","/static/mall/upload/ban4.jpg","1634822944","1667478091");



DROP TABLE IF EXISTS `bs_cart`;

CREATE TABLE `bs_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` varchar(50) NOT NULL DEFAULT '',
  `count` int(4) unsigned NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-未选中，1-已选中',
  `abc` varchar(100) NOT NULL DEFAULT '' COMMENT 'ces',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_cart` VALUES("33","16","bs76eb38dc7a8550b10d506b157e17d50f","1","0","0","");
INSERT INTO `bs_cart` VALUES("38","145","bse146d44f7c8ef0e3cd10b5a910843998","3","0","0","");
INSERT INTO `bs_cart` VALUES("39","38","bse146d44f7c8ef0e3cd10b5a910843998","1","0","0","");
INSERT INTO `bs_cart` VALUES("40","991","bse146d44f7c8ef0e3cd10b5a910843998","7","0","0","");
INSERT INTO `bs_cart` VALUES("41","997","bse146d44f7c8ef0e3cd10b5a910843998","1","0","0","");
INSERT INTO `bs_cart` VALUES("42","41","bse146d44f7c8ef0e3cd10b5a910843998","1","0","1","");
INSERT INTO `bs_cart` VALUES("43","42","bse146d44f7c8ef0e3cd10b5a910843998","1","0","1","");
INSERT INTO `bs_cart` VALUES("44","145","bs76eb38dc7a8550b10d506b157e17d50f","1","0","0","");
INSERT INTO `bs_cart` VALUES("52","42","bsb914097091f97a227eceaa267f3ef3d3","1","0","1","");
INSERT INTO `bs_cart` VALUES("60","988","bse1fe7aa5e3c4da3c34503b384815575b","1","0","1","");
INSERT INTO `bs_cart` VALUES("68","807","bs64239e10aa715c10efa63a714397e113","1","0","1","");
INSERT INTO `bs_cart` VALUES("69","807","bs9248580af90f8b106b2fef151b4c529f","1","0","1","");
INSERT INTO `bs_cart` VALUES("76","74","bsd44add211524601b11a4c995d28d8796","10","0","1","");
INSERT INTO `bs_cart` VALUES("77","40","bsb24543bf671260a2b3cd5bd4cf98d105","1","0","1","");
INSERT INTO `bs_cart` VALUES("78","869","bsd684670e731a34d211ff1707de84fc4b","1","0","1","");
INSERT INTO `bs_cart` VALUES("113","1009","bs5c316709450d17c798388653762ee441","1","0","1","");
INSERT INTO `bs_cart` VALUES("114","1007","bs5c316709450d17c798388653762ee441","1","0","1","");
INSERT INTO `bs_cart` VALUES("115","982","bs5c316709450d17c798388653762ee441","1","0","1","");
INSERT INTO `bs_cart` VALUES("116","43","bs5c316709450d17c798388653762ee441","1","0","1","");
INSERT INTO `bs_cart` VALUES("117","1010","bs33c10f3245c48650461eef30aa24b8b8","1","0","1","");
INSERT INTO `bs_cart` VALUES("123","982","bs91ca7180113e01fde28a157bb75bb78c","1","0","0","");
INSERT INTO `bs_cart` VALUES("128","807","bs91ca7180113e01fde28a157bb75bb78c","1","0","0","");



DROP TABLE IF EXISTS `bs_common_user`;

CREATE TABLE `bs_common_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(32) NOT NULL DEFAULT '' COMMENT '登录账号',
  `uid` varchar(50) NOT NULL DEFAULT '' COMMENT '用户唯一标识',
  `pwd` varchar(32) NOT NULL DEFAULT '',
  `salt` varchar(20) NOT NULL DEFAULT '' COMMENT '密码盐值',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `up_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1-限制登录，0-正常',
  `pwd_err_count` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '密码错误次数',
  `loginCount` int(10) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '用户备注',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `openid_wx` varchar(50) DEFAULT '' COMMENT '微信公众号openid',
  `union_code` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '唯一',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15001 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_common_user` VALUES("15000","15177741279","bs8761cfc65a8178c26c6be0d3dc963b6b","ac3b4cb8d68ac8101e9e0ed42cbf4923","zS52IUB6b5","1654699795","1655893934","0","0","8","验证码注册","用户594885","","958855");



DROP TABLE IF EXISTS `bs_common_user_address`;

CREATE TABLE `bs_common_user_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `province` varchar(32) NOT NULL DEFAULT '',
  `city` varchar(32) NOT NULL DEFAULT '',
  `area` varchar(32) NOT NULL DEFAULT '',
  `town` varchar(32) NOT NULL DEFAULT '',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '详细地址',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1-默认地址',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人号码',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=57614 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_common_user_address` VALUES("2","bs76eb38dc7a8550b10d506b157e17d50f","湖南省","衡阳市","珠晖区","","未知楼x2号","0","135000000001","小唯");
INSERT INTO `bs_common_user_address` VALUES("3","bs76eb38dc7a8550b10d506b157e17d50f","广东省","广州市","白云区","白云街道","未知楼3号","0","135000000001","小唯");
INSERT INTO `bs_common_user_address` VALUES("5","bs76eb38dc7a8550b10d506b157e17d50f","广东省","广州市","白云区","","未知楼33号","1","135000000007","小唯");
INSERT INTO `bs_common_user_address` VALUES("6","bs76eb38dc7a8550b10d506b157e17d50f","广东省","广州市","白云区","","未知楼444号","0","135000000006","小唯");
INSERT INTO `bs_common_user_address` VALUES("7","bs76eb38dc7a8550b10d506b157e17d50f","广东省","广州市","白云区","白云街道","未知楼x34x号","0","135000000001","小唯");
INSERT INTO `bs_common_user_address` VALUES("10","bse146d44f7c8ef0e3cd10b5a910843998","北京","北京市","东城区","","asdfadsfsdf","1","13444444444","youx");
INSERT INTO `bs_common_user_address` VALUES("11","bs91ca7180113e01fde28a157bb75bb78c","吉林省","长春市","南关区","","大街250号","1","13533333333","测试");
INSERT INTO `bs_common_user_address` VALUES("12","bs2418024c93528c76143bff418bb4f5a0","河北省","石家庄市","长安区","","长安大街333号","1","14588639276","小山");
INSERT INTO `bs_common_user_address` VALUES("57594","bse005ba91a7deb45e748bd81448214668","北京","北京市","东城区","","查询欧大哥我服务费","1","13500000001","查不出");
INSERT INTO `bs_common_user_address` VALUES("57595","bs0d1cb982dd3c84107876c1be761a5b01","黑龙江省","哈尔滨市","道里区","","自我我我我我","1","13636363462","普洛斯");
INSERT INTO `bs_common_user_address` VALUES("57596","bs9248580af90f8b106b2fef151b4c529f","吉林省","长春市","南关区","","测试一下","1","16866996525","小龙");
INSERT INTO `bs_common_user_address` VALUES("57597","bsac6d70ffe0b1a03c7745b9eaf305b8a1","吉林省","长春市","南关区","","来咯结茧了","0","12525252524","测试");
INSERT INTO `bs_common_user_address` VALUES("57598","bsfa1adb77b9c0d47880795f2348aac1f4","内蒙古自治区","呼和浩特市","新城区","","新城区大连街58号","1","16363636363","小孔");
INSERT INTO `bs_common_user_address` VALUES("57599","bs20f327bdfc33324b1c0e78f3e11ef096","内蒙古自治区","呼和浩特市","新城区","","大草原帐篷99号","1","13454334567","小李");
INSERT INTO `bs_common_user_address` VALUES("57600","bsd6f11d4c7418fe724a5f4cfa9e6f201d","北京","北京市","东城区","","12321313123","0","123232313","123123");
INSERT INTO `bs_common_user_address` VALUES("57601","bs720c81919496824952fc953d128e752c","北京","北京市","东城区","","123123","0","12313","123");
INSERT INTO `bs_common_user_address` VALUES("57602","bs720c81919496824952fc953d128e752c","北京","北京市","东城区","","123123","0","12313","123");
INSERT INTO `bs_common_user_address` VALUES("57603","bs1ac5d83d227b53bf462777d979401ecf","北京","北京市","东城区","","555555555555","1","13425170044","13425170044");
INSERT INTO `bs_common_user_address` VALUES("57604","bs486dd076214768e667f0a7e0ffdeb029","北京","北京市","东城区","","11","0","111","张三");
INSERT INTO `bs_common_user_address` VALUES("57605","bs486dd076214768e667f0a7e0ffdeb029","北京","北京市","东城区","","11","0","111","张三");
INSERT INTO `bs_common_user_address` VALUES("57606","bsb34f84bfbfc966917159938a39cf45be","北京","北京市","东城区","","hi哦那你","0","19484892626","比比");
INSERT INTO `bs_common_user_address` VALUES("57607","bs614c4fa51723915787c2741aab82fc34","北京","北京市","东城区","","xxxxx","1","13911111111","15365181615");
INSERT INTO `bs_common_user_address` VALUES("57608","bs358189eb2e2cac3189f80b98cb33316b","北京","北京市","东城区","","xxxx","0","123123123","12312312");
INSERT INTO `bs_common_user_address` VALUES("57609","bsd684670e731a34d211ff1707de84fc4b","北京","北京市","东城区","","你婆子","1","1353333334","测试");
INSERT INTO `bs_common_user_address` VALUES("57610","bsd9d6ee79c4918b767a040cb8fbd15d96","内蒙古自治区","呼和浩特市","新城区","","啊哒哒哒哒哒","1","1353333333","测试");
INSERT INTO `bs_common_user_address` VALUES("57611","bs33c10f3245c48650461eef30aa24b8b8","北京","北京市","东城区","","你在宜兴","1","1353333333","聊聊天");
INSERT INTO `bs_common_user_address` VALUES("57612","bsb5998a5b313c08b348e19686afd164e7","北京","北京市","东城区","","6466464","1","1353333333","jdkdkd");
INSERT INTO `bs_common_user_address` VALUES("57613","bs5ad9efe87d31451cf55840a17077b56f","北京","北京市","东城区","","66494","1","13536363634","测试");



DROP TABLE IF EXISTS `bs_common_user_credit_log`;

CREATE TABLE `bs_common_user_credit_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '交易说明',
  `before_num` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '交易前',
  `num` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '交易量',
  `after_num` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '交易后',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '账户类型：1-购买商品，2-充值记录，3-提现记录',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uid_type` (`uid`,`type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=268 DEFAULT CHARSET=utf8mb4 COMMENT='用户余额交易流水表';




DROP TABLE IF EXISTS `bs_common_user_credits`;

CREATE TABLE `bs_common_user_credits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `credit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15001 DEFAULT CHARSET=utf8mb4 COMMENT='用户账户表';

INSERT INTO `bs_common_user_credits` VALUES("15000","bs8761cfc65a8178c26c6be0d3dc963b6b","100.00","0");



DROP TABLE IF EXISTS `bs_common_user_login_log`;

CREATE TABLE `bs_common_user_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS `bs_common_user_msg`;

CREATE TABLE `bs_common_user_msg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '' COMMENT '用户标识uid',
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '消息标题',
  `content` varchar(2000) NOT NULL DEFAULT '' COMMENT '消息内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-普通消息，1-系统通知',
  `read_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '查看时间',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COMMENT='用户消息记录';




DROP TABLE IF EXISTS `bs_common_user_point_log`;

CREATE TABLE `bs_common_user_point_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '交易说明',
  `before_num` int(10) NOT NULL DEFAULT '0' COMMENT '交易前',
  `num` int(10) NOT NULL DEFAULT '0' COMMENT '交易量',
  `after_num` int(10) NOT NULL DEFAULT '0' COMMENT '交易后',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uid_type` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4 COMMENT='用户积分流水表';




DROP TABLE IF EXISTS `bs_common_user_tbauth`;

CREATE TABLE `bs_common_user_tbauth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `special_id` varchar(20) NOT NULL DEFAULT '' COMMENT '淘宝会员ID,会员运营id',
  `relation_id` varchar(20) NOT NULL DEFAULT '' COMMENT '渠道关系id',
  `external_id` varchar(50) NOT NULL DEFAULT '' COMMENT '淘宝客外部用户标记，如自身系统账户ID；微信ID等',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_common_user_tbauth` VALUES("2","bs8761cfc65a8178c26c6be0d3dc963b6b","","2764524766","");



DROP TABLE IF EXISTS `bs_config`;

CREATE TABLE `bs_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL DEFAULT '' COMMENT '配置标识',
  `value` text COMMENT '配置内容',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='配置表';


INSERT INTO `bs_config` VALUES("2","web","{\"enable_reg\":-1,\"title\":\"VIP后台管理\",\"sms_type\":\"yunpian\",\"upload_type\":\"qiniu\",\"upload_fileSizeLimit\":2097152,\"upload_enable_type\":\"jpg,png,jpeg\"}");

INSERT INTO `bs_config` VALUES("4","mobile_shop","{\"reg_type\":3,\"shop_name\":\"bs-shop购物商城\",\"shop_tel\":\"1350xxxx002\",\"shop_address_tihuo\":\"广东省-广州市-白云区-BS商城开发部666号\",\"shop_type\":0,\"pay_credit\":1,\"pay_alipay\":0,\"pay_wechat\":1,\"wx_login\":1,\"login_tmp_user\":0,\"gift_order_point\":2,\"auto_receive_order_time\":15,\"reg_gift_credit\":100,\"footer_code\":\"<!-- Matomo Image Tracker-->\\n<img referrerpolicy=\\\"no-referrer-when-downgrade\\\" src=\\\"https:\\/\\/s.alipay168.cn\\/matomo.php?idsite=6&rec=1\\\" style=\\\"border:0\\\" alt=\\\"\\\" \\/>\\n<!-- End Matomo -->\"}");
INSERT INTO `bs_config` VALUES("7","request_limit_ips","[]");
INSERT INTO `bs_config` VALUES("10","web_safe","{\"api_limit_set_second\":\"50\",\"sensitive_words\":1}");


DROP TABLE IF EXISTS `bs_config_sys`;

CREATE TABLE `bs_config_sys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL DEFAULT '',
  `value` text COMMENT '配置内容，json',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `bs_error_log`;

CREATE TABLE `bs_error_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  `add_time` int(10) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='异常日志';




DROP TABLE IF EXISTS `bs_feedback`;

CREATE TABLE `bs_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `category` varchar(100) NOT NULL DEFAULT '' COMMENT '类型，如“反馈”、“留言”',
  `add_time` int(10) DEFAULT '0',
  `up_time` int(10) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '0-待处理，1-已处理',
  `imgs` varchar(1000) DEFAULT '' COMMENT '图片，多张用逗号分开',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='留言反馈';

INSERT INTO `bs_feedback` VALUES("1","bs20f327bdfc33324b1c0e78f3e11ef096","少时诵诗书所所所所所","订单问题","1641265117","1641265117","0","");
INSERT INTO `bs_feedback` VALUES("3","bs20f327bdfc33324b1c0e78f3e11ef096","这是扫码请情况啊","异常反馈","1641265298","1641265298","0","http://shop.test.top/upload/mall/feedback/d592f26ceb2640bdddf8cb26c4d503dd.png,http://shop.test.top/upload/mall/feedback/61f322aa20e57d02a700a4ecaf3b8bef.jpeg,http://shop.test.top/upload/mall/feedback/b8ccf87027d4259b25a2dc5c83e14610.jpg,http://shop.test.top/upload/mall/feedback/b1692886a263a0835964ae1bfc98b3ea.jpeg");
INSERT INTO `bs_feedback` VALUES("4","bs20f327bdfc33324b1c0e78f3e11ef096","顶顶顶顶顶顶顶顶顶顶","异常反馈","1641265415","1641265415","0","http://shop.test.top/upload/mall/feedback/45f85c6af221115dcc9f02fc606ba6b5.jpg,http://shop.test.top/upload/mall/feedback/060907e4f16634129d7bd2ff00c85205.jpeg,http://shop.test.top/upload/mall/feedback/5374693cdfd25ff9e32be29fc0850dc4.jpeg");
INSERT INTO `bs_feedback` VALUES("5","bs20f327bdfc33324b1c0e78f3e11ef096","顶顶顶顶顶顶顶顶顶顶","其他问题","1641265457","1641265457","1","http://shop.test.top/upload/mall/feedback/fa4b73c23866672b393edcb76759f09c.jpg,http://shop.test.top/upload/mall/feedback/fa77e3094a7b249e07449934a1b301b8.jpeg,http://shop.test.top/upload/mall/feedback/5e7be2ae7f2891d65cb7ba362ecfb48d.jpg");
INSERT INTO `bs_feedback` VALUES("7","bs8736f158ac58d2811aad133d201e82a3","后台反馈图片展示不好看","其他问题","1641268144","1641268144","0","https://demo.bs.shop.wei1.top/upload/mall/feedback/11469b3ca81f5e866f927b708e7df9b4.png");
INSERT INTO `bs_feedback` VALUES("8","bs8736f158ac58d2811aad133d201e82a3","测试一下留言反馈","其他问题","1641279734","1641279734","0","https://demo.bs.shop.wei1.top/upload/mall/feedback/f1ced973ace56a1edeb8779aa87eb0c5.jpg");
INSERT INTO `bs_feedback` VALUES("9","bs20f327bdfc33324b1c0e78f3e11ef096","商品的品种太少了，可以新增一点吗","商品问题","1641879251","1641879251","0","https://source.alipay168.cn/bs_shop/upload/mall/feedback/fbba8a60e9ce7ac6a5a3ad82f01ba77b.jpgfbba8a60e9ce7ac6a5a3ad82f01ba77b.jpg?v=1641879249");



DROP TABLE IF EXISTS `bs_getui_cid`;

CREATE TABLE `bs_getui_cid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '' COMMENT '用户uid',
  `cid` varchar(50) NOT NULL DEFAULT '' COMMENT '个推（uni push）CID',
  `uid_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户类型，1-普通用户，2-商家，3-后台管理',
  `up_time` int(10) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='个推信息关联表';



DROP TABLE IF EXISTS `bs_plugins`;

CREATE TABLE `bs_plugins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plugin_tag` varchar(50) NOT NULL COMMENT '插件标识',
  `plugin_data` text COMMENT '插件数据，主要保存json格式的配置信息',
  `disable` tinyint(1) unsigned DEFAULT '1' COMMENT '1已禁用，0启用',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `up_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS `bs_plugins_category`;

CREATE TABLE `bs_plugins_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(20) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_plugins_category` VALUES("6","功能","0");
INSERT INTO `bs_plugins_category` VALUES("7","商城","0");
INSERT INTO `bs_plugins_category` VALUES("8","支付","0");
INSERT INTO `bs_plugins_category` VALUES("9","接口","0");
INSERT INTO `bs_plugins_category` VALUES("10","其他","0");



DROP TABLE IF EXISTS `bs_timer_tasks`;

CREATE TABLE `bs_timer_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '任务名称',
  `do_type` varchar(20) NOT NULL DEFAULT '' COMMENT '任务类型，url-访问url',
  `add_time` int(10) DEFAULT '0',
  `up_time` int(10) DEFAULT '0',
  `content` varchar(1000) DEFAULT '' COMMENT '对应执行的内容',
  `time_set` varchar(255) DEFAULT '' COMMENT '时间设置',
  `ext_data` varchar(1000) DEFAULT '' COMMENT '其他扩展内容',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-未开启，1-已开启',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='定时任务';



DROP TABLE IF EXISTS `bs_union_feedback`;

CREATE TABLE `bs_union_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(512) NOT NULL DEFAULT '' COMMENT '留言内容',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `up_time` int(11) DEFAULT '0',
  `uid` varchar(50) NOT NULL DEFAULT '' COMMENT '留言用户',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `bs_union_orders`;

CREATE TABLE `bs_union_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `akey` varchar(32) NOT NULL DEFAULT '' COMMENT '管理员akey',
  `uid` varchar(50) NOT NULL DEFAULT '' COMMENT 'common_user的uid',
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他，8-美团',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实付金额',
  `commission_rate` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '佣金比例，0-100',
  `commission` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金，单位元',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '-1-已无效，0-待结算，1-已结算',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  `up_time` int(10) unsigned NOT NULL DEFAULT '0',
  `item_title` varchar(128) NOT NULL DEFAULT '',
  `item_thumb` varchar(255) NOT NULL DEFAULT '',
  `settlement_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结算时间',
  `del_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_order_sn_type` (`order_sn`,`type`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1000139 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_union_orders` VALUES("1000138","","","220612-262335374262698","1","99.00","1","0.71","0","1655019937","1655184601","【移动|联通|电信】【全国三网话费充值 |慢充| 72小时内到账】","https://img.pddpic.com/gaudit-image/2022-04-05/22a4f2ffeb77b0c7f9f9db0e280efbf9.jpeg","0",NULL);



DROP TABLE IF EXISTS `bs_union_pdd_order`;

CREATE TABLE `bs_union_pdd_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '' COMMENT 'common user 的uid',
  `akey` varchar(20) NOT NULL DEFAULT '',
  `up_time` int(11) DEFAULT '0',
  `add_time` int(11) unsigned DEFAULT '0',
  `sep_market_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `goods_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单中sku的单件价格，单位为分',
  `sep_duo_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` int(10) unsigned NOT NULL DEFAULT '0',
  `order_status` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态： -1 未支付; 0-已支付；1-已成团；2-确认收货；3-审核成功；4-审核失败（不可提现）；5-已经结算；8-非多多进宝商品（无佣金订单）',
  `order_create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_direct` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否直推 ，1表示是，0表示否',
  `order_amount` int(10) unsigned NOT NULL DEFAULT '0',
  `price_compare_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '比价状态：0：正常，1：比价',
  `order_modify_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  `auth_duo_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cpa_new` int(4) NOT NULL COMMENT '是否是 cpa 新用户，1表示是，0表示否',
  `goods_name` varchar(255) DEFAULT NULL,
  `batch_no` varchar(100) DEFAULT NULL COMMENT '结算批次号',
  `goods_quantity` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买商品的数量',
  `goods_id` varchar(25) NOT NULL DEFAULT '0',
  `sep_parameters` varchar(100) DEFAULT NULL,
  `sep_rate` int(10) unsigned NOT NULL DEFAULT '0',
  `custom_parameters` varchar(100) DEFAULT NULL COMMENT '自定义参数',
  `goods_thumbnail_url` varchar(255) DEFAULT NULL COMMENT '商品缩略图\r\n',
  `promotion_rate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '佣金比例，千分比',
  `promotion_amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '佣金金额，单位为分',
  `order_pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  `group_id` varchar(30) DEFAULT NULL,
  `sep_pid` varchar(20) DEFAULT NULL,
  `order_status_desc` varchar(30) DEFAULT '' COMMENT '订单状态描述',
  `order_id` varchar(32) DEFAULT NULL COMMENT '订单ID',
  `order_sn` varchar(32) DEFAULT NULL COMMENT '推广订单编号',
  `p_id` varchar(32) DEFAULT NULL,
  `zs_duo_id` int(10) unsigned NOT NULL DEFAULT '0',
  `fail_reason` varchar(100) DEFAULT NULL,
  `order_group_success_time` int(10) NOT NULL DEFAULT '0' COMMENT '成团时间',
  `order_receive_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '确认收货时间',
  `order_settle_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结算时间',
  `order_verify_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核时间',
  `is_jiesuan` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经结算给用户',
  `jiesuan_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结算给用户的时间',
  `goods_sign` varchar(255) NOT NULL DEFAULT '',
  `withdraw_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1-已提现；2-提现中',
  `withdraw_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现申请记录编号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=100004 DEFAULT CHARSET=utf8mb4 COMMENT='拼多多订单表';

INSERT INTO `bs_union_pdd_order` VALUES("100003","","","1655868062","1655866441","0.00","1790.00","0","0","1","1655866306","0","1790","0","1655866343","0","0","野钓风暴鱼饵腥香打窝饵料钓鲫鱼黑坑鲤鱼饵料通杀鱼食竞技拉饵料","","1","86070126444","","0","{\"uid\":\"bs8761cfc65a8178c26c6be0d3dc963b6b\",\"sid\":\"weixin\"}","http://t00img.yangkeduo.com/goods/images/2020-10-23/4555b9b5fb1534e5fa1dce6b9d6f1671.jpeg","21","39","1655866308","1894431053936003837","","已成团","/BZQQbklTcS/dbV7TUyZWA==","220622-580266311350821","10026467_219444542","0",NULL,"1655866308","0","0","0","0","0","E932tmBjGfhOA7DRweHaknXMhmrgRW8__JQ4J34AwJj","0","0");



DROP TABLE IF EXISTS `bs_union_tb_order`;

CREATE TABLE `bs_union_tb_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `akey` varchar(32) NOT NULL DEFAULT '' COMMENT '插件akey',
  `uid` varchar(50) NOT NULL DEFAULT '' COMMENT '公共用户的uid',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入表时间',
  `up_time` int(10) DEFAULT '0',
  `adzone_id` varchar(32) NOT NULL DEFAULT '0' COMMENT '推广位管理下的推广位名称对应的ID，同时也是pid=mm_1_2_3中的“3”这段数字',
  `tb_paid_time` datetime DEFAULT NULL COMMENT '订单在淘宝拍下付款的时间',
  `tk_paid_time` datetime DEFAULT NULL COMMENT '订单付款的时间，该时间同步淘宝，可能会略晚于买家在淘宝的订单创建时间',
  `pay_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '买家确认收货的付款金额（不包含运费金额',
  `pub_share_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '结算预估收入=结算金额×提成。以买家确认收货的付款金额为基数，预估您可能获得的收入。因买家退款、您违规推广等原因，可能与您最终收入不一致。最终收入以月结后您实际收到的为准',
  `trade_id` varchar(50) NOT NULL DEFAULT '' COMMENT '买家通过购物车购买的每个商品对应的订单编号，此订单编号并未在淘宝买家后台透出',
  `tk_order_role` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '二方：佣金收益的第一归属者； 三方：从其他淘宝客佣金中进行分成的推广者',
  `tk_earning_time` datetime DEFAULT NULL COMMENT '订单确认收货后且商家完成佣金支付的时间',
  `pub_share_rate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '从结算佣金中分得的收益比率',
  `refund_tag` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '维权标签，0 含义为非维权 1 含义为维权订单',
  `subsidy_rate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '平台给与的补贴比率，如天猫、淘宝、聚划算等',
  `tk_total_rate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提成=收入比率×分成比率。指实际获得收益的比率',
  `item_category_name` varchar(32) NOT NULL DEFAULT '' COMMENT '商品所属的根类目，即一级类目的名称',
  `pub_id` bigint(18) unsigned NOT NULL DEFAULT '0' COMMENT '推广者的会员id',
  `alimama_rate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推广者赚取佣金后支付给阿里妈妈的技术服务费用的比率',
  `subsidy_type` varchar(20) NOT NULL DEFAULT '' COMMENT '平台出资方，如天猫、淘宝、或聚划算等',
  `pub_share_pre_fee` decimal(10,0) unsigned NOT NULL DEFAULT '0' COMMENT '付款预估收入=付款金额×提成。指买家付款金额为基数，预估您可能获得的收入。因买家退款等原因，可能与结算预估收入不一致',
  `alipay_total_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '买家拍下付款的金额（不包含运费金额）',
  `item_img` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图',
  `item_title` varchar(125) NOT NULL DEFAULT '' COMMENT '商品标题',
  `item_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
  `item_id` varchar(32) NOT NULL DEFAULT '' COMMENT '商品ID',
  `item_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `subsidy_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '补贴金额=结算金额×补贴比率',
  `alimama_share_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '技术服务费=结算金额×收入比率×技术服务费率。推广者赚取佣金后支付给阿里妈妈的技术服务费用',
  `trade_parent_id` varchar(50) NOT NULL DEFAULT '' COMMENT '买家在淘宝后台显示的订单编号',
  `order_type` varchar(32) DEFAULT '' COMMENT '订单所属平台类型，包括天猫、淘宝、聚划算等',
  `tk_create_time` datetime DEFAULT NULL COMMENT '订单创建的时间，该时间同步淘宝，可能会略晚于买家在淘宝的订单创建时间',
  `terminal_type` varchar(32) NOT NULL DEFAULT '' COMMENT '成交平台',
  `click_time` datetime DEFAULT NULL COMMENT '通过推广链接达到商品、店铺详情页的点击时间',
  `tk_status` int(10) NOT NULL DEFAULT '0' COMMENT '已付款：指订单已付款，但还未确认收货 已收货：指订单已确认收货，但商家佣金未支付 已结算：指订单已确认收货，且商家佣金已支付成功 已失效：指订单关闭/订单佣金小于0.01元，订单关闭主要有：1）买家超时未付款； 2）买家付款前，买家/卖家取消了订单；3）订单付款后发起售中退款成功；3：订单结算，12：订单付款， 13：订单失效，14：订单成功',
  `total_commission_rate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '佣金比率',
  `item_link` varchar(255) DEFAULT '' COMMENT '商品链接',
  `income_rate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单结算的佣金比率+平台的补贴比率',
  `total_commission_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金金额=结算金额＊佣金比率',
  `special_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员运营id',
  `relation_id` int(10) unsigned DEFAULT '0' COMMENT '渠道关系id',
  `app_key` varchar(32) DEFAULT '',
  `modified_time` varchar(20) NOT NULL DEFAULT '' COMMENT '订单更新时间',
  `is_jiesuan` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已结算',
  `jiesuan_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结算订单时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_union_tb_order` VALUES("11","","","1655634662","1655634666","110831400177","2022-06-18 18:36:28","2022-06-18 18:36:40","0.00","0.00","2706013009867740403","2",NULL,"100","0","0","6.01","住宅家具","51889124","0","--","1","15.90","//img.alicdn.com/tfscom/i4/1923080410/O1CN01VNGFZ21EtowiJVjE5_!!1923080410.jpg","鞋架子家用经济型简易放门口多层防尘鞋架组装宿舍收纳神器省空间","1","547995919644","59.00","0.00","0.00","2706013009867740403","天猫","2022-06-18 18:36:32","无线","2022-06-18 18:34:12","12","6","http://item.taobao.com/item.htm?id=547995919644","6","0.00","0","0","23116944","2022-06-18 18:36:40","0","0");



DROP TABLE IF EXISTS `bs_upload_files_log`;

CREATE TABLE `bs_upload_files_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小，b',
  `type` varchar(30) DEFAULT '',
  `upload_type` varchar(20) DEFAULT '' COMMENT '上传方式，local-本地，oss-阿里云oss，qiniu-七牛云',
  `path` varchar(500) DEFAULT '' COMMENT '保存路径',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `user_type` tinyint(1) unsigned DEFAULT '0' COMMENT '1-后台，2-用户',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb4 COMMENT='文件上传记录';



DROP TABLE IF EXISTS `bs_verify_code_log`;

CREATE TABLE `bs_verify_code_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) NOT NULL DEFAULT '' COMMENT '账户，邮箱或者手机号',
  `code` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '验证码',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-手机，1-邮箱',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COMMENT='验证码发送记录';



DROP TABLE IF EXISTS `bs_version`;

CREATE TABLE `bs_version` (
  `app_version` int(10) DEFAULT '0' COMMENT 'app版本',
  `sql_version` int(10) DEFAULT '0' COMMENT 'sql结构版本',
  `file_version` int(10) DEFAULT '0' COMMENT '文件版本'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `bs_version` VALUES("1","3","1");



DROP TABLE IF EXISTS `bs_withdraw_log`;

CREATE TABLE `bs_withdraw_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `uid_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户类型，1-普通用户，2-商家',
  `order_no` varchar(32) NOT NULL DEFAULT '' COMMENT '申请单号',
  `num` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '申请金额',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '申请时间',
  `up_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-待审核，1-已通过，-1-已驳回',
  `fail_text` varchar(500) NOT NULL DEFAULT '' COMMENT '驳回原因',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `to_account` varchar(64) NOT NULL DEFAULT '' COMMENT '提现账户，如支付宝账号、手机号、银行卡号等',
  `to_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '提现方式：1-支付宝，2-微信，3-银行卡',
  `imgs` varchar(1000) DEFAULT '' COMMENT '转账凭证，由后台上传',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_uid_type` (`uid`,`uid_type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COMMENT='提现申请记录';
