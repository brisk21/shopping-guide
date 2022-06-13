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

    //大淘客订单
    function order_dtk()
    {
        if (!empty($this->param['stime'])) {
            $arg['startTime'] = $this->param['stime'];
        } else {
            $arg['startTime'] = date('Y-m-d H:i:s', strtotime("-3 hours"));
        }
        $akey = !empty($this->param['akey']) ? trim($this->param['akey']) : '';

        $arg['endTime'] = date('Y-m-d H:i:s', strtotime("+3 hours", strtotime($arg['startTime'])));
        if (!empty($this->param['orderScene'])) {
            //场景订单场景类型，1:常规订单，2:渠道订单，3:会员运营订单，默认为1
            $arg['orderScene'] = intval($this->param['orderScene']);
        }
        $res = $this->get_dtk_orders($arg);
        if (empty($res['results']['publisher_order_dto'])) {
            data_return('暂无订单', -1);
        }
        $orders = $res['results']['publisher_order_dto'];
        foreach ($orders as $order) {
            $has = common::data_detail('plugin_guide_tb_order', ['trade_id' => $order['trade_id']], 'id');
            $order['last_syn_time'] = time();
            if (!empty($has['id'])) {
                common::data_update_allow_field('plugin_guide_tb_order', ['id' => $has['id']], $order);
            } else {
                $order['uid'] = '';//fixme uid获取
                $order['akey'] = $akey;
                $order['add_time'] = time();
                common::data_add_allow_field('plugin_guide_tb_order', $order);
            }
        }
        data_return('ok', 0, ['count' => count($orders)]);
    }

    //查询订单
    private function get_dtk_orders($arg = [])
    {
        //https://openapi.dataoke.com/api/tb-service/get-privilege-link
        $client = new \GetOrderDetails();
        $client->setAppKey($this->conf['dtk_appkey']);
        $client->setAppSecret($this->conf['dtk_appsecret']);
        $client->setVersion('v1.0.0');
        $arg['pid'] = $this->conf['dtk_pid'];

        if (empty($arg['queryType'])) {
            $arg['queryType'] = 1;//查询时间类型，1：按照订单淘客创建时间查询，2:按照订单淘客付款时间查询，3:按照订单淘客结算时间查询，4：按照订单更新时间（5.27新增字段）

        }
        if (empty($arg['orderScene'])) {
            $arg['orderScene'] = 1;//场景订单场景类型，1:常规订单，2:渠道订单，3:会员运营订单，默认为1


        }

        if (empty($arg['startTime'])) {
            $arg['startTime'] = date('Y-m-d H:i:s', strtotime("-3 hours", time()));
        }
        if (empty($arg['endTime'])) {
            $arg['endTime'] = date('Y-m-d H:i:s');
        }
        $client->setParams($arg);

        $res = json_decode($client->setParams($arg)->request(true), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客抓单', $res);
            return [];
        }

        return $res['data'];
    }

    ////https://openapi.dataoke.com/api/tb-service/get-privilege-link
    //转链即将推广商品和您的标识（pid）进行绑定。推广形成订单后，即可获得佣金 （由于接口特殊性，请适量缓存已转链的链接，以达最佳效率）,仅限淘宝
    public function dtk_goods_link()
    {
        $arg = input();
        $client = new \GetPrivilegeLink();
        $client->setAppKey($this->conf['dtk_appkey']);
        $client->setAppSecret($this->conf['dtk_appsecret']);
        $client->setVersion('v1.3.1');
        $arg['pid'] = $this->conf['dtk_pid'];

        $arg['goodsId'] = $arg['goodsid'];
        if (!empty($arg['special_id'])) {
            $arg['specialId'] = $arg['special_id'];
        }
        if (!empty($arg['channel_id'])) {
            $arg['channelId'] = $arg['channel_id'];
        }
        //淘宝客外部用户标记，如自身系统账户ID；微信ID等
        if (!empty($arg['uid'])) {
            $arg['externalId'] = $arg['uid'];
        }

        $client->setParams($arg);

        $res = json_decode($client->setParams($arg)->request(), true);

        data_return($res, 0);
        if (!empty($res['code'])) {
            print_r($res);
            return [];
        }
        unset($res['data']['minCommissionRate'], $res['data']['maxCommissionRate']);
        return $res['data'];
    }

    //同步淘宝的到统计表
    public function syn_tb2orders()
    {
        $stime = strtotime("- 10 minutes");
        $orders = common::get_data_list('plugin_guide_tb_order', '*', ['last_syn_time' => ['>', $stime]], '', 50);

        if (empty($orders)) {
            data_return('暂无订单', -1);
        }
        $time = time();

        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        foreach ($orders->items() as $order) {
            $has = common::data_detail('plugin_guide_orders', ['order_sn' => $order['trade_id'], 'type' => 4], 'id,status');
            //3：订单结算，12：订单付款， 13：订单失效，14：订单成功
            $status = in_array($order['tk_status'], [3, 12, 14]) ? 0 : -1;
            if (!empty($has)) {
                common::data_update('plugin_guide_orders', ['id' => $has['id']], [
                    'up_time' => $time,
                    'item_thumb' => $order['item_img'],
                    'item_title' => $order['item_title'],
                    'price' => $order['alipay_total_price'],
                    'commission_rate' => $order['total_commission_rate'],
                    'commission' => $order['total_commission_fee'],
                    'status' => $has['status'] == 1 ? 1 : $status,//-1-已无效，0-待结算，1-已结算
                ]);
            } else {
                common::data_add('plugin_guide_orders', [
                    'type' => 4,
                    'item_thumb' => $order['item_img'],
                    'item_title' => $order['item_title'],
                    'add_time' => $time,
                    'up_time' => $time,
                    'akey' => $order['akey'],
                    'uid' => $order['uid'],
                    'order_sn' => $order['trade_id'],
                    'price' => $order['alipay_total_price'],
                    'commission_rate' => $order['total_commission_rate'],
                    'commission' => $order['total_commission_fee'],
                    'status' => $status,//-1-已无效，0-待结算，1-已结算
                ]);
            }

        }
        data_return('ok', 0, ['count' => count($orders)]);
    }

    //拼多多订单同步到统计表
    public function syn_pdd2orders()
    {
        $stime = strtotime("- 10 minutes");

        $orders = common::get_data_list('plugin_guide_pdd_order', '*', ['order_modify_at' => ['>', $stime]], '', 100);

        if (empty($orders)) {
            data_return('暂无订单', -1);
        }
        $time = time();

        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        foreach ($orders as $order) {
            $has = common::data_detail('plugin_guide_orders', ['order_sn' => $order['order_sn'], 'type' => 1], '*');
            //订单状态： -1 未支付; 0-已支付；1-已成团；2-确认收货；3-审核成功；4-审核失败（不可提现）；5-已经结算；8-非多多进宝商品（无佣金订单）
            $status = in_array($order['order_status'], [0, 1, 2, 3, 5]) ? 0 : -1;

            $custom_parameters = $order['custom_parameters'];
            if (is_json($custom_parameters)) {
                $json = json_decode($custom_parameters, true);
                if (!empty($json['uid'])) {
                    $order['uid'] = $json['uid'];
                }
            } elseif (!empty($custom_parameters)) {
                $user = CommonUserServer::get_wx_user($custom_parameters, 'uid', 'openid_gzh');
                if (!empty($user['uid'])) {
                    $order['uid'] = $user['uid'];
                }
            }


            if (!empty($has)) {
                common::data_update('plugin_guide_orders', ['id' => $has['id']], [
                    'up_time' => $time,
                    'uid' => !empty($has['uid']) ? $has['uid'] : $order['uid'],
                    'item_thumb' => $order['goods_thumbnail_url'],
                    'item_title' => $order['goods_name'],
                    'price' => $order['order_amount'] / 100,
                    'commission_rate' => $order['promotion_rate'] / 10,
                    'commission' => $order['promotion_amount'] / 100,
                    'status' => $has['status'] == 1 ? 1 : $status,//-1-已无效，0-待结算，1-已结算
                ]);
            } else {
                common::data_add('plugin_guide_orders', [
                    'type' => 1,
                    'item_thumb' => $order['goods_thumbnail_url'],
                    'item_title' => $order['goods_name'],
                    'add_time' => $time,
                    'up_time' => $time,
                    'akey' => $order['akey'],
                    'uid' => $order['uid'],
                    'order_sn' => $order['order_sn'],
                    'price' => $order['order_amount'] / 100,
                    'commission_rate' => $order['promotion_rate'] / 10,
                    'commission' => $order['promotion_amount'] / 100,
                    'status' => $status,//-1-已无效，0-待结算，1-已结算
                ]);
            }

        }
        data_return('ok', 0, ['count' => count($orders)]);
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