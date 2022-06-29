<?php


namespace app\common\model;


use traits\model\SoftDelete;

class CommonUser extends Base
{
    use SoftDelete;
    protected $createTime = 'add_time';
    protected $updateTime = 'up_time';
    protected $deleteTime = 'del_time';
    protected $autoWriteTimestamp = true;
    protected $hidden = ['pwd','salt'];

    protected $append = ['status_text'];

    public function getUidByUinodCode($unionCode)
    {
        return $this->where(['union_code'=>trim($unionCode)])->value('uid');
    }

    public function getStatusTextAttr($value, $data)
    {
        if (!isset($data['status'])) return '';
        return config('param.member')['status'][$data['status']];
    }

    public function addData($data, $isSaveAll = false)
    {
        if ($isSaveAll) {
            return self::allowField(true)->saveAll($data);
        }
        return self::allowField(true)->save($data);
    }

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
            if (!empty($condition['uid'])) $query->where(['uid' => $condition['uid']]);
            if (!empty($condition['id'])) $query->where(['id' => $condition['id']]);
            if (!empty($condition['account'])) $query->where(['account' => trim($condition['account'])]);
            if (!empty($condition['union_code'])) $query->where(['union_code' => intval($condition['union_code'])]);
        });
    }

    public function listData($condition = [], $page = 1, $pageSize = 10, $order = 'id desc')
    {
        return $this
            ->where(function ($query) use ($condition) {
                if (!empty($condition['uid'])) $query->where(['uid' => $condition['uid']]);
                if (isset($condition['status'])) $query->where(['status' => $condition['status']]);
                if (!empty($condition['account'])) $query->where(['account' => trim($condition['account'])]);
                if (!empty($condition['union_code'])) $query->where(['union_code' => intval($condition['union_code'])]);
            })
            ->field(true)
            ->order($order)
            ->page($page, $pageSize)
            ->paginate($pageSize, false, ['page' => $page]);

    }
}