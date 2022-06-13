<?php


namespace app\common\model;


class UnionFeedback extends Base
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'add_time';
    protected $updateTime = 'up_time';
}