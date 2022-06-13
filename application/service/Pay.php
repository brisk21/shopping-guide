<?php


namespace app\service;


use app\common\controller\AppCommon;

class Pay
{
    public static function get_wx_config()
    {
        $conf = ConfigService::get('wxpay');
        if (empty($conf['app_id'])) {
            return ['code' => -1, 'msg' => '后台微信支付未配置'];
        }
        $wxConfig = config('wechat');
        //合并预设配置
        $wxConfig = array_merge($wxConfig, [
            'app_id' => $conf['app_id'],
            'mch_id' => $conf['mch_id'],
            'md5_key' => $conf['mch_key'],
            'app_cert_pem' => $conf['cert_pem'],
            'app_key_pem' => $conf['key_pem'],
        ]);
        //证书配置
        $tmpDir = str_replace('\\', '/', sys_get_temp_dir()) . '/';
        if (empty($tmpDir) || !is_dir($tmpDir) || !is_writable($tmpDir)) {
            $tmpDir = RUNTIME_PATH . 'paytemp/';
            if (!is_dir($tmpDir)) {
                @mkdir($tmpDir, 0777, true);
            }
        }
        if (!empty($conf['cert_pem'])) {
            file_put_contents($tmpDir . $conf['app_id'] . 'cert_pem.pem', $conf['cert_pem']);
            $wxConfig['app_cert_pem'] = $tmpDir . $conf['app_id'] . 'cert_pem.pem';
        }
        if (!empty($conf['key_pem'])) {
            file_put_contents($tmpDir . $conf['app_id'] . 'key_pem.pem', $conf['key_pem']);
            $wxConfig['app_key_pem'] = $tmpDir . $conf['app_id'] . 'key_pem.pem';
        }
        $wxConfig['tmpDir'] = $tmpDir;
        return $wxConfig;
    }

    //微信公众号支付
    public static function wx_pub($order)
    {
        $wxConfig = self::get_wx_config();
        if (isset($wxConfig['code'])) {
            return $wxConfig;
        }

        // 订单信息
        $payData = [
            'body' => '商品支付',
            'subject' => '购买商品支付',
            'trade_no' => $order['order_sn'],
            'time_expire' => $order['cancel_pay_time'], // 表示必须 600s 内付款
            'amount' => $order['price'],
            'return_param' => 'wx',
            'client_ip' => get_ip(),// 客户地址
            'openid' => cookie('my_gzh_openid'),
            'product_id' => '',
            // 如果是服务商，请提供以下参数
            'sub_appid' => '', //微信分配的子商户公众账号ID
            'sub_mch_id' => '', // 微信支付分配的子商户号
            'sub_openid' => '', // 用户在子商户appid下的唯一标识
        ];

        // 使用
        try {
            $client = new \Payment\Client(\Payment\Client::WECHAT, $wxConfig);
            $res = $client->pay(\Payment\Client::WX_CHANNEL_PUB, $payData);
        } catch (\InvalidArgumentException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        } catch (\Payment\Exceptions\GatewayException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        } catch (\Payment\Exceptions\ClassNotFoundException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        }

        $arr = [
            'appId' => $wxConfig['app_id'],
            'timeStamp' => strval(time()),
            'nonceStr' => $res['nonce_str'],
            'package' => 'prepay_id=' . $res['prepay_id'],
            'signType' => 'MD5',
        ];
        //二次签名
        $arr['paySign'] = self::getSign($arr, $wxConfig['md5_key']);

        self::del_tmp_pem($wxConfig);

        return ['code' => 0, 'msg' => 'ok', 'data' => $arr];
    }

    //微信H5支付，在wap网页打开微信
    public static function wx_h5($param)
    {
        if (!isMobile() || fromClient() == 'weixin') {
            return ['code' => -1, 'msg' => '请在非微信移动端网页打开'];
        }
        if (empty($param['order'])) {
            return ['code' => -1, 'msg' => '订单信息不存在'];
        }
        $wxConfig = self::get_wx_config();
        if (isset($wxConfig['code'])) {
            return $wxConfig;
        }

        $payData = [
            'body' => !empty($param['body']) ? $param['body'] : '商品支付',
            'subject' => !empty($param['subject']) ? $param['subject'] : '商品信息请查看订单',
            'trade_no' => $param['order']['order_sn'],
            'time_expire' => $param['order']['cancel_pay_time'],// 表示必须 600s 内付款
            'amount' => $param['order']['price'],
            'return_param' => 'bswxh5',
            'client_ip' => request()->ip(),// 客户地址
            'scene_info' => [
                'type' => 'Wap',// IOS  Android  Wap  腾讯建议 IOS  ANDROID 采用app支付
                'wap_url' => !empty($param['url']) ? $param['url'] : '',//自己的 wap 地址
                'wap_name' => '微信支付',
            ],
            'redirect_url' => empty($param['redirect_url']) ? '' : urlencode($param['redirect_url'])
        ];

        try {
            $client = new \Payment\Client(\Payment\Client::WECHAT, $wxConfig);
            $res = $client->pay(\Payment\Client::WX_CHANNEL_WAP, $payData);
        } catch (\InvalidArgumentException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        } catch (\Payment\Exceptions\GatewayException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        } catch (\Payment\Exceptions\ClassNotFoundException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        }

        //支付完成后跳转的页面
        if (!empty($payData['redirect_url'])) {
            $res['mweb_url'] = $res['mweb_url'] . '&redirect_url=' . $payData['redirect_url'];
        }
        self::del_tmp_pem($wxConfig);
        return ['code' => 0, 'msg' => 'ok', 'data' => $res];
    }


