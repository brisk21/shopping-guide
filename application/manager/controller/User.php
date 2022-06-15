<?php


namespace app\manager\controller;


use app\common\controller\AppCommon;
use app\common\model\Admin;
use app\common\model\AdminLoginLog;


class User extends Base
{

    public function info()
    {
        data_return('success', 0, [
            'info' => [
                'user_name' => $this->admin['user_name'],
                'account' => $this->admin['account'],
                'isSuper' => empty($this->admin['role_id'])
            ]
        ]);
    }

    public function logout()
    {
        cache($this->token,null,-1,$this->token_tag);
        data_return('退出成功',0);
    }

    public function login()
    {
        if (!request()->isPost()) {
            data_return('非法请求', -1);
        }
        if (empty($this->param['account'])) {
            data_return('账号未设置', -1);
        }
        if (empty($this->param['pwd'])) {
            data_return('请填写密码', -1);
        }
        $model = new Admin();

        $data = $model->fetchData(['account' => trim($this->param['account'])]);

        if (empty($data)) {
            data_return('账号不存在', -1);
        }
        if ($data['pwd_err_count'] >= 5 && ($data['up_time'] > time() - 1800)) {
            data_return('密码错误次数过多，请稍后重试', -1);
        }
        if (md5($this->param['pwd'] . $data['salt']) <> $data['pwd']) {
            $model->saveData($data['id'], [
                'pwd_err_count' => $data['pwd_err_count'] + 1
            ]);
            data_return('账号密码不匹配', -1, md5($this->param['pwd'] . $data['salt']));
        }
        //重生盐值加密
        $salt = get_random(10, false);
        $pwd = md5($this->param['pwd'] . $salt);
        $model->saveData($data['id'], [
            'pwd_err_count' => 0,
            'salt' => $salt,
            'loginCount' => $data['loginCount'] + 1,
            'pwd' => $pwd
        ]);

        $loginData = [
            'uid' => $data['uid'],
            'add_time' => time(),
            'ip' => get_ip()
        ];
        (new AdminLoginLog())->addData($loginData);

        $token = $this->_get_token_make($data['uid']);

        data_return('登录成功', 0, ['token' => $token]);
    }

    /**
     * 登录token
     */
    private function _get_token_make($uid)
    {
        $token = md5($uid . get_random(32) . microtime(true) . get_random(32));
        //设置新的token
        cache($token, $uid, $this->token_expire, $this->token_tag);
        return $token;
    }



}