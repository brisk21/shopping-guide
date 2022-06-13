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
    }

    public function get_uid($unionCode)
    {
        return (new CommonUser())->getUidByUinodCode($unionCode);
    }
}