    /**
     * 充值订单参数
     * @param $order
     * @return array
     */
    public static function wx_recharge($order)
    {
        $wxConfig = self::get_wx_config();
        if (isset($wxConfig['code'])) {
            return $wxConfig;
        }

        // 订单信息
        $payData = [
            'body' => '余额充值',
            'subject' => '账户余额充值',
            'trade_no' => $order['order_sn'],
            'time_expire' => $order['cancel_pay_time'], // 表示必须 600s 内付款
            'amount' => $order['price'],
            'return_param' => 'recharge',
            'client_ip' => get_ip(),// 客户地址
            'openid' => cookie('my_gzh_openid'),
            'product_id' => '',
            // 如果是服务商，请提供以下参数
            'sub_appid' => '', //微信分配的子商户公众账号ID
            'sub_mch_id' => '', // 微信支付分配的子商户号
            'sub_openid' => '', // 用户在子商户appid下的唯一标识
        ];

        // 使用
        try {
            $client = new \Payment\Client(\Payment\Client::WECHAT, $wxConfig);
            $res = $client->pay(\Payment\Client::WX_CHANNEL_PUB, $payData);
        } catch (\InvalidArgumentException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        } catch (\Payment\Exceptions\GatewayException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        } catch (\Payment\Exceptions\ClassNotFoundException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        }

        $arr = [
            'appId' => $wxConfig['app_id'],
            'timeStamp' => strval(time()),
            'nonceStr' => $res['nonce_str'],
            'package' => 'prepay_id=' . $res['prepay_id'],
            'signType' => 'MD5',
        ];
        //二次签名
        $arr['paySign'] = self::getSign($arr, $wxConfig['md5_key']);

        self::del_tmp_pem($wxConfig);

        return ['code' => 0, 'msg' => 'ok', 'data' => $arr];
    }

    private static function del_tmp_pem($conf)
    {
        //清理证书
        $tmpDir = $conf['tmpDir'];
        if (file_exists($tmpDir . $conf['app_id'] . 'key_pem.pem')) {
            @unlink($tmpDir . $conf['app_id'] . 'key_pem.pem');
        }
        if (file_exists($tmpDir . $conf['app_id'] . 'cert_pem.pem')) {
            @unlink($tmpDir . $conf['app_id'] . 'cert_pem.pem');
        }
    }

    public static function getSign($Obj, $key)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = self::formatBizQueryParaMap($Parameters, false);
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $key;
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
    }

    /**
     *    作用：格式化参数，签名过程需要使用
     */
    static function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }


    public static function refund_wechat($order_sn, $money)
    {
        $wxConfig = self::get_wx_config();
        if (isset($wxConfig['code'])) {
            return $wxConfig;
        }
        $order = Order::get($order_sn);
        if (empty($order)) {
            return ['code' => -1, 'msg' => '订单未找到'];
        }
        //这是子订单
        if (!empty($order['parent_sn'])) {
            $parentOrder = Order::get($order['parent_sn'],'order_sn,pay_price');
        }
        $refundNo = 'BSRE' . time() . get_random(10, true);
        $data = [
            'trade_no' => !empty($order['parent_sn']) ? $order['parent_sn'] : $order_sn,
            'transaction_id' => !empty($order['trans_id']) ? $order['trans_id'] : '',
            'total_fee' => !empty($parentOrder) ? $parentOrder['pay_price'] : $order['pay_price'],
            'refund_fee' => $money,
            'refund_no' => $refundNo,

            'refund_account' => 'REFUND_SOURCE_RECHARGE_FUNDS',
        ];

        // 使用
        try {
            $client = new \Payment\Client(\Payment\Client::WECHAT, $wxConfig);
            $res = $client->refund($data);
        } catch (\InvalidArgumentException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        } catch (\Payment\Exceptions\GatewayException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        } catch (\Payment\Exceptions\ClassNotFoundException $e) {
            self::del_tmp_pem($wxConfig);
            return ['code' => -1, 'msg' => $e->getMessage()];
        }
        //diylog
        //DiyLog::file($res, 'wxrefund.log');


        if ($res['return_code'] <> 'SUCCESS' || $res['result_code'] <> 'SUCCESS') {
            return ['code' => -1, 'msg' => $res['return_msg']];
        }
        self::del_tmp_pem($wxConfig);


        return ['code' => 0, 'msg' => 'ok', 'data' => $res];
    }
}