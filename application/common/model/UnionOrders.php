<?php


namespace app\common\model;


use think\Log;
use traits\model\SoftDelete;

class UnionOrders extends Base
{
    protected $createTime = 'add_time';
    protected $updateTime = 'up_time';
    protected $autoWriteTimestamp = true;
    use SoftDelete;

    protected $deleteTime = 'del_time';


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
        })->append(['status_text']);
    }

    public function listData($condition = [], $page = 1, $pageSize = 10, $order = 'id desc')
    {
        return $this
            ->where(function ($query) use ($condition) {
                if (!empty($condition['uid'])) $query->where(['uid' => $condition['uid']]);
                if (!empty($condition['order_sn'])) $query->where(['order_sn' => $condition['order_sn']]);
                if (!empty($condition['type'])) $query->where(['order_sn' => $condition['type']]);
                if (isset($condition['is_del'])) $query->where(['is_del' => $condition['is_del']]);
                if (!empty($condition['order_modify_at'])) $query->where(['order_modify_at' => $condition['order_modify_at']]);
            })
            ->field(true)
            ->order($order)
            ->page($page, $pageSize)
            ->paginate($pageSize, false, ['page' => $page])
           ->each(function ($v) {
                $v['status_text'] = $this->getStatusTextAttr($v['status'], $v);
            });
    }

    public function getStatusTextAttr($value, $data)
    {
        $arr = [
            -1 => '已无效', 0 => '待结算', 1 => '已结算'
        ];
        return $arr[$data['status']];
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

    public function getSettlementTimeAttr($val)
    {
        return !is_string($val) ? date('Y-m-d H:i:s', $val) : $val;
    }
}