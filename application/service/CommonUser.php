<?php


namespace app\service;


use app\common\controller\AppCommon;

class CommonUser
{
    private static $session_pre = 'bs_common_user_';
    //公共用户缓存key
    public static $key_cache_user = 'common_user_uid';
    //前后分离key
    public static $key_cache_user_token = 'common_user_token';
    //缓存前缀
    public static $session_prefix = 'bs_dg_';
    /**
     * app登录token默认7天有效
     */
    const app_token_expire = 604800;

    /**新增用户
     * @param $uid int|string 用户的id或者uid
     * @param string $field
     * @return array|bool|\PDOStatement|string|\think\Model|null
     */
    public static function get($uid, $field = '*')
    {
        $where = ['uid' => $uid];
        if (is_numeric($uid)) {
            $where = ['id' => intval($uid)];
        }

        return AppCommon::data_get('common_user', $where, $field);
    }

    /**
     * 创建账号
     * @param $data
     * @return false|int|string
     */
    public static function add($data)
    {
        if (empty($data['uid'])) {
            return false;
        }
        $conf = ConfigService::get('mobile_shop');
        if (empty($conf['reg_type']) || $conf['reg_type'] == -1) {
            return false;
        }

        $id = AppCommon::data_add('common_user', [
            'account' => !empty($data['account']) ? strip_tags($data['account']) : '',
            'uid' =>!empty($data['uid']) ? $data['uid'] : self::make_uid(),
            'union_code' => !empty($data['union_code']) ? $data['union_code'] : self::make_union_code(),
            'pwd' => !empty($data['pwd']) ? $data['pwd'] : md5(get_random(32)),
            'salt' => get_random(10),
            'add_time' => time(),
            'up_time' => time(),
            'status' => 0,
            'loginCount' => !empty($data['loginCount']) ? $data['loginCount'] : 0,
            'nickname' => !empty($data['nickname']) ? $data['nickname'] : '',
            'remark' => !empty($data['remark']) ? $data['remark'] : '',
            'openid_wx' => !empty($data['openid_wx']) ? $data['openid_wx'] : '',
        ]);
        if ($id && !empty($conf['reg_gift_credit'])) {
            $res = Credits::update($data['uid'], 'credit', $conf['reg_gift_credit'], [
                'remark' => '注册赠送余额',
                'type' => 2,//1-购买商品，2-充值记录，3-提现记录,
            ]);
        }
        return $id;
    }

    private static function _get_num_code($length=6)
    {
        $str = '123456789';
        $code = '';
        for ($i=0;$i<$length;$i++){
            $code.= $str[mt_rand(1,strlen($str))-1];
        }
        return $code;
    }

    public static function make_union_code()
    {
        $code = self::_get_num_code(6);
        while (true) {
            if (!AppCommon::data_get('common_user', ['union_code' => $code], 'id')) {
                break;
            }
            $code =self::_get_num_code(6);
        }
        return $code;
    }

    public static function make_uid()
    {
        $uid = 'bs' . md5(get_random(32) . rand(111111, 999999) . time() . microtime(true));
        while (true) {
            if (empty(AppCommon::data_get('common_user', ['uid' => $uid], 'id'))) {
                break;
            }
            $uid = 'bs' . md5(get_random(32) . rand(111111, 999999) . time() . microtime(true));
        }
        return $uid;
    }

    /**
     * 更新信息
     * @param $uid
     * @param $data
     * @return false|int|string
     */
    public static function update($uid, $data)
    {
        if (!self::get($uid)) {
            return false;
        }
        return AppCommon::data_update('common_user', ['uid' => $uid], $data);
    }

    /**
     * 登录记录
     * @param $uid
     * @return int|string
     */
    public static function add_login_log($uid)
    {
        return AppCommon::data_add('common_user_login_log', [
            'uid' => $uid,
            'add_time' => time(),
            'ip' => get_ip(),
        ]);
    }

    /**
     * 对比密码
     * @param $uid
     * @param $pwd
     * @return bool
     */
    public static function compare_pwd($uid, $pwd)
    {
        $user = self::get($uid, 'pwd,salt');

        if (md5($pwd . $user['salt']) <> $user['pwd']) {
            return false;
        }
        return true;
    }


    /**
     * 通过微信unionid或者openid获取某条记录
     * @param $value string openid或者unionid
     * @param string $key
     * @param string $field 需要查询的字段
     * @return array|bool|\PDOStatement|string|\think\Model|null
     */
    public static function get_wx_user($value, $key = 'openid_wx', $field = '*')
    {
        //todo 添加unionid、openid_wxxcx、openid_app等平台
        if (!in_array($key, ['openid_wx'])) {
            return false;
        }

        $where[$key] = $value;
        return AppCommon::data_get('common_user', $where, $field);
    }


    /**
     * 设置session
     * @param $uid
     * @return array
     */
    public static function session_set($uid)
    {
        $user = self::get($uid, 'uid,status');
        if (!$user) {
            return ['code' => -1, 'msg' => '账号未注册'];
        }
        if ($user['status']) {
            return ['code' => -1, 'msg' => '账号异常，请联系客服'];
        }
        session(self::$key_cache_user, $uid, self::$session_prefix);

        //简单生成一个token
        $key = md5(get_random(32) . time());
        $token = base64_encode($key);
        //清理其它token
        cache(null, self::$key_cache_user . $user['uid']);
        //设置新的token
        cache(self::$key_cache_user_token . $key, $user['uid'], ['expire' => 86400 * 7], self::$key_cache_user . $user['uid']);

        return ['code' => 0, 'msg' => 'ok', 'token' => $token];
    }


    /**
     * 获取session
     * @return mixed
     */
    public static function session_get()
    {
        return session(self::$key_cache_user, '', self::$session_prefix);
    }

    /**
     * 删除session
     * @param string $uid
     * @return mixed
     */
    public static function session_del($uid = '')
    {
        if ($uid) {
            cache(null, self::$key_cache_user . $uid);
        }

        return session(self::$key_cache_user, null, self::$session_prefix);
    }

    /**
     * APP登录token
     * @param $uid
     * @return array
     */
    public static function app_token_make($uid)
    {
        $user = self::get($uid, 'uid,status');
        if (!$user) {
            return ['code' => -1, 'msg' => '账号未注册'];
        }
        if ($user['status']) {
            return ['code' => -1, 'msg' => '账号异常，请联系客服'];
        }

        $token = md5(get_random(32) . microtime(true));

        //设置新的token
        cache($token, $user['uid'], self::app_token_expire);
        return ['code' => 0, 'msg' => 'ok', 'token' => $token];
    }

    /**
     * 通过token获取用户信息
     * @param $token
     * @param string $field
     * @return array|bool|\PDOStatement|string|\think\Model|null
     */
    public static function app_token_user($token, $field = '*')
    {
        $uid = cache($token);
        return $uid ? self::get($uid, $field) : false;

    }
}