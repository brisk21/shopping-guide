<?php

namespace base;




/**
 * 支付中台
 * @author   Brisklan
 * @blog    http://blog.alipay168.cn/
 * @version 1.0.0
 * @date    2020-02-15
 * @desc    description
 */
class WeixinAgent
{
    // 插件配置参数
    private $config;
    const URI_CREATE_ORDER = 'http://wxauth.alipay168.cn/api/order/create_order';
    const URI_GET_PAY_PARAMS = 'http://wxauth.alipay168.cn/api/order/get_pay_params';
    const URI_GET_PAY_QRCPDE = 'http://wxauth.alipay168.cn/api/order/get_pay_qrcode';
    const URI_PAY_ORDER = 'http://wxauth.alipay168.cn/pay/weixin/channel/orderId/oid.html';
    const URI_REFUND_ORDER = 'http://wxauth.alipay168.cn/api/order/refund_money';
    const URI_GET_TIXIAN_BALANCE = 'http://wxauth.alipay168.cn/api/order/get_tixian_balance';
    const URI_SET_TIXIAN_ORDER_STATUS = 'http://wxauth.alipay168.cn/api/order/set_tixian_order_status';

    /**
     * 构造方法
     * @param   [array]           $params [输入参数（支付配置参数）]
     * @version 1.0.0
     * @date    2020-02-15
     * @desc    description
     * @author   Brisklan
     * @blog    http://blog.alipay168.cn/
     */
    public function __construct($params = [])
    {
        $this->config = $params;
    }

    /**
     * 配置信息
     * @author   Brisklan
     * @blog    http://blog.alipay168.cn/
     * @version 1.0.0
     * @date    2020-02-15
     * @desc    description
     */
    public function Config()
    {
        // 基础信息
        $base = [
            'name' => '小V支付中台',  // 插件名称
            'version' => '1.1.1',  // 插件版本
            'apply_version' => '不限',  // 适用系统版本描述
            'apply_terminal' => ['pc', 'h5', 'ios', 'android', 'weixin'],
            'desc' => '适合支付中台、支付宝支付、H5支付。 <a href="http://wxauth.alipay168.cn/" target="_blank">立即申请</a>',  // 插件描述（支持html）
            'author' => 'Brisklan',  // 开发者
            'author_url' => 'http://blog.alipay168.cn/',  // 开发者主页
        ];

        // 配置信息
        $element = [
            [
                'element' => 'input',
                'type' => 'text',
                'default' => '',
                'name' => 'akey',
                'placeholder' => 'akey',
                'title' => 'access_key',
                'is_required' => 0,
                'message' => '请填写小v微信代理的akey',
            ],
            [
                'element' => 'input',
                'type' => 'text',
                'default' => '',
                'name' => 'asecret',
                'placeholder' => 'asecret',
                'title' => 'access_secret',
                'is_required' => 0,
                'message' => '请填写小v微信代理的asecret',
            ],
            [
                'element' => 'input',
                'type' => 'number',
                'default' => '1200',
                'name' => 'timeout',
                'placeholder' => '支付超时时间xxx秒',
                'title' => '支付超时时间xxx秒',
                'is_required' => 0,
                'message' => '请填写支付超时时间(秒)',
            ],

            /*[
                'element' => 'select',
                'title' => '支付方式',
                'message' => '请选择渠道方式',
                'name' => 'chancel',
                'is_multiple' => 0,
                'element_data' => [
                    ['value' => 'wx_pub', 'name' => '微信-公众账号支付'],
                    ['value' => 'wx_lite', 'name' => '微信-小程序支付'],
                    ['value' => 'wx_bar', 'name' => '微信-刷卡支付'],
                    ['value' => 'wx_wap', 'name' => '微信wap支付，针对特定用户'],
                    ['value' => 'wx_qr', 'name' => '微信 扫码支付'],
                    ['value' => 'wx_app', 'name' => '微信-APP支付'],
                    ['value' => 'ali_app', 'name' => '支付宝-APP支付'],
                    ['value' => 'ali_wap', 'name' => '支付宝-手机网页支付'],
                    ['value' => 'ali_web', 'name' => '支付宝-PC网页支付'],
                    ['value' => 'ali_qr', 'name' => '支付宝-扫码支付'],
                    ['value' => 'ali_bar', 'name' => '支付宝 条码支付'],

                ],
            ],*/
        ];

        return [
            'base' => $base,
            'element' => $element,
        ];
    }

