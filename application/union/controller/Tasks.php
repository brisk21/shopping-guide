<?php


namespace app\union\controller;


use app\common\common;
use think\Controller;
use think\Request;


class Tasks extends Controller
{
    private $conf = null;
    private $param = null;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->param = input();
        $this->init_config();

    }

    private function init_config()
    {
        $set = \cache('set_sys_union');
        if (!empty($set)) {
            $data = json_decode($set, true);
        } else {
            $set = common::data_detail(TABLE_CONFIG_SYS, ['key' => 'union']);
            if (!empty($set['value'])) {
                $data = json_decode($set['value'], true);
                \cache('set_sys_union', json_encode($data, JSON_UNESCAPED_UNICODE));
            }
        }
        if (!empty($data)) {
            $this->conf = $data;
        }
    }



    //亿起发订单同步到统计表
    public function syn_yiqifa2orders()
    {
        $stime = strtotime("- 10 minutes");

        $orders = common::get_data_list('plugin_guide_yqf_order', '*',
            ['uptime' => ['>', $stime]], '', 50);

        if (empty($orders)) {
            data_return('暂无订单', -1);
        }
        $time = time();

        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        foreach ($orders as $order) {
            $has = common::data_detail('plugin_guide_orders', ['order_sn' => $order['orderNo'], 'type' => 3], 'id,status');
            //亿起发业绩状态：R-未确认（确认状态为未确认或有效，且结算状态为未结算）；A-有效（确认状态为有效，且结算状态为已结算）；F-无效（确认状态为无效）
            $status = in_array($order['yiqifaState'], ['R', 'A']) ? 0 : -1;
            if (!empty($has)) {
                common::data_update('plugin_guide_orders', ['id' => $has['id']], [
                    'up_time' => $time,
                    'item_thumb' => '',
                    'item_title' => $order['skuName'],
                    'price' => $order['totalPrice'],
                    'commission_rate' => $order['totalPrice'] > 0 ? $order['commision'] / $order['totalPrice'] * 100 : 0,
                    'commission' => $order['commision'],
                    'status' => $has['status'] == 1 ? 1 : $status,//-1-已无效，0-待结算，1-已结算
                ]);
            } else {
                common::data_add('plugin_guide_orders', [
                    'type' => 3,
                    'item_thumb' => '',
                    'item_title' => $order['skuName'],
                    'add_time' => $time,
                    'up_time' => $time,
                    'akey' => $order['akey'],
                    'uid' => $order['uid'],
                    'order_sn' => $order['orderNo'],
                    'price' => $order['totalPrice'],
                    'commission_rate' => $order['totalPrice'] > 0 ? $order['commision'] / $order['totalPrice'] * 100 : 0,
                    'commission' => $order['commision'],
                    'status' => $status,//-1-已无效，0-待结算，1-已结算
                ]);
            }

        }
        data_return('ok', 0, ['count' => count($orders)]);
    }

    //小程序联盟订单同步到统计表
    public function syn_xcx2orders()
    {
        $stime = strtotime("- 10 minutes");

        $orders = common::get_data_list(TABLE_UNION_XCX_ORDER_GOODS, '*',
            ['upTime' => ['>', $stime]], '', 50);

        if (empty($orders)) {
            data_return('暂无订单', -1);
        }
        $time = time();

        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        foreach ($orders as $order) {
            $promotionInfo = @json_decode($order['promotionInfo'], true);
            $order['uid'] = '';
            if (!empty($promotionInfo['uid'])) {
                $order['uid'] = $promotionInfo['uid'];
            }

            $has = common::data_detail('plugin_guide_orders', ['order_sn' => $order['orderId'], 'type' => 2], 'id,status');
            //SETTLEMENT_PENDING-待结算 SETTLEMENT_SUCCESS-已结算 SETTLEMENT_CANCELED-取消结算
            $status = in_array($order['commissionStatus'], ['SETTLEMENT_PENDING', 'SETTLEMENT_SUCCESS']) ? 0 : -1;
            if (!empty($has)) {
                common::data_update('plugin_guide_orders', ['id' => $has['id']], [
                    'up_time' => $time,
                    'item_thumb' => $order['thumbImg'],
                    'item_title' => $order['title'],
                    'price' => floatval(str_replace('¥', '', $order['price'])),
                    'commission_rate' => $order['ratio'] / 100,//万分
                    'commission' => $order['estimatedCommission'] / 100,
                    'status' => $has['status'] == 1 ? 1 : $status,//-1-已无效，0-待结算，1-已结算
                ]);
            } else {
                common::data_add('plugin_guide_orders', [
                    'type' => 2,
                    'item_thumb' => $order['thumbImg'],
                    'item_title' => $order['title'],
                    'add_time' => $time,
                    'up_time' => $time,
                    'akey' => $order['akey'],
                    'uid' => $order['uid'],
                    'order_sn' => $order['orderId'],
                    'price' => floatval(str_replace('¥', '', $order['price'])),
                    'commission_rate' => $order['ratio'] / 100,
                    'commission' => $order['estimatedCommission'] / 100,
                    'status' => $status,//-1-已无效，0-待结算，1-已结算
                ]);
            }

        }
        data_return('ok', 0, ['count' => count($orders)]);
    }

    //美团联盟订单同步到统计表
    public function syn_meituan2orders()
    {
        $stime = strtotime("- 10 minutes");

        $orders = common::get_data_list('union_meituan_order', '*',
            ['up_time' => ['>', $stime]], '', 100);

        if (empty($orders)) {
            data_return('暂无订单', -1);
        }
        $time = time();

        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他,8-美团
        foreach ($orders as $order) {


            $has = common::data_detail('plugin_guide_orders', ['order_sn' => $order['orderid'], 'type' => 8], 'id,status');
            //1 已付款；8 已完成；9 已退款或风控
            $status = in_array($order['status'], ['1', '8']) ? 0 : -1;
            if (!empty($has)) {
                common::data_update('plugin_guide_orders', ['id' => $has['id']], [
                    'up_time' => $time,
                    'item_thumb' => '',
                    'item_title' => $order['smstitle'],
                    'price' => $order['direct'],
                    'commission_rate' => $order['ratio'],
                    'commission' => 0,
                    'status' => $has['status'] == 1 ? 1 : $status,//-1-已无效，0-待结算，1-已结算
                ]);
            } else {
                common::data_add('plugin_guide_orders', [
                    'type' => 8,
                    'item_thumb' => '',
                    'item_title' => $order['smstitle'],
                    'add_time' => $time,
                    'up_time' => $time,
                    'akey' => $order['akey'],
                    'uid' => $order['uid'],
                    'order_sn' => $order['orderid'],
                    'price' => $order['direct'],
                    'commission_rate' => $order['ratio'],
                    'commission' => 0,
                    'status' => $status,//-1-已无效，0-待结算，1-已结算
                ]);
            }

        }
        data_return('ok', 0, ['count' => count($orders)]);
    }

    //拼多多结算
    public function settlement_pdd()
    {
        $key = __FUNCTION__ . md5(__FUNCTION__ . __FILE__ . 'abcs');
        if (cache($key)) {
            data_return('有任务在执行', -1);
        }
        cache($key, 1, 600);
        //已结算订单
        $orders = common::get_data_list('plugin_guide_pdd_order', '*', ['order_status' => 5, 'is_jiesuan' => 0], 'id asc', 30);

        if (empty($orders->items())) {
            cache($key, null);
            data_return('暂无需结算订单', -1);
        }
        $time = time();

        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        foreach ($orders as $order) {
            $has = common::data_detail('plugin_guide_orders', ['order_sn' => $order['order_sn'], 'type' => 1], '*');

            if ($has) {
                $res = common::data_update('plugin_guide_orders', ['id' => $has['id']], [
                    'settlement_time' => $time,
                    'up_time' => $time,
                    'price' => $order['order_amount'] / 100,
                    'commission_rate' => $order['promotion_rate'] / 10,
                    'commission' => $order['promotion_amount'] / 100,
                    'status' => 1,//-1-已无效，0-待结算，1-已结算
                ]);
                if (!$res) {
                    common::add_log('结算err' . __FUNCTION__, $order['order_sn']);
                    continue;
                }
                common::data_update('plugin_guide_pdd_order', ['id' => $order['id']], ['is_jiesuan' => 1, 'jiesuan_time' => $time]);
                if (!empty($has['uid'])) {
                    $uid = $has['uid'];
                } elseif (!empty($order['custom_parameters'])) {
                    $custom_parameters = $order['custom_parameters'];
                    if (is_json($custom_parameters)) {
                        $json = json_decode($custom_parameters, true);
                        if (!empty($json['uid'])) {
                            $uid = $json['uid'];
                        }
                    } elseif (!empty($custom_parameters)) {
                        $user = CommonUserServer::get_wx_user($custom_parameters, 'uid', 'openid_gzh');
                        if (!empty($user['uid'])) {
                            $uid = $user['uid'];
                        }
                    }
                }
                if (!empty($uid)) {
                    $num = $order['promotion_amount'] / 100;
                    $point = 1;
                    BalanceServer::set($uid, 'credit', $num, ['remark' => '拼多多订单结算', 'label' => 'pdd_settlement']);
                    BalanceServer::set($uid, 'point', $point, ['remark' => '拼多多订单奖励', 'label' => 'pdd_settlement']);
                } else {
                    common::add_log('结算noUid' . __FUNCTION__, $order['order_sn']);
                }

            } else {
                common::add_log('结算noOrder' . __FUNCTION__, $order['order_sn']);
            }

        }
        cache($key, null);
        data_return('ok', 0, ['count' => count($orders)]);
    }

    //淘宝结算
    public function settlement_tb()
    {
        $key = __FUNCTION__ . md5(__FUNCTION__ . __FILE__ . 'abcs');
        if (cache($key)) {
            data_return('有任务在执行', -1);
        }
        cache($key, 1, 600);
        //已结算订单
        $orders = common::get_data_list('plugin_guide_tb_order', '*', ['tk_status' => 3, 'is_jiesuan' => 0], 'id asc', 30);

        if (empty($orders->items())) {
            cache($key, null);
            data_return('暂无需结算订单', -1);
        }
        $time = time();

        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        foreach ($orders as $order) {
            $has = common::data_detail('plugin_guide_orders', ['order_sn' => $order['trade_id'], 'type' => 4], '*');

            if ($has) {
                $res = common::data_update('plugin_guide_orders', ['id' => $has['id']], [
                    'settlement_time' => $time,
                    'up_time' => $time,
                    'price' => $order['alipay_total_price'],
                    'commission_rate' => $order['total_commission_rate'],
                    'commission' => $order['total_commission_fee'],
                    'status' => 1,//-1-已无效，0-待结算，1-已结算
                ]);
                if (!$res) {
                    common::add_log('结算err' . __FUNCTION__, $order['trade_id']);
                    continue;
                }
                common::data_update('plugin_guide_tb_order', ['id' => $order['id']], ['is_jiesuan' => 1, 'jiesuan_time' => $time]);
                if (!empty($has['uid'])) {
                    $uid = $has['uid'];
                } elseif (!empty($order['uid'])) {
                    $uid = $order['uid'];
                }
                if (!empty($uid)) {
                    $num = $order['total_commission_fee'];
                    $point = 1;
                    BalanceServer::set($uid, 'credit', $num, ['remark' => '淘宝订单结算', 'label' => 'tb_settlement']);
                    BalanceServer::set($uid, 'point', $point, ['remark' => '淘宝订单奖励', 'label' => 'tb_settlement']);
                } else {
                    common::add_log('结算noUid' . __FUNCTION__, $order['trade_id']);
                }

            } else {
                common::add_log('结算noOrder' . __FUNCTION__, $order['trade_id']);
            }

        }
        cache($key, null);
        data_return('ok', 0, ['count' => count($orders)]);
    }
}