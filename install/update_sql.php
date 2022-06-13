<?php
/**
 * 按版本新增key，记得修复config/config.php的version中sql对应的版本升级
 */
return [
    'v1' => [
        "ALTER TABLE `bs_order`
ADD COLUMN `is_settlement` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否已结算，1-已结算' AFTER `ip_address`;",
    ],
    'v2' => [
        "CREATE TABLE `bs_withdraw_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `uid_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户类型，1-普通用户，2-商家',
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
  PRIMARY KEY (`id`),
  KEY `idx_uid_type` (`uid`,`uid_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='提现申请记录';"
    ],
    'v3'=>[
        "ALTER TABLE `bs_withdraw_log` 
ADD COLUMN `order_no` varchar(32) NOT NULL DEFAULT '' COMMENT '申请单号' AFTER `uid_type`;"
    ],
];