<?php


namespace app\union\controller\crontab;


use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\AddShortUrlResponseBody\data;
use app\common\controller\AppCommon;
use app\common\model\UnionOrders;
use app\common\model\UnionPddOrder;
use app\server\GuidePddServer;
use think\Request;

class Order extends Base
{
    private $pdd;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->pdd = new GuidePddServer();
    }

    //抓单拼多多
    public function syn_pdd($syn = false)
    {
        $arg = [
            'minute' => !empty($this->params['minute']) ? intval($this->params['minute']) : 30,
        ];
        $req = $this->pdd->syn_order2($arg);
        if (!empty($req['code'])) {
            return data_return($req['msg'], $req['code'], [], !$syn);
        }
        $model = new UnionPddOrder();
        if (!empty($req['data'])) {
            $arrUp = $arrInsert = [];
            foreach ($req['data'] as $item) {
                $has = $model->fetchData(['order_sn'=>$item['order_sn']]);
                if (!empty($has['id'])) {
                    $item['id'] = $has['id'];
                    $arrUp[] = $item;
                } else {
                    if (!empty($item['custom_parameters'])) {
                        $info = json_decode($item['custom_parameters'], true);
                        if (!empty($info['bid']) && $uid = $this->get_uid($info['bid'])) $item['uid'] = $uid;
                    }
                    $arrInsert[] = $item;
                }
            }
            if ($arrInsert) {
                $model->addData($arrInsert, true);
            }
            if ($arrUp) {
                $model->saveData(false, $arrUp, true);
            }
            $this->syn_pdd2orders(true);
        }
        return data_return('跟单完成', 0, [
            'orderCount' => count($req['data']),
        ], !$syn);
    }

    //拼多多订单同步到统计表
    public function syn_pdd2orders($syn = false)
    {
        $minutes = !empty($this->params['minutes']) ? intval($this->params['minutes']) : 20;
        $stime = strtotime("-$minutes minutes");
        $model = new UnionPddOrder();
        $orders = $model->listDataNoPage([
            'order_modify_at' => ['between', [$stime, time()]]
        ], 500);

        if (empty($orders)) {
            data_return('暂无订单', -1, [], !$syn);
        }

        $time = time();
        $orderModel = new UnionOrders();
        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        $arrUp = $arrInsert = [];
        foreach ($orders as $order) {
            $has = $orderModel->fetchData(['order_sn' => $order['order_sn']]);
            //订单状态： -1 未支付; 0-已支付；1-已成团；2-确认收货；3-审核成功；4-审核失败（不可提现）；5-已经结算；8-非多多进宝商品（无佣金订单）
            $status = in_array($order['order_status'], [0, 1, 2, 3, 5]) ? 0 : -1;
            if (empty($order['uid']) && !empty($order['custom_parameters'])) {
                $json = @json_decode($order['custom_parameters'], true);
                if (!empty($json['uid'])) {
                    $order['uid'] = $json['uid'];
                }
            }

            if (!empty($has['id'])) {
                $arrUp[] = [
                    'id' => $has['id'],
                    'up_time' => $time,
                    'uid' => !empty($has['uid']) ? $has['uid'] : $order['uid'],
                    'item_thumb' => $order['goods_thumbnail_url'],
                    'item_title' => $order['goods_name'],
                    'price' => $order['order_amount'] / 100,
                    'commission_rate' => $order['promotion_rate'] / 10,
                    'commission' => $order['promotion_amount'] / 100,
                    'status' => $has['status'] == 1 ? 1 : $status,//-1-已无效，0-待结算，1-已结算
                ];

            } else {
                $arrInsert[] = [
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
                ];
            }
        }
        if ($arrInsert) {
            $orderModel->addData($arrInsert, true);
        }
        if ($arrUp) {
            $orderModel->saveData(false, $arrUp, true);
        }
        data_return('ok', 0, ['count' => count($orders)], !$syn);
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


}