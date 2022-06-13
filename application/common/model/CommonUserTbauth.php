<?php


namespace app\common\model;



class CommonUserTbauth extends Base
{
    public function getOne($condition = [], $field = '')
    {
        $where = [];
        if (!empty($condition['uid'])) {
            $where['uid'] = $condition['uid'];
        }
        if (!empty($condition['relation_id'])) {
            $where['relation_id'] = $condition['relation_id'];
        }
        return self::where($where)->field($field)->find();
    }

    public function getValue($condition,$field)
    {
        $where = [];
        if (!empty($condition['uid'])) {
            $where['uid'] = $condition['uid'];
        }
        if (!empty($condition['relation_id'])) {
            $where['relation_id'] = $condition['relation_id'];
        }
        return self::where($where)->value($field);
    }
}