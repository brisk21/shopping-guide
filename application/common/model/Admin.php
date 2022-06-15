<?php


namespace app\common\model;


class Admin extends Base
{
    protected $createTime = 'add_time';
    protected $updateTime = 'up_time';
    protected $autoWriteTimestamp = true;

    public function saveData($id, $data, $isSaveAll = false)
    {
        if ($isSaveAll) {
            return self::allowField(true)->isUpdate(true)->saveAll($data);
        }
        return self::allowField(true)->isUpdate(true)->save($data, ['id' => $id]);
    }

    public function fetchData($condition)
    {
        return self::get(function ($query) use ($condition) {
            if (!empty($condition['account'])) $query->where(['account' => $condition['account']]);
            if (!empty($condition['id'])) $query->where(['id' => $condition['id']]);
            if (!empty($condition['user_name'])) $query->where(['user_name' => $condition['user_name']]);
        });
    }
}