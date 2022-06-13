<?php


namespace app\service;


use think\response\Redirect;

/**
 * 公众获取用户流程：获取code->获取openid->获取用户信息->自行保存
 * Class WechatService
 * @package app\service
 */
class WechatService
{

    /**
     * 获取公众号配置信息
     * @return array|mixed
     */
    public static function get_gzh_conf()
    {
        $confSet = ConfigService::get('wechat');
        if (empty($confSet['gzh']['appid'])) {
            return data_return_arr('公众号未配置', -1);
        }
        return $confSet['gzh'];
    }

    /**
     * 获取授权code
     * @param $redirectUri string 回跳地址，成功后会带上code参数
     * @param bool $userinfo 是否获取用户信息，不建议
     * @return mixed
     */
    public static function get_code($redirectUri, $userinfo = false)
    {
        $conf = self::get_gzh_conf();
        if (isset($conf['code'])) {
            return $conf;
        }

        if ($userinfo) {
            return data_return_arr('ok',0,['url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $conf['appid'] . '&redirect_uri=' . urlencode($redirectUri) . '&response_type=code&scope=snsapi_userinfo&state=bsshopuserinfo#wechat_redirect']);
        }
        return data_return_arr('ok',0,['url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $conf['appid'] . '&redirect_uri=' . urlencode($redirectUri) . '&response_type=code&scope=snsapi_base&state=bsshop#wechat_redirect']);
    }


    /**
     * 获取用户信息
     * @param $openid
     * @param string $state bsshop_userinfo-返回基本信息
     * @param string $access_token 网页授权时的token，和基本的token不一样，这是授权时获取信息必填的
     * @return array|Redirect
     */
    public static function get_user_info($openid, $state = '', $access_token = '')
    {
        $token = self::get_access_token();
        if ($token['code'] <> 0) {
            return data_return_arr($token['msg'], -1);
        }
        $conf = self::get_gzh_conf();
        if (isset($conf['code'])) {
            return $conf;
        }
        $para = [
            "access_token" => $token['accessToken'],
            "openid" => $openid,
            "lang" => "zh_CN"
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info';
        if ($state == 'bsshopuserinfo') {
            $para['access_token'] = $access_token;
            $url = 'https://api.weixin.qq.com/sns/userinfo';
        }


        $ret = curl_get_request($url, $para);
        $user = json_decode($ret, true);

        if (empty($user)) {
            return data_return_arr('获取用户信息错误', -1, $user);
        }
        if (isset($user['subscribe']) && $user['subscribe'] == 0) {
            //未关注,强制关注
            if (!empty($conf['needSubscribe'])) {
                $qrcode = cache('gzh_qrcode' . $conf['appid']);
                if (!empty($qrcode)) {
                    $user['qrcode'] = $qrcode;
                } else {
                    //生成永久二维码
                    $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $token['accessToken'];
                    $para = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "bs_shop_subscribe"}}}';
                    $ret = curl_post_request($url, $para);
                    $result = json_decode($ret, true);
                    if (!empty($result['ticket'])) {
                        $qrcode = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $result['ticket'];
                        $user['qrcode'] = $qrcode;
                    } /*else {
                        return data_return_arr('生成关注二维码失败', -1, $user);
                    }*/
                }
            }

        }

        //"openid": "oQ9zN5sq_eoq7xwtE6LrKsvFMhXs",
        //"nickname": "琅玡-琪拉",
        //"sex": 0,
        //"language": "",
        //"city": "",
        //"province": "",
        //"country": "",
        //"headimgurl": "https://thirdwx.qlogo.cn/mmopen/vi_32/5ufyfVFs0f29ubu3JYa9kEQ8XhRicLlJAVlYcibhXKQm9kT0fibaib9YZ4uiab6Qib37hkTReQhz9unojTdlRENYuicIQ/132",
        //"privilege": [],
        //"unionid": "oZWycw9t1B-_Z3T4uWhHM5061khI"

        return data_return_arr('ok', 0, $user);
    }


    /**
     * 获取openid
     * @param $code string 授权code
     * @return array
     */
    public static function get_openid($code)
    {
        if (empty($code)) {
            return data_return_arr('请重新授权', -1);
        }
        $conf = self::get_gzh_conf();
        if (isset($conf['code'])) {
            return $conf;
        }
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $conf['appid'] . '&secret=' . $conf['appSecret'] . '&code=' . $code . '&grant_type=authorization_code';
        $json = curl_get_request($url);
        $ret = json_decode($json, true);

        if (empty($ret['openid'])) {
            return data_return_arr('授权失败'.$ret['errmsg'], -1);
        }
        return data_return_arr('ok', 0, ['openid' => $ret['openid'], 'access_token' => empty($ret['access_token']) ? '' : $ret['access_token']]);
    }


    //获取access_token
    public static function get_access_token()
    {
        $conf = self::get_gzh_conf();
        if (isset($conf['code'])) {
            return $conf;
        }

        $cache = cache('wechat_access_token' . $conf['appid']);
        if ($cache) {
            return ["code" => 0, "accessToken" => $cache['accessToken'], 'appid' => $conf['appid']];
        }

        $para = [
            "grant_type" => "client_credential",
            "appid" => $conf['appid'],
            "secret" => $conf['appSecret']
        ];
        $url = "https://api.weixin.qq.com/cgi-bin/token";
        $ret = curl_get_request($url, $para);
        $retData = json_decode($ret, true);

        if (empty($retData) || (isset($retData['errcode']) && $retData['errcode'] > 0) || empty($retData['access_token'])) {
            return ['code' => -1, 'msg' => '获取失败,错误代码：' . $retData['errcode']];
        }
        $token = $retData['access_token'];
        cache('wechat_access_token' . $conf['appid'], [
            'accessToken' => $token,
            'appid' => $conf['appid']
        ], 7000);

        return ['code' => 0, 'accessToken' => $token, 'appid' => $conf['appid']];
    }


    /**
     * 获取票据
     * @return array
     */
    public static function get_ticket()
    {
        $conf = self::get_gzh_conf();
        if (isset($conf['code'])) {
            return $conf;
        }
        $cache = cache('wechat_get_ticket' . $conf['appid']);
        if ($cache) {
            return ["code" => 0, "ticket" => $cache['ticket'], 'appid' => $conf['appid']];
        }

        $data = self::get_access_token();
        if ($data['code'] <> 0) {
            return $data;
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $data['accessToken'] . '&type=jsapi';
        $str = json_decode(curl_get_request($url, [], 10), true);
        if (empty($str['ticket'])) {
            return data_return_arr($str['errmsg'], -1);
        }

        cache('wechat_get_ticket' . $conf['appid'], [
            'ticket' => $str['ticket'],
            'appid' => $conf['appid']
        ], 7000);

        return data_return_arr('ok', 0, [
            'ticket' => $str['ticket'],
            'appid' => $conf['appid']
        ]);
    }

    /**微信jsapi配置获取
     * @param $url string 当前url
     * @return array
     */
    public static function get_jsapi_config($url)
    {
        $getTicket = self::get_ticket();
        if ($getTicket['code'] <> 0) {
            return data_return_arr($getTicket['msg'], -1);
        }
        $time = time();
        $ticket = $getTicket['data']['ticket'];
        $noncestr = get_random(16);
        $str = "jsapi_ticket=$ticket&noncestr=$noncestr&timestamp=$time&url=$url";
        $signature = sha1($str);
        return data_return_arr('ok', 0, [
            "appid" => $getTicket['appid'],
            "signature" => $signature,
            "timestamp" => $time,
            "noncestr" => $noncestr,
            'link' => $url
        ]);
    }
}