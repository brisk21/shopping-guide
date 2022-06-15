<?php


namespace app\common\model;


class AdminLoginLog extends Base
{
    public function addData($data, $isSaveAll = false)
    {
        if ($isSaveAll) {
            return self::allowField(true)->saveAll($data);
        }
        return self::allowField(true)->save($data);
    }
}