    /**
     * 支付入口
     * @param array $params [输入参数]
     * @return array
     * @author   Brisklan
     * @blog    http://blog.alipay168.cn/
     * @version 1.0.0
     * @date    2020-02-15
     * @desc    description
     */
    public function Pay($params = [])
    {
        if (empty($params['akey'])) {
            return data_return_arr('akey未配置', -1);
        }
        if (empty($params['asecret'])) {
            return data_return_arr('asecret未配置', -1);
        }
        if (empty($params['call_back_url'])) {
            return data_return_arr('回调地址未设置', -1);
        }
        if (empty($params['timeout']) || $params['timeout'] < 300 || $params['timeout'] > 172800) {
            return data_return_arr('超时参数应介于300~172800(两天)之间', -1);
        }

        //'wx_pub', 'wx_lite', 'alipay','wx_h5','wx_qr'
        $chancel = !empty($params['channel']) ? $params['channel'] : 'wx_pub';

        $data = [
            'openid' => !empty($params['openid'])?$params['openid']:'',
            'outId' => $params['outId'],
            'money' => $params['total_price'],
            'body' => $params['body'],
            'channel' => $chancel,//支付渠道
            'client_type' => isset($params['client_type']) ? $params['client_type'] : 'pc',
            'timeout' => intval($params['timeout']),
            'akey' => $params['akey']
        ];

        if (empty($params['openid'])) {
            unset($data['opennid']);
        }

        $data['backUrl'] = isset($params['redirect_url']) ? $params['redirect_url'] : URL_WEB ;
        $data['notifyUrl'] = $params['call_back_url'];

        $data['sign'] = $this->get_sign($data, $params['asecret']);//签名验证
        $ret = $this->HttpRequest(self::URI_CREATE_ORDER, $data, false, 10);

        $createOrder = json_decode($ret, true);
        if (!isset($createOrder['code'])) {

            return data_return_arr('服务正忙，请稍后再试', -1,$createOrder);
        }
        if ($createOrder['code'] <> 0) {
            return data_return_arr($createOrder['msg'], -1);
        }
        $orderId = $createOrder['data']['orderId'];//中台的值编号

        $payUrl = str_replace('oid', $orderId, str_replace('channel', $chancel, self::URI_PAY_ORDER));
        $payUrl = $payUrl . (!empty(explode('?', $payUrl, 2)[1]) ? '&' : '?') . 'subject=' . $params['body'];
        if (!empty($params['use_return'])) {
            return ['code' => 0, 'msg' => '订单已生成', 'url' => $payUrl, 'order_sn' => $orderId];
        }
        exit(header('location:' . $payUrl));
    }

    //获取支付参数
    public function get_pay_params($params)
    {
        if (empty($params['akey'])) {
            return data_return_arr('akey未配置', -1);
        }
        if (empty($params['asecret'])) {
            return data_return_arr('asecret未配置', -1);
        }
        if (empty($params['appid'])) {
            return data_return_arr('appid丢失', -1);
        }
        $data = [
            'appid' => $params['appid'],
            'orderId' => $params['orderId'],
            'subject' => isset($params['subject']) ? $params['subject'] : '',
            'akey' => $params['akey']
        ];

        $data['sign'] = $this->get_sign($data, $params['asecret']);//签名验证

        $getParams = json_decode($this->HttpRequest(self::URI_GET_PAY_PARAMS, $data, false, 10), true);
        if (!isset($getParams['code'])) {
            return data_return_arr('服务正忙，请稍后再试', -1);
        }
        if ($getParams['code'] <> 0) {
            return data_return_arr($getParams['msg'], -1);
        }
        return data_return_arr('ok', 0, $getParams['data']);
    }


    //获取支付二维码内容
    public function get_pay_qrcode($params)
    {
        if (empty($params['akey'])) {
            return data_return_arr('akey未配置', -1);
        }
        if (empty($params['asecret'])) {
            return data_return_arr('asecret未配置', -1);
        }
        if (empty($params['product_id'])) {
            return data_return_arr('扫码支付商品标识必须填写', -1);
        }
        $data = [
            /* 'appid' => $params['appid'],*/
            'orderId' => $params['orderId'],
            'subject' => isset($params['subject']) ? $params['subject'] : '',
            'akey' => $params['akey'],
            'product_id'=>$params['product_id']
        ];

        $data['sign'] = $this->get_sign($data, $params['asecret']);//签名验证

        $getParams = json_decode($this->HttpRequest(self::URI_GET_PAY_QRCPDE, $data, false, 10), true);
        if (!isset($getParams['code'])) {
            return data_return_arr('服务正忙，请稍后再试', -1);
        }
        if ($getParams['code'] <> 0) {
            return data_return_arr($getParams['msg'], -1);
        }
        return data_return_arr('ok', 0, $getParams['data']);
    }

