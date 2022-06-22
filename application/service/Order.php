<?php


namespace app\service;


use app\common\controller\AppCommon;

class Order
{
    //创建订单
    public static function add($arg)
    {
        $order_sn = 'BS' . date('YmdHis') . get_random(8, 1);
        while (true) {
            $has = AppCommon::data_get('order', ['order_sn' => $order_sn], 'id');
            if (empty($has['id'])) {
                break;
            }
            $order_sn = 'BS' . date('YmdHis') . get_random(8, 1);
        }

        $data = [
            'uid' => $arg['uid'],
            'store_num' => !empty($arg['store_num']) ? $arg['store_num'] : '',
            'address' => !empty($arg['address']) ? (!is_array($arg['address'])?$arg['address']: json_encode($arg['address'], JSON_UNESCAPED_UNICODE) ): '',
            'is_parent' => !empty($arg['is_parent']) ? 1 : 0,
            'is_del' => !empty($arg['is_del']) ? 1 : 0,
            'order_sn' => $order_sn,
            'status' => isset($arg['status']) ? $arg['status'] : 0,
            'price' => $arg['price'],
            'ip_address' => get_ip(),
            'order_type' => !empty($arg['order_type']) ? $arg['order_type'] : 0,
            'tihuo_address' => !empty($arg['tihuo_address']) ? $arg['tihuo_address'] : '',
            'parent_sn' => !empty($arg['parent_sn']) ? $arg['parent_sn'] : '',
            'add_time' => time(),
            'up_time' => time(),
            'cancel_pay_time' => time() + 3600,//x秒后不可支付

            'pay_price' => isset($arg['pay_price']) ? $arg['pay_price'] : 0,
            'pay_time' => isset($arg['pay_time']) ? $arg['pay_time'] : 0,
            'pay_type' => isset($arg['pay_type']) ? $arg['pay_type'] : 0,
        ];

        $res = AppCommon::data_add('order', $data);
        if (!$res) {
            return ['code' => -1, 'msg' => '创建失败'];
        }
        return ['code' => 0, 'msg' => 'ok', 'data' => ['order_sn' => $order_sn]];
    }

    //创建充值订单
    public static function recharge_create($arg)
    {
        $order_sn = 'BS' . date('YmdHis') . get_random(8, 1);
        while (true) {
            $has = AppCommon::data_get('order_recharge', ['order_sn' => $order_sn], 'id');
            if (empty($has['id'])) {
                break;
            }
            $order_sn = 'BS' . date('YmdHis') . get_random(8, 1);
        }

        $data = [
            'uid' => $arg['uid'],
            'order_sn' => $order_sn,
            'status' => 0,
            'price' => $arg['price'],
            'add_time' => time(),
            'up_time' => time(),
            'pay_type' => $arg['pay_type'],
            'cancel_pay_time' => time() + 3600,//x秒后不可支付
        ];

        $res = AppCommon::data_add('order_recharge', $data);
        if (!$res) {
            return ['code' => -1, 'msg' => '创建失败'];
        }
        return ['code' => 0, 'msg' => 'ok', 'data' => ['order_sn' => $order_sn]];
    }


    //更新订单
    public static function update($order_sn, $data)
    {
        if (!self::get($order_sn, 'id')) {
            return false;
        }
        return AppCommon::data_update('order', ['order_sn' => $order_sn], $data);
    }

    //查询订单
    public static function get($order_sn, $field = '*')
    {
        return AppCommon::data_get('order', ['order_sn' => trim($order_sn)], $field);
    }

    //删除订单:①未支付直接删除，②已付款的直接修改状态
    public static function del($order_sn)
    {
        $order = self::get($order_sn, 'status,order_sn,uid');
        if (empty($order)) {
            return false;
        }
        if ($order['status'] == 0) {
            AppCommon::data_del('order', ['order_sn' => $order_sn]);
            //锁库解锁
            self::free_goods($order_sn);
        } else {
            AppCommon::data_update('order', ['order_sn' => $order_sn], ['is_del' => 1]);
        }

        return true;
    }

    //关闭订单
    public static function cancel($order_sn)
    {
        $order = self::get($order_sn, 'status,order_sn,uid');
        if (empty($order)) {
            return false;
        }
        if ($order['status'] <> 0) {
            return false;
        }
        $res = self::update($order_sn, ['status' => -1, 'up_time' => time()]);
        if (!$res) {
            return false;
        }
        self::free_goods($order_sn);

        return true;
    }

    //释放商品
    private static function free_goods($order_sn)
    {
        //锁库解锁
        $allGoods = AppCommon::data_list('order_goods', ['order_sn' => $order_sn], '1,50', 'goods_id,count');

        if ($allGoods) {
            foreach ($allGoods as $goods) {
                AppCommon::db('goods')->where(['id' => $goods['goods_id']])->setInc('stock', $goods['count']);
                AppCommon::db('goods')->where(['id' => $goods['goods_id']])->setDec('stock_locked', $goods['count']);
            }
        }
    }

    //订单商品
    public static function add_order_goods($data)
    {
        return AppCommon::data_add('order_goods', $data);
    }

    /**
     * 操作退款
     * @param $order_sn
     * @param $money
     */
    public static function refund($order_sn, $money)
    {
        $order = self::get($order_sn);
        if (empty($order)) {
            return ['code' => -1, 'msg' => '订单未找到'];
        }
        if ($order['refund_total'] >= $order['pay_price']) {
            return ['code' => -1, 'msg' => '累计退款金额已经最大'];
        } elseif ($order['pay_price'] - $order['refund_total'] < $money) {
            return ['code' => -1, 'msg' => '累计退款金额超过实付'];
        }
        //wechat-微信，alipay-支付宝，credit-余额
        $payType = $order['pay_type'];
        if ($payType == 'credit') {
            $res = Credits::update($order['uid'], 'credit', $money, [
                'remark' => '订单退款',
                'type' => 2,//类型：2-收入，1-支出
            ]);
            if (!$res) {
                return ['code' => -1, 'msg' => '退款失败'];
            }

            self::update($order_sn, [
                'up_time' => time(),
                'refund_total' => $order['refund_total'] + $money,
                'status' => -2
            ]);
            return ['code' => 0, 'msg' => '退款完成'];
        } elseif ($payType == 'wechat') {
            $res = Pay::refund_wechat($order_sn, $money);
            if ($res['code'] <> 0) {
                return $res;
            }
            self::update($order_sn, [
                'up_time' => time(),
                'refund_total' => $order['refund_total'] + $money,
                'status' => -2
            ]);
            return ['code' => 0, 'msg' => '退款完成'];
        } else {
            return ['code' => -1, 'msg' => '暂不支持的支付方式'];
        }

    }
}