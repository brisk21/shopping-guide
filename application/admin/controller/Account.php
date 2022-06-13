<?php


namespace app\admin\controller;


use app\common\controller\AppCommon;
use app\service\DiyLog;
use think\Controller;
use think\Request;
use think\Session;

class Account extends Controller
{
    private $param = null;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->param = input();
    }

    public function login()
    {
        return $this->fetch();
    }

    //忘记密码
    public function forget_pwd()
    {
        return $this->fetch();
    }

    public function do_login()
    {
        if (empty($this->param['account'])) {
            data_return('账号未设置', -1);
        } elseif (empty($this->param['pwd'])) {
            data_return('密码未输入', -1);
        }
        $data = AppCommon::data_get('admin', ['account' => trim($this->param['account'])], 'id,uid,pwd,salt,pwd_err_count,up_time,loginCount');

        if (empty($data)) {
            data_return('账号不存在', -1);
        }
        if ($data['pwd_err_count'] >= 5 && ($data['up_time'] > time() - 1800)) {
            data_return('密码错误次数过多，请稍后重试', -1);
        }
        if (md5($this->param['pwd'] . $data['salt']) <> $data['pwd']) {
            AppCommon::data_update('admin', ['id' => $data['id']], ['pwd_err_count' => $data['pwd_err_count'] + 1, 'up_time' => time()]);
            data_return('账号密码不匹配', -1);
        }
        //重生盐值加密
        $salt = get_random(10, false);
        $pwd = md5($this->param['pwd'] . $salt);
        AppCommon::data_update('admin', ['id' => $data['id']],
            ['pwd_err_count' => 0, 'salt' => $salt, 'pwd' => $pwd, 'loginCount' => $data['loginCount'] + 1]);

        $loginData = [
            'uid' => $data['uid'],
            'add_time' => time(),
            'ip' => get_ip()
        ];
        AppCommon::data_add('admin_login_log', $loginData);


        session('admin_uid', $data['uid'], 'bs_admin_');

        //登录成功返回的链接
        $backUrl = cookie('admin_backurl');
        if (!$backUrl) {
            $backUrl = url('/admin/index/index');
        } else {
            cookie('admin_backurl', null);
        }
        data_return('登录成功', 0, ['url' => $backUrl]);
    }

    //退出登录
    public function logout()
    {
        session('admin_uid', null, 'bs_admin_');
        return $this->redirect(url('login'));
    }
}