    //获取支付中台的余额
    public function get_balance($params = [])
    {
        if (empty($params['akey'])) {
            return data_return_arr('akey未配置', -1);
        }
        if (empty($params['asecret'])) {
            return data_return_arr('asecret未配置', -1);
        }

        $data = [
            'client' => fromClient(),
            'time' => time(),
            'akey' => $params['akey'],
            'noncestr' => get_random(32)
        ];

        $data['sign'] = $this->get_sign($data, $params['asecret']);//签名验证

        $res = json_decode($this->HttpRequest(self::URI_GET_TIXIAN_BALANCE, $data, false, 10), true);
        if (!isset($res['code'])) {
            return data_return_arr('服务正忙，请稍后再试', -1, $res);
        }
        if ($res['code'] <> 0) {
            return data_return_arr($res['msg'], -1);
        }

        return data_return_arr('ok', 0, $res);
    }

    //设置状态
    public function set_tixian_order($params = [])
    {
        if (!isset($params['status'])) {
            return data_return_arr('status未设置', -1);
        }
        if (empty($params['akey'])) {
            return data_return_arr('akey未配置', -1);
        }
        if (empty($params['asecret'])) {
            return data_return_arr('asecret未配置', -1);
        }

        $data = [
            'client' => fromClient(),
            'time' => time(),
            'status' => intval($params['status']),
            'akey' => $params['akey'],
            'noncestr' => createNoncestr(32)
        ];

        $data['sign'] = $this->get_sign($data, $params['asecret']);//签名验证

        $res = json_decode($this->HttpRequest(self::URI_SET_TIXIAN_ORDER_STATUS, $data, false, 10), true);
        if (!isset($res['code'])) {
            return data_return_arr('服务正忙，请稍后再试', -1, $res);
        }
        if ($res['code'] <> 0) {
            return data_return_arr($res['msg'], -1);
        }

        return data_return_arr('ok', 0, $res);
    }


    /**
     * 支付回调处理
     * @param   [array]           $params [输入参数]
     * @version 1.0.0
     * @date    2020-02-15
     * @desc    description
     * @author   Brisklan
     * @blog    http://blog.alipay168.cn/
     */
    public function pay_result($params = [])
    {
        $params = $params['form'];
        if ($params['sign'] == $this->get_sign($params)) {
            return data_return_arr('支付成功', 0, $this->ReturnData($params['payData']));
        }
        common::add_log('支付回调签名错误', $params);
        return data_return_arr('处理异常错误', -100);
    }

    /**
     * [ReturnData 返回数据统一格式]
     * @param    [array]                   $data [返回数据]
     * @version  1.0.0
     * @datetime 2018-10-06T16:54:24+0800
     * @author   Brisklan
     * @blog     http://blog.alipay168.cn/
     */
    private function ReturnData($data)
    {
        // 返回数据固定基础参数
        $data['trade_no'] = $data['transaction_id'];  // 支付平台 - 订单号
        $data['buyer_user'] = $data['openid'];          // 支付平台 - 用户
        $data['out_trade_no'] = $data['outOrder'];            // 本系统发起支付的 - 订单号
        $data['subject'] = $data['attach'];          // 本系统发起支付的 - 商品名称
        $data['pay_price'] = $data['total_fee'] / 100;   // 本系统发起支付的 - 总价
        return $data;
    }

    /**
     * 退款处理
     * @param   [array]           $params [输入参数]
     * @version 1.0.0
     * @date    2019-05-28
     * @desc    description
     * @author  Brisklan
     * @blog    http://blog.alipay168.cn/
     */
    public function Refund($params = [])
    {
        // 参数
        $p = [
            ['checked_type' => 'empty', 'key_name' => 'order_no', 'error_msg' => '订单号不能为空',],
            //['checked_type' => 'empty', 'key_name' => 'trade_no', 'error_msg' => '交易平台订单号不能为空',],
            ['checked_type' => 'empty', 'key_name' => 'pay_price', 'error_msg' => '支付金额不能为空',],
            ['checked_type' => 'empty', 'key_name' => 'refund_price', 'error_msg' => '退款金额不能为空',],
        ];
        $ret = ParamsChecked($params, $p);
        if ($ret !== true) {
            return data_return_arr($ret, -1);
        }

        // 退款原因
        $refund_reason = empty($params['refund_reason']) ? $params['order_no'] . '订单退款' . $params['refund_price'] . '元' : $params['refund_reason'];
        // 请求参数
        $data = [
            'nonce_str' => md5(time() . rand() . $params['order_no']),
            'sign_type' => 'MD5',
            'transaction_id' => $params['trade_no'],
            'out_refund_no' => $params['order_no'] . GetNumberCode(6),
            'total_fee' => intval($params['pay_price'] * 100),
            'refund_fee' => intval($params['refund_price'] * 100),
            'refund_desc' => $refund_reason,
            'akey' => $params['akey'],
            'outId' => $params['order_no'],
            'channel' => 'wx',//退款渠道
        ];
        $data['sign'] = $this->get_sign($data, $params['asecret']);

        // 请求接口处理
        $result = json_decode($this->HttpRequest(self::URI_REFUND_ORDER, $data, false, 30), true);

        if ($result['code'] == 0) {
            // 统一返回格式
            $data = $result['data'];
            if ($data['sign'] <> $this->get_sign($data, $params['asecret'])) {
                common::add_log('退款回调签名错误', $data);
                return data_return_arr('签名错误', -1);
            }
            return data_return_arr('退款成功', 0, $data);
        }

        return data_return_arr('退款异常' . $result['msg'], -1, $result);
    }

