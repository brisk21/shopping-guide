<?php


namespace app\union\controller\crontab;


use app\common\common;
use app\common\model\UnionOrders;
use app\common\model\UnionPddOrder;
use app\common\model\UnionTbOrder;
use app\service\Credits;
use think\Cache;

class Settlement extends Base
{
    //拼多多结算
    public function pdd()
    {
        $key = __FUNCTION__ . md5(__FUNCTION__ . __FILE__ . 'ab2cs');
        if (cache($key)) {
            data_return('有任务在执行', -1);
        }

        cache($key, 1, 600);
        $modelPdd = new UnionPddOrder();
        //已结算订单
        $orders = $modelPdd->listData(['order_status' => 5, 'is_jiesuan' => 0], 1, 100, 'id asc');

        if (empty($orders->total())) {
            cache($key, null);
            data_return('暂无需结算订单', -1);
        }
        $time = time();
        $modelOrders = new UnionOrders();
        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        $arrPddUp = $arrOrderUp = [];
        foreach ($orders as $order) {
            $data = $modelOrders->fetchData(['order_sn' => $order['order_sn'], 'type' => 1]);
            if ($data) {
                $res = $data->isUpdate(true)->save([
                    'settlement_time' => $time,
                    'up_time' => $time,
                    'price' => $order['order_amount'],
                    'commission_rate' => $order['commission_rate'],
                    'commission' => $order['commission'],
                    'status' => 1,//-1-已无效，0-待结算，1-已结算
                ], ['id' => $data['id']]);

                if (!$res) {
                    common::add_log('结算err' . __FUNCTION__, $order['order_sn']);
                    continue;
                }
                $arrPddUp [] = [
                    'id' => $order['id'],
                    'is_jiesuan' => 1,
                    'jiesuan_time' => $time
                ];
                if (!empty($data['uid'])) {
                    $uid = $data['uid'];
                } elseif (!empty($order['uid'])) {
                    $uid = $order['uid'];
                }
                if (!empty($uid)) {
                    $num = $order['commission'];
                    //todo 后台配置
                    $point = 1;
                    //2-收入，1-支出
                    Credits::set($uid, 'credit', $num, ['remark' => '拼多多订单结算', 'type' => 2]);
                    if ($point) {
                        Credits::set($uid, 'point', $point, ['remark' => '拼多多订单奖励', 'type' => 2]);
                    }
                } else {
                    common::add_log('结算noUid' . __FUNCTION__, $order['order_sn']);
                }

            } else {
                common::add_log('结算noOrder' . __FUNCTION__, $order['order_sn']);
            }

        }
        if (!empty($arrPddUp)) {
            $modelPdd->saveData(false, $arrPddUp, true);
        }
        cache($key, null);
        data_return('ok', 0, ['count' => $orders->total(), 'up' => count($arrPddUp)]);
    }

    //淘宝结算
    public function tb()
    {
        $key = __FUNCTION__ . md5(__FUNCTION__ . __FILE__ . 'abc3s');
        if (cache($key)) {
            data_return('有任务在执行', -1);
        }
        cache($key, 1, 600);
        $modelTb = new UnionTbOrder();
        //已结算订单
        $orders = $modelTb->listData(['tk_status' => 3, 'is_jiesuan' => 0], 1, 100, 'id asc');

        if (empty($orders->total())) {
            cache($key, null);
            data_return('暂无需结算订单', -1);
        }
        $time = time();
        $modelOrders = new UnionOrders();

        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        $arrUp = [];
        foreach ($orders as $order) {
            $data = $modelOrders->fetchData(['order_sn' => $order['trade_id'], 'type' => 4]);

            if ($data) {
                $res = $data->isUpdate(true)->save([
                    'settlement_time' => $time,
                    'up_time' => $time,
                    'price' => $order['alipay_total_price'],
                    'commission_rate' => $order['commission_rate'],
                    'commission' => $order['commission'],
                    'status' => 1,//-1-已无效，0-待结算，1-已结算
                ], ['id' => $data['id']]);
                if (!$res) {
                    common::add_log('结算err' . __FUNCTION__, $order['trade_id']);
                    continue;
                }
                $arrUp[] = [
                    'id' => $order['id'],
                    'is_jiesuan' => 1,
                    'jiesuan_time' => $time
                ];
                if (!empty($data['uid'])) {
                    $uid = $data['uid'];
                } elseif (!empty($order['uid'])) {
                    $uid = $order['uid'];
                }
                if (!empty($uid)) {
                    $num = $order['commission'];
                    //todo 后台配置
                    $point = 1;
                    //2-收入，1-支出
                    Credits::set($order['uid'], 'credit', $num, ['remark' => '淘宝订单结算', 'type' => 2]);
                    if ($point) {
                        Credits::set($order['uid'], 'point', $point, ['remark' => '淘宝订单奖励', 'type' => 2]);
                    }
                } else {
                    common::add_log('结算noUid' . __FUNCTION__, $order['trade_id']);
                }

            } else {
                common::add_log('结算noOrder' . __FUNCTION__, $order['trade_id']);
            }
        }
        if (!empty($arrUp)) {
            $modelTb->saveData(false, $arrUp, true);
        }
        cache($key, null);
        data_return('ok', 0, ['count' => $orders->total(), 'up' => count($arrUp)]);
    }
}