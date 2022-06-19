<?php


namespace app\union\controller\crontab;


use app\common\model\CommonUser;
use think\Controller;
use think\Request;

abstract class Base extends Controller
{
    protected $params;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->params = input();
        $this->_check_key();
    }

    private function _check_key()
    {
        $apiKey = config('api.crontab');
        if (empty($apiKey['apikey'])) data_return('接口配置有误', -1);
        if (empty($this->params['apikey']) || $this->params['apikey'] !== $apiKey['apikey']) {
            data_return('apikey未授权', 500);
        }
    }

    public function get_uid($unionCode)
    {
        return (new CommonUser())->getUidByUinodCode($unionCode);
    }
}