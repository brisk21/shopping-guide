<?php


namespace app\union\controller\api;


use app\common\controller\AppCommon;
use app\service\CommonUser;
use app\service\ConfigService;
use app\service\DiyLog;
use app\service\Msg;
use app\service\VerifyCode;
use app\service\WechatService;
use think\Controller;
use think\Request;

class Account extends Controller
{
    public $param;

    protected $uid = '';

    private $keyBackTo = 'bs_shop_console_back_uri';

    private $defaultUrl;
    //授权代理域名
    protected $wxAuthDomain = 'https://wxauth.alipay168.cn';

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->param = input();
    }


    //商城配置
    public function config()
    {
        $conf = ConfigService::get('mobile_shop');
        if (!empty($conf)) {
            data_return('ok', 0, $conf);
        }
        data_return('未配置', -1);
    }

    /**
     * 微信登录逻辑
     * @param $openid
     */
    private function wx_login_logic($openid)
    {
        $data = CommonUser::get_wx_user($openid, 'openid_wx', 'uid,loginCount,status');

        if (!empty($data)) {
            if (!empty($data['status'])) {
                data_return('账号异常，请联系管理', -1);
            }

            CommonUser::add_login_log($data['uid']);
            CommonUser::update($data['uid'], ['pwd_err_count' => 0, 'loginCount' => $data['loginCount'] + 1]);

            cookie('my_gzh_openid', $openid);
        } else {
            //生成账号
            $this->param['account'] = get_random(20);
            while (true) {
                $has = AppCommon::data_get('common_user', ['account' => trim($this->param['account'])], 'id');
                if (empty($has['id'])) {
                    break;
                }
                $this->param['account'] = get_random(20);
            }

            $salt = get_random(10, false);
            $uid = CommonUser::make_uid();
            $data = [
                'account' => trim($this->param['account']),
                'uid' => $uid,
                'pwd' => md5(get_random(32) . $salt),
                'salt' => $salt,
                'add_time' => time(),
                'up_time' => time(),
                'status' => 0,
                'loginCount' => 1,
                'nickname' => '用户' . get_random(6, true),
                'remark' => '微信创建',
                'openid_wx' => $openid,
            ];

            CommonUser::add($data);

            CommonUser::add_login_log($data['uid']);
            Msg::add($data['uid'], [
                'title' => '账号创建成功',
                'content' => '您的账号是：' . $this->param['account'] . '，微信账号和注册账号一样的权限，若未绑定手机号、邮箱则本账号属于临时账号，临时账号如果进行解绑微信后下次微信登录不会匹配到本账号，如需要再次使用请记录本账号，并让后台管理帮您绑定邮箱、手机号操作后即可成为正常可登录账号或者修改密码或者您一直用微信授权登录，。<span style="color: red;display: block;">需要充值、下单请务必记得账号，否则难以找回。</span>',
                'type' => 1
            ]);
        }
        //设置登录状态
        cookie('my_gzh_openid', $openid);
        $setSession = CommonUser::session_set($data['uid']);
        if ($setSession['code'] <> 0) {
            data_return($setSession['msg'], -1);
        }
        $url = cookie($this->keyBackTo);
        cookie($this->keyBackTo, null);
        if (!IS_AJAX) {
            return $this->success('登录成功', $url ? $url : $this->defaultUrl,'',1);
        }

        data_return('登录成功', 0, ['token' => $setSession['token'], 'url' => $url ? $url : $this->defaultUrl]);
    }

    /**
     * 微信登录
     */
    public function wx_login()
    {
        if (fromClient() <> 'weixin') {
            if (!IS_AJAX) {
                return $this->error('请在微信环境使用');
            }
            data_return('请在微信环境使用', -1);
        }
        $conf = WechatService::get_gzh_conf();
        if (empty($conf['pt'])) {
            if (!IS_AJAX) {
                return $this->error('未配置公众号信息');
            }
            data_return('未配置公众号信息', -1);
        }
        if ($conf['pt'] == 'wei1-top') {

            if (empty($this->param['bscode']) && IS_AJAX) {
                $type = !empty($conf['userinfo']) ? 'userInfo' : 'openid';
                $curl = URL_WEB . trim(url('/console/account/login', ['from' => 'wx-login']), '/');
                $url = $this->wxAuthDomain . "/weixin/gzh/$type/akey/" . $conf['akey'] . ".html?my_redirect_uri=" . urlencode($curl);
                if (!IS_AJAX) {
                    return $this->success('正在跳转微信授权，请稍后...', $url, '', 1);
                }
                data_return('正在跳转，请稍后...', 0, ['url' => $url, 'from' => 'code']);
            } elseif (!empty($this->param['bscode']) && IS_AJAX) {
                //获取信息
                $url = $this->wxAuthDomain . "/weixin/gzh/get_info";
                $req = @json_decode(curl_post_request_array($url, ['bscode' => $this->param['bscode'], 'akey' => $conf['akey']], 10), true);
                if (empty($req['data']) || !empty($req['code'])) {
                    data_return('授权失败' . (empty($req['msg']) ? '' : ':' . $req['msg']), -1);
                }

                $this->wx_login_logic($req['data']['openid']);
            }

        } else {
            if (!empty($this->param['code']) && IS_AJAX) {

                $getOpenid = WechatService::get_openid($this->param['code']);
                if (empty($getOpenid['data']['openid'])) {
                    data_return('微信授权失败:' . $getOpenid['msg'], -1);
                }
                $openid = $getOpenid['data']['openid'];
                $this->wx_login_logic($openid);
            } elseif (empty($this->param['code'])) {
                $conf = ConfigService::get('mobile_shop');
                if (empty($conf['wx_login'])) {
                    data_return('后台未开启微信登录功能', -1);
                }
                //前后方分离模式，回跳到登录界面，通过ajax用code发起授权openid获取
                $url = URL_WEB . trim(url('/console/account/login', ['from' => 'wx-login']), '/');
                $codeUrl = WechatService::get_code($url, false);
                if ($codeUrl['code'] <> 0) {
                    if (!IS_AJAX) {
                        return $this->error($codeUrl['msg']);
                    }
                    data_return($codeUrl['msg'], -1);
                }
                if (!IS_AJAX) {
                    return $this->redirect($codeUrl['data']['url']);
                }
                data_return('正在跳转，请稍后...', 0, ['url' => $codeUrl['data']['url'], 'from' => 'code']);
            }
        }
        if (!IS_AJAX) {
            return $this->error('内部授权错误');
        }
        data_return('内部授权错误', -1);
    }

    private function wx_bind_logic($openid, $uid)
    {
        CommonUser::update($this->uid, ['openid_wx' => $openid, 'up_time' => time()]);

        Msg::add($uid, [
            'title' => '绑定微信成功',
            'content' => '您已成功绑定微信，下次可以直接用微信登录咯，如果需要解绑请从【设置】》【菜单导航】》【解绑微信】',
            'type' => 1
        ]);
        $url = cookie($this->keyBackTo);
        cookie($this->keyBackTo, null);
        data_return('绑定成功', 0, ['from' => 'bind', 'url' => $url ? $url : $this->defaultUrl]);
    }

    /**
     * 绑定微信
     */
    public function wx_bind()
    {
        $user = CommonUser::get($this->uid, 'uid,openid_wx');
        if (!empty($user['openid_wx'])) {
            data_return('您已绑定微信,可以直接用微信登录', -1);
        }
        if (fromClient() <> 'weixin') {
            data_return('请在微信环境使用', -1);
        }
        $conf = WechatService::get_gzh_conf();
        if (empty($conf['pt'])) {
            data_return('未配置公众号信息', -1);
        }
        if ($conf['pt'] == 'wei1-top') {
            if (empty($this->param['openid']) && IS_AJAX) {
                $type = !empty($conf['userinfo']) ? 'userInfo' : 'openid';
                $curl = URL_WEB . trim(url('/mall/user/setting', ['from' => 'wx-bind']), '/');
                $url = $this->wxAuthDomain. "/weixin/gzh/$type/akey/" . $conf['akey'] . ".html?my_redirect_uri=" . urlencode($curl);
                data_return('正在跳转授权，请稍后...', 0, ['url' => $url, 'from' => 'code']);
            } elseif (!empty($this->param['openid']) && IS_AJAX) {
                $openid = $this->param['openid'];
                $this->wx_bind_logic($openid, $this->uid);
            }
        } else {
            if (!empty($this->param['code']) && IS_AJAX) {

                $getOpenid = WechatService::get_openid($this->param['code']);
                if (empty($getOpenid['data']['openid'])) {
                    data_return('微信授权失败:' . $getOpenid['msg'], -1);
                }
                $openid = $getOpenid['data']['openid'];
                $this->wx_bind_logic($openid, $this->uid);

            } elseif (empty($this->param['code'])) {
                $conf = ConfigService::get('mobile_shop');
                if (empty($conf['wx_login'])) {
                    data_return('后台未开启微信登录功能', -1);
                }

                $url = URL_WEB . trim(url('/mall/user/setting', ['from' => 'wx-bind']), '/');
                $codeUrl = WechatService::get_code($url, false);
                if ($codeUrl['code'] <> 0) {
                    data_return($codeUrl['msg'], -1);
                }
                data_return('正在跳转授权，请稍后...', 0, ['url' => $codeUrl['data']['url'], 'from' => 'code']);
            }
        }

    }

    public function wx_unbind()
    {
        $user = CommonUser::get($this->uid, 'uid,openid_wx');
        if (empty($user['openid_wx'])) {
            data_return('您未绑定微信', -1);
        }
        CommonUser::update($this->uid, ['openid_wx' => '', 'up_time' => time()]);
        cookie('my_gzh_openid', null);
        data_return('解绑成功');
    }

    //获取图形验证码
    public function get_vcode()
    {
        return captcha($id = 'bs_vcode', $config = [
            // 中文验证码字符串
            'useImgBg' => false,
            // 使用背景图片
            'fontSize' => 30,
            // 验证码字体大小(px)
            'useCurve' => true,
            // 是否画混淆曲线
            'useNoise' => true,
            // 是否添加杂点
            'imageH' => 0,
            // 验证码图片高度
            'imageW' => 0,
            // 验证码图片宽度
            'length' => 4,
            // 验证码位数
            'fontttf' => '',
            // 验证码字体，不设置随机获取
            'bg' => [243, 251, 254],
            // 背景颜色
            'reset' => true,
            // 验证成功后是否重置
            'useArithmetic' => false //是否使用算术验证码
        ]);
    }

    //动态码
    public function get_dcode()
    {
        $conf = ConfigService::get('mobile_shop');
        if (empty($conf['reg_type']) || $conf['reg_type'] == -1) {
            data_return('系统已关闭注册', -1);
        }
        /*if (empty($this->param['vcode'])) {
           // data_return('请填写图形验证码', -1);
        }
        if (!captcha_check($this->param['vcode'], 'bs_vcode')) {
            data_return('图形验证码不正确', -1);
        }*/
        if (empty($this->param['account'])) {
            data_return('请填写账号', -1);
        }
        //1-仅手机，2-仅邮箱，3-手机或者邮箱，4-任意字符串，-1-关闭注册
        $type = $conf['reg_type'];
        if ($type == 4) {
            data_return('此注册类型无需动态码', -1);
        } elseif ($type == 1) {
            if (!is_phone($this->param['account'])) {
                data_return('目前仅支持手机号注册');
            }
            $res = VerifyCode::send($this->param['account']);
            if ($res['code'] <> 0) {
                data_return($res['msg'], -1);
            }
            data_return('发送成功,注意查收');
        } elseif ($type == 2) {
            if (!is_email($this->param['account'])) {
                data_return('目前仅支持邮箱注册');
            }
            $res = VerifyCode::send($this->param['account']);
            if ($res['code'] <> 0) {
                data_return($res['msg'], -1);
            }
            data_return('发送成功,注意查收');
        } elseif ($type == 3) {
            if (!is_email($this->param['account']) && !is_phone($this->param['account'])) {
                data_return('仅支持手机号或者邮箱注册', -1);
            }
            $res = VerifyCode::send($this->param['account']);
            if ($res['code'] <> 0) {
                data_return($res['msg'], -1);
            }
            data_return('发送成功,注意查收');
        }

        data_return('系统错误', 500, $type);
    }

    //获取找个密码的动态码
    public function get_forget_pwd_dcode()
    {
        if (empty($this->param['account'])) {
            data_return('登录账号未设置', -1);
        }
        if (empty($this->param['vcode'])) {
            data_return('请填写图形验证码', -1);
        }
        if (!captcha_check($this->param['vcode'], 'bs_vcode')) {
            data_return('图形验证码不正确', -1);
        }
        $user = AppCommon::data_get('common_user', ['account' => trim($this->param['account'])]);
        if (empty($user)) {
            data_return('账号不存在', 401);
        }
        if (!is_email($this->param['account']) && !is_phone($this->param['account'])) {
            data_return('仅支持手机号或者邮箱账户', -1);
        }
        $res = VerifyCode::send($this->param['account']);
        if ($res['code'] <> 0) {
            data_return($res['msg'], -1);
        }
        data_return('发送成功,注意查收');
    }

    //找回密码重置
    public function reset_pwd()
    {
        if (empty($this->param['account'])) {
            data_return('登录账号未设置', -1);
        }
        if (empty($this->param['dcode'])) {
            data_return('请输入动态码', -1);
        }
        if (empty($this->param['pwd'])) {
            data_return('密码没设置', -1);
        }
        if (strlen($this->param['pwd']) < 6) {
            data_return('密码不够安全', -1);
        }
        $user = AppCommon::data_get('common_user', ['account' => trim($this->param['account'])]);

        if (empty($user)) {
            data_return('账号不存在', 401);
        }
        $res = VerifyCode::check_code($user['account'], $this->param['dcode']);
        if ($res['code'] <> 0) {
            data_return($res['msg'], -1);
        }
        $this->do_change_pwd(trim($this->param['pwd']), $user['uid']);
        $url = cookie($this->keyBackTo);
        cookie($this->keyBackTo, null);
        data_return('修改成功', 0, ['url' => $url ? $url : $this->defaultUrl]);
    }

    private function do_change_pwd($newPwd, $uid)
    {
        $salt = get_random(10, false);

        $data = [
            'pwd' => md5($newPwd . $salt),
            'salt' => $salt,
            'up_time' => time(),
            'pwd_err_count' => 0,
        ];
        return CommonUser::update($uid, $data);
    }

    //获取修改密码的动态码
    public function get_change_pwd_dcode()
    {
        $user = AppCommon::data_get('common_user', ['account' => trim($this->param['account'])]);

        if (empty($user)) {
            data_return('账号不存在', 401);
        }
        if (!is_email($user['account']) && !is_phone($user['account'])) {
            data_return('仅支持手机号或者邮箱账户', -1);
        }
        $res = VerifyCode::send($user['account']);
        if ($res['code'] <> 0) {
            data_return($res['msg'], -1);
        }
        data_return('发送成功,注意查收');
    }

    //修改密码
    public function change_pwd()
    {
        if (empty($this->param['dcode'])) {
            data_return('请输入动态码', -1);
        }
        if (empty($this->param['pwd'])) {
            data_return('密码没设置', -1);
        }
        if (strlen($this->param['pwd']) < 6) {
            data_return('密码不够安全', -1);
        }
        $user = CommonUser::get($this->uid, 'account');
        if (empty($user)) {
            data_return('登录超时', 401);
        }
        $res = VerifyCode::check_code($user['account'], $this->param['dcode']);
        if ($res['code'] <> 0) {
            data_return($res['msg'], -1);
        }
        $this->do_change_pwd(trim($this->param['pwd']), $user['uid']);
        $url = cookie($this->keyBackTo);
        cookie($this->keyBackTo, null);

        data_return('修改成功', 0, ['url' => $url ? $url : $this->defaultUrl]);
    }

    //注册操作
    public function reg_action()
    {
        $conf = ConfigService::get('mobile_shop');
        if (empty($conf['reg_type']) || $conf['reg_type'] == -1) {
            data_return('系统已关闭注册', -1);
        }
        $rule = [
            ['type' => 'length', 'key' => 'account', 'rule' => '2,16', 'msg' => '账号2~16字符',],
            ['type' => 'empty', 'key' => 'pwd1', 'rule' => '', 'msg' => '密码不能为空',],
            ['type' => 'empty', 'key' => 'pwd2', 'rule' => '', 'msg' => '确认密码不能为空',],
        ];
        $check = check_param($this->param, $rule);
        if ($check['code'] <> 0) {
            data_return($check['msg'], $check['code']);
        }
        if (strlen($this->param['account']) < 3) {
            data_return('账号不合法', -1);
        }
        if (strlen($this->param['pwd1']) < 6) {
            data_return('密码不够安全', -1);
        }
        //1-仅手机，2-仅邮箱，3-手机或者邮箱，4-任意字符串，-1-关闭注册
        $type = $conf['reg_type'];
        if ($type == 1) {
            if (!is_phone($this->param['account'])) {
                data_return('目前仅支持手机号注册');
            }
        } elseif ($type == 2) {
            if (!is_email($this->param['account'])) {
                data_return('目前仅支持邮箱注册');
            }
            if (empty($this->param['dcode'])) {
                data_return('请输入动态码', -1);
            }
            $res = VerifyCode::check_code($this->param['account'], $this->param['dcode']);
            if ($res['code'] <> 0) {
                data_return($res['msg'], -1);
            }
        } elseif ($type == 3) {
            if (!is_email($this->param['account']) && !is_phone($this->param['account'])) {
                data_return('仅支持手机号或者邮箱注册', -1);
            }
            if (empty($this->param['dcode'])) {
                data_return('请输入动态码', -1);
            }
            $res = VerifyCode::check_code($this->param['account'], $this->param['dcode']);
            if ($res['code'] <> 0) {
                data_return($res['msg'], -1);
            }
        } elseif ($type == 4) {
            if (!captcha_check($this->param['vcode'], 'bs_vcode')) {
                data_return('验证码不正确', -1);
            }
        }


        if ($this->param['pwd1'] !== $this->param['pwd2']) {
            data_return('两次密码不一样', -1);
        }

        $has = AppCommon::data_get('common_user', ['account' => trim($this->param['account'])], 'id');
        if (!empty($has['id'])) {
            data_return('账号已被注册', -1);
        }

        $salt = get_random(10, false);
        $uid = CommonUser::make_uid();
        $data = [
            'account' => trim($this->param['account']),
            'uid' => $uid,
            'pwd' => md5($this->param['pwd1'] . $salt),
            'salt' => $salt, 'add_time' => time(),
            'up_time' => time(),
            'status' => 0,
            'loginCount' => 1,
        ];

        CommonUser::add($data);
        //登录记录
        CommonUser::add_login_log($data['uid']);

        $setSession = CommonUser::session_set($data['uid']);
        if ($setSession['code'] <> 0) {
            data_return($setSession['msg'], -1);
        }
        $url = cookie($this->keyBackTo);
        cookie($this->keyBackTo, null);
        data_return('注册成功', 0, ['token' => $setSession['token'], 'url' => $url ? $url : $this->defaultUrl]);
    }

    //游客登录
    private function login_tmp_user()
    {
        $conf = ConfigService::get('mobile_shop');
        if (empty($conf['login_tmp_user'])) {
            data_return('系统已关闭游客登录功能', -1);
        }
        //生成游客账号
        $this->param['account'] = get_random(20);
        while (true) {
            $has = AppCommon::data_get('common_user', ['account' => trim($this->param['account'])], 'id');
            if (empty($has['id'])) {
                break;
            }
            $this->param['account'] = get_random(20);
        }

        $salt = get_random(10, false);
        $uid = CommonUser::make_uid();
        $data = [
            'account' => trim($this->param['account']),
            'uid' => $uid,
            'pwd' => md5(get_random(32) . $salt),
            'salt' => $salt,
            'add_time' => time(),
            'up_time' => time(),
            'status' => 0,
            'loginCount' => 1,
            'nickname' => '游客' . get_random(6, true),
            'remark' => '游客临时用户',
        ];

        CommonUser::add($data);
        CommonUser::add_login_log($data['uid']);
        $setSession = CommonUser::session_set($data['uid']);
        if ($setSession['code'] <> 0) {
            data_return($setSession['msg'], -1);
        }
        Msg::add($data['uid'], [
            'title' => '游客账号创建成功',
            'content' => '您的账号是：' . $this->param['account'] . '，游客账号拥有和注册账号一样的权限，但仅限本次使用，如需要再次使用请记录本账号，并让后台管理帮您绑定邮箱、手机号或者修改密码，操作后即可成为正常可登录账号。<span style="color: red;display: block;">需要充值、下单请务必记得账号，否则难以找回。</span>',
            'type' => 1
        ]);
        $url = cookie($this->keyBackTo);
        cookie($this->keyBackTo, null);
        data_return('登录成功', 0, ['token' => $setSession['token'], 'url' => $url ? $url : $this->defaultUrl]);
    }



    //退出
    public function logout()
    {
        CommonUser::session_del($this->uid);
        cookie('my_gzh_openid', null);
        $url = cookie($this->keyBackTo);
        cookie($this->keyBackTo, null);

        if (IS_AJAX) {
            data_return('操作成功', 0, [
                'url' => $url ? $url : $this->defaultUrl
            ]);
        }
        return redirect($url ? $url : $this->defaultUrl);
    }


    //获取导航公告文章-详情
    public function get_xieyi_info()
    {
        $data = null;
        $gtype = !empty($this->param['gtype']) ? trim($this->param['gtype']) : 'reg';
        if ($gtype == 'reg') {
            $data = AppCommon::data_get('article_sys', ['id' => 1, 'status' => 1], '*');
        }

        if (!empty($data)) {
            $data['content'] = htmlspecialchars_decode($data['content']);
            $data['add_time'] = date('Y-m-d', $data['add_time']);
            AppCommon::db('article')->where(['id' => $data['id']])->setInc('count_view', 1, 5);
        }

        data_return('ok', 0, [
            'article' => $data
        ]);
    }

    //用户信息
    public function account_info()
    {
        $data = CommonUser::get($this->uid, 'account,uid,status,openid_wx');
        if (empty($data['uid'])) {
            data_return('登录超时', -1);
        }
        data_return('ok', 0, ['user_info' => $data]);
    }


    /**
     * 账号密码登录
     */
    public function pwd_login()
    {
        $from = !empty($this->param['from']) ? trim($this->param['from']) : '';
        if ($from === 'tmp_user') {
            //游客身份
            $this->login_tmp_user();
        }

        if (empty($this->param['account'])) {
            data_return('账号未设置', -1);
        } elseif (empty($this->param['pwd'])) {
            data_return('密码未输入', -1);
        }
        $data = AppCommon::data_get('common_user', ['account' => trim($this->param['account'])], 'id,uid,pwd,salt,pwd_err_count,up_time,loginCount');

        if (empty($data)) {
            data_return('账号不存在', -1);
        }
        if ($data['pwd_err_count'] >= 5 && ($data['up_time'] > time() - 1800)) {
            data_return('密码错误次数过多，请稍后重试', -1);
        }
        if (md5($this->param['pwd'] . $data['salt']) <> $data['pwd']) {
            AppCommon::data_update('common_user', ['id' => $data['id']], ['pwd_err_count' => $data['pwd_err_count'] + 1, 'up_time' => time()]);
            data_return('账号密码不匹配', -1);
        }
        //重生盐值加密
        $salt = get_random(10, false);
        $pwd = md5($this->param['pwd'] . $salt);
        AppCommon::data_update('common_user', ['id' => $data['id']], ['pwd_err_count' => 0, 'salt' => $salt, 'pwd' => $pwd, 'loginCount' => $data['loginCount'] + 1]);

        CommonUser::add_login_log($data['uid']);

        $getToken = CommonUser::app_token_make($data['uid']);
        if ($getToken['code'] <> 0) {
            data_return($getToken['msg'], -1);
        }
        data_return('success', 0, ['token' => $getToken['token']]);
    }

    //验证码登录
    public function code_login()
    {
        if (empty($this->param['account'])) {
            data_return('账号未设置', -1);
        } elseif (empty($this->param['validateCode'])) {
            data_return('请输入动态码', -1);
        }
        $res = VerifyCode::check_code($this->param['account'], $this->param['validateCode']);
        if ($res['code'] <> 0) {
            data_return($res['msg'], -1);
        }
        $data = AppCommon::data_get('common_user', ['account' => trim($this->param['account'])], 'id,uid,up_time,loginCount');

        if (empty($data)) {
            $salt = get_random(10, false);
            $uid = CommonUser::make_uid();
            $data = [
                'account' => trim($this->param['account']),
                'uid' => $uid,
                'pwd' => md5(get_random(32) . $salt),
                'salt' => $salt,
                'add_time' => time(),
                'up_time' => time(),
                'status' => 0,
                'loginCount' => 1,
                'nickname' => '用户' . get_random(6, true),
                'remark' => '验证码注册',
            ];

            $id = CommonUser::add($data);
            if (!$id){
                data_return('注册失败',-1);
            }
        }



        AppCommon::data_update('common_user', ['uid' => $data['uid']], ['pwd_err_count' => 0, 'loginCount' => $data['loginCount'] + 1]);

        CommonUser::add_login_log($data['uid']);

        $getToken = CommonUser::app_token_make($data['uid']);
        if ($getToken['code'] <> 0) {
            data_return($getToken['msg'], -1);
        }
        data_return('success', 0, ['token' => $getToken['token']]);
    }

}