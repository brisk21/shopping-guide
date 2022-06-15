<?php


namespace app\common\model;


use think\Log;
use traits\model\SoftDelete;

class UnionOrders extends Base
{
    use SoftDelete;
    protected $createTime = 'add_time';
    protected $updateTime = 'up_time';
    protected $deleteTime = 'del_time';
    protected $autoWriteTimestamp = true;

    protected $append = ['status_text','type_text'];

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
            if (!empty($condition['order_sn'])) $query->where(['order_sn' => $condition['order_sn']]);
            if (!empty($condition['id'])) $query->where(['id' => $condition['id']]);
            if (!empty($condition['type'])) $query->where(['type' => $condition['type']]);
        });
    }

    public function listData($condition = [], $page = 1, $pageSize = 10, $order = 'id desc')
    {
        return $this
            ->where(function ($query) use ($condition) {
                if (!empty($condition['uid'])) $query->where(['uid' => $condition['uid']]);
                if (!empty($condition['order_sn'])) $query->where(['order_sn' => $condition['order_sn']]);
                if (!empty($condition['type'])) $query->where(['type' => $condition['type']]);
                if (isset($condition['status'])) $query->where(['status' => $condition['status']]);
                if (!empty($condition['order_modify_at'])) $query->where(['order_modify_at' => $condition['order_modify_at']]);
            })
            ->field(true)
            ->order($order)
            ->page($page, $pageSize)
            ->paginate($pageSize, false, ['page' => $page]);

    }

    public function getTypeTextAttr($value, $data)
    {
        return config('param.union_orders')['type'][$data['type']];
    }

    public function getStatusTextAttr($value, $data)
    {
        Log::write([$value,$data],'cccccccc');
        return config('param.union_orders')['status'][$data['status']];
    }


    public function setAddTimeAttr($val)
    {
        return is_string($val) ? strtotime($val) : $val;
    }

    public function setUpTimeAttr($val)
    {
        return is_string($val) ? strtotime($val) : $val;
    }

    public function getSettlementTimeAttr($val,$data)
    {
        if (!$data['settlement_time']) return $val;
        return !is_string($val) ? date('Y-m-d H:i:s', $val) : $val;
    }
}