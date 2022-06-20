<?php


namespace app\common\model;


class UnionTbOrder extends Base
{
    protected $createTime = 'add_time';
    protected $updateTime = 'up_time';
    protected $autoWriteTimestamp = true;

    protected $append = [
        'status_text'
    ];


    public function getStatusTextAttr($val, $data)
    {
        $status = [
            3 => '已结算',
            12 => '已付款',
            13 => '已失效',
            14 => '确认收货',
        ];
        return $status[$data['tk_status']];
    }

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
            if (!empty($condition['trade_id'])) $query->where(['trade_id' => $condition['trade_id']]);
            if (!empty($condition['order_sn'])) $query->where(['trade_id' => $condition['order_sn']]);
            if (!empty($condition['id'])) $query->where(['id' => $condition['id']]);
        });
    }

    public function listData($condition = [], $page = 1, $pageSize = 10, $order = 'id desc')
    {
        return $this
            ->where(function ($query) use ($condition) {
                if (!empty($condition['trade_id'])) $query->where('trade_id', $condition['trade_id']);
                if (!empty($condition['order_sn'])) $query->where('trade_id', $condition['order_sn']);
                if (!empty($condition['last_syn_time'])) $query->where(['last_syn_time' => $condition['last_syn_time']]);
                if (!empty($condition['modified_time'])) $query->where(['modified_time' => $condition['modified_time']]);
            })
            ->field(true)
            ->order($order)
            ->page($page, $pageSize)
            ->paginate($pageSize, false, ['page' => $page])
            ->each(function ($item) {
                $item['commission_rate'] = $item['tk_total_rate'];
                $item['commission'] = round($item['alipay_total_price'] * (round($item['tk_total_rate'] / 100, 2)), 2);
            });
    }

    public function listDataNoPage($condition = [], $limit = 10, $order = 'id desc')
    {
        return $this
            ->where(function ($query) use ($condition) {
                if (!empty($condition['trade_id'])) $query->where('trade_id', $condition['trade_id']);
                if (!empty($condition['order_sn'])) $query->where('trade_id', $condition['order_sn']);
                if (!empty($condition['last_syn_time'])) $query->where(['last_syn_time' => $condition['last_syn_time']]);
                if (!empty($condition['modified_time'])) $query->where(['modified_time' => $condition['modified_time']]);
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