<?php
/**
 * 微信配置
 */
return [
    'use_sandbox' => false, // 是否使用 微信支付仿真测试系统
    'app_id' => '',  // 公众账号ID
    'mch_id' => '', // 商户id
    'md5_key' => '', // md5 秘钥
    'app_cert_pem' => '',
    'app_key_pem' => '',
    'sign_type' => 'MD5', // MD5  HMAC-SHA256
    'limit_pay' => [
        //'no_credit',
    ], // 指定不能使用信用卡支付   不传入，则均可使用
    'fee_type' => 'CNY', // 货币类型  当前仅支持该字段
    'notify_url' => URL_WEB . 'payment/wxnotify/index',//  回调地址
    'redirect_url' => '', // 如果是h5支付，可以设置该值，返回到指定页面
];