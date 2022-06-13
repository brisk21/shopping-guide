<?php


namespace app\common\model;


class UnionPddOrder extends Base
{
    protected $createTime = 'add_time';
    protected $updateTime = 'up_time';
    protected $autoWriteTimestamp = true;


    public function addData($data, $saveAll = false)
    {
        if ($saveAll) {
            return self::allowField(true)->saveAll($data);
        }
        return self::allowField(true)->save($data);
    }

    public function saveData($id, $data, $saveAll = false)
    {
        if ($saveAll) {
            return self::allowField(true)->isUpdate(true)->saveAll($data);
        }
        return self::allowField(true)->isUpdate(true)->save($data, ['id' => $id]);
    }


    public function fetchData($condition)
    {
        return self::get(function ($query) use ($condition) {
            if (!empty($condition['order_sn'])) $query->where(['order_sn' => $condition['order_sn']]);
            if (!empty($condition['id'])) $query->where(['id' => $condition['id']]);
        });
    }

    public function listData($condition = [], $page = 1, $pageSize = 10, $order = 'id desc')
    {
        return $this
            ->where(function ($query) use ($condition) {
                if (!empty($condition['order_sn'])) $query->where('order_sn', $condition['order_sn']);
                if (!empty($condition['order_modify_at'])) $query->where(['order_modify_at' => $condition['order_modify_at']]);
            })
            ->field(true)
            ->order($order)
            ->page($page, $pageSize)
            ->paginate($pageSize, false, ['page' => $page]);
    }

    public function listDataNoPage($condition = [], $limit = 10, $order = 'id desc')
    {
        return $this
            ->where(function ($query) use ($condition) {
                if (!empty($condition['order_sn'])) $query->where('order_sn', $condition['order_sn']);
                if (!empty($condition['order_modify_at'])) $query->where(['order_modify_at' => $condition['order_modify_at']]);
            })
            ->field(true)
            ->order($order)
            ->limit($limit)
            ->select();
    }

    public function setAddTimeAttr($val)
    {
        return is_string($val) ? strtotime($val) : $val;
    }

    public function setUpTimeAttr($val)
    {
        return is_string($val) ? strtotime($val) : $val;
    }
}