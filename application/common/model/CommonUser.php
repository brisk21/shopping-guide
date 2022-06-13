<?php


namespace app\common\model;


class CommonUser extends Base
{
    public function getUidByUinodCode($unionCode)
    {
        return $this->where(['union_code'=>trim($unionCode)])->value('uid');
    }
}