<?php


namespace app\manager\controller;


use app\common\model\Admin;
use think\Controller;
use think\Request;

class Base extends Controller
{
    public $param;
    protected $token_expire = 86400;
    protected $token_tag = 'manger';

    protected $admin;
    protected $token = null;

    //无需验证token的路由，转换为小写
    protected $noAuth = [
        'user' => [
            'login'
        ],
    ];


    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->param = $request->param();
        $this->_check_authed($request);
    }


    private function _check_authed(Request $request)
    {
        $controller = strtolower($request->controller());
        $action = strtolower($request->action());
        if (key_exists($controller, $this->noAuth) && in_array($action, $this->noAuth[$controller])) {
            return;
        }
        $token = $request->header('token', '');
        if (!$token) {
            data_return('登录超时', 403);
        }
        if (!$uid = cache($token, '', null, $this->token_tag)) {
            data_return('登录超时', 403);
        }
        $user = (new Admin())->fetchData(['uid' => $uid]);
        if (!$user) {
            data_return('登录超时', 403);
        } elseif ($user['status'] <> 1) {
            data_return('账号已被限制登录，请联系运营', -1);
        }
        unset($user['pwd']);
        $this->token = $token;
        $this->admin = $user;
    }
}