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