    /**
     * 签名生成
     * @param   [array]           $params [输入参数]
     * @version 1.0.0
     * @date    2019-01-07
     * @desc    description
     * @author   Brisklan
     * @blog    http://blog.alipay168.cn/
     */
    //生成当前请求的签名
    function get_sign($param, $secret = '')
    {
        $secret = $secret ? $secret : $this->config['asecret'];
        $str = '';
        ksort($param);//key用ascii从小到大排序
        foreach ($param as $k => $v) {
            if (!empty($v) && !is_array($v) && $k <> 'sign') {
                $str .= $k . $v;
            }
        }
        $end_str = $secret . $str . $secret;//对称拼接
        return strtoupper(md5($end_str));//将字符串用MD5加密后转换大写
    }

    /**
     * 数组转xml
     * @param   [array]          $data [数组]
     * @version 1.0.0
     * @date    2019-01-07
     * @desc    description
     * @author   Brisklan
     * @blog    http://blog.alipay168.cn/
     */
    private function ArrayToXml($data)
    {
        $xml = '<xml>';
        foreach ($data as $k => $v) {
            $xml .= '<' . $k . '>' . $v . '</' . $k . '>';
        }
        $xml .= '</xml>';
        return $xml;
    }


    /**
     * [HttpRequest 网络请求]
     * @param    [string]          $url         [请求url]
     * @param    [array]           $data        [发送数据]
     * @param    [boolean]         $use_cert    [是否需要使用证书]
     * @param    [int]             $second      [超时]
     * @return   [mixed]                        [请求返回数据]
     * @version  1.0.0
     * @datetime 2017-09-25T09:10:46+0800
     * @author   Brisklan
     * @blog     http://blog.alipay168.cn/
     */
    private function HttpRequest($url, $data, $use_cert = false, $second = 30)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_TIMEOUT => $second,
        );

        if ($use_cert == true) {
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            $apiclient = $this->GetApiclientFile();
            $options[CURLOPT_SSLCERTTYPE] = 'PEM';
            $options[CURLOPT_SSLCERT] = $apiclient['cert'];
            $options[CURLOPT_SSLKEYTYPE] = 'PEM';
            $options[CURLOPT_SSLKEY] = $apiclient['key'];
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        //返回结果
        if ($result) {
            curl_close($ch);
            return $result;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return "curl出错，错误码:$error";
        }
    }

    /**
     * 获取证书文件路径
     * @author  Brisklan
     * @blog    http://blog.alipay168.cn/
     * @version 1.0.0
     * @date    2019-05-29
     * @desc    description
     */
    private function GetApiclientFile()
    {
        // 证书位置
        $apiclient_cert_file = ROOT . 'runtime' . DS . 'temp' . DS . 'payment_weixin_pay_apiclient_cert.pem';
        $apiclient_key_file = ROOT . 'runtime' . DS . 'temp' . DS . 'payment_weixin_pay_apiclient_key.pem';

        $apiclient_cert = "-----BEGIN CERTIFICATE-----\n";
        $apiclient_cert .= wordwrap($this->config['apiclient_cert'], 64, "\n", true);
        $apiclient_cert .= "\n-----END CERTIFICATE-----";
        file_put_contents($apiclient_cert_file, $apiclient_cert);

        $apiclient_key = "-----BEGIN PRIVATE KEY-----\n";
        $apiclient_key .= wordwrap($this->config['apiclient_key'], 64, "\n", true);
        $apiclient_key .= "\n-----END PRIVATE KEY-----";
        file_put_contents($apiclient_key_file, $apiclient_key);

        return ['cert' => $apiclient_cert_file, 'key' => $apiclient_key_file];
    }
}
