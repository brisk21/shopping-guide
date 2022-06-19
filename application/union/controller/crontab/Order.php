<?php


namespace app\union\controller\crontab;


use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\AddShortUrlResponseBody\data;
use app\common\common;
use app\common\controller\AppCommon;
use app\common\model\CommonUserTbauth;
use app\common\model\UnionOrders;
use app\common\model\UnionPddOrder;
use app\common\model\UnionTbOrder;
use app\server\GuideDtkServer;
use app\server\GuidePddServer;
use think\Log;
use think\Request;

class Order extends Base
{
    private $pdd;
    private $dtk;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->pdd = new GuidePddServer();
        $this->dtk = new GuideDtkServer();
    }

    //手动同步
    public function handle_syn()
    {
        $this->syn_pdd(true);
        $this->syn_tb(true);
        Log::write(\request()->param(),'contab/order/handle_syn');
        data_return('success',0);
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
                $has = $model->fetchData(['order_sn' => $item['order_sn']]);
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
            if ($arrInsert || $arrUp) {
                $this->syn_pdd2orders(true);
            }
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
        $type = 1;
        foreach ($orders as $order) {
            $has = $orderModel->fetchData(['order_sn' => $order['order_sn'],'type'=>$type]);
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
                    'type' => $type,
                    'item_thumb' => $order['goods_thumbnail_url'],
                    'item_title' => $order['goods_name'],
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

    //大淘客订单
    function syn_tb($syn = false)
    {
        $this->syn_tb2orders(true);
        if (!empty($this->params['stime'])) {
            $arg['startTime'] = $this->params['stime'];
        } else {
            $arg['startTime'] = date('Y-m-d H:i:s', strtotime("-3 hours"));
        }
        $etime = strtotime("+3 hours", strtotime($arg['startTime']));
        $arg['endTime'] = date('Y-m-d H:i:s', $etime > time() ? time() : $etime);

        if (!empty($this->params['orderScene'])) {
            //场景订单场景类型，1:常规订单，2:渠道订单，3:会员运营订单，默认为1
            $arg['orderScene'] = intval($this->params['orderScene']);
        }
        $res = $this->dtk->tb_orders($arg);
        if (empty($res['results']['publisher_order_dto'])) {
            return data_return('暂无订单', -1, '', !$syn);
        }
        $orders = $res['results']['publisher_order_dto'];
        $arrUp = $arrInsert = [];
        $model = new UnionTbOrder();
        foreach ($orders as $item) {
            $has = $model->fetchData(['order_sn' => $item['trade_id']]);
            if (!empty($has['id'])) {
                $item['id'] = $has['id'];
                $arrUp[] = $item;
            } else {
                if (!empty($item['relation_id'])) {
                    $uid = (new CommonUserTbauth())->getValue(['relation_id' => $item['relation_id']], 'uid');
                    if ($uid) $item['uid'] = $uid;
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
        if ($arrInsert || $arrUp) {
            $this->syn_tb2orders(true);
        }

        return data_return('ok', 0, ['count' => count($orders),'countUp'=>count($arrUp),'countNew'=>count($arrInsert)], !$syn);
    }

    //同步淘宝的到统计表
    public function syn_tb2orders($syn = false)
    {
        $stime = !empty($this->params['mtime'])?trim($this->params['mtime']):date('Y-m-d H:i:s',strtotime("-30 minutes"));
        $orders = (new UnionTbOrder())
            ->listData(['modified_time' => ['>', $stime]], 1, 50, 'id asc')
            ->toArray();

        if (empty($orders)) {
            return data_return('暂无订单', -1, '', $syn);
        }

        $orders = $orders['data'] ? $orders['data'] : [];

        $orderModel = new UnionOrders();
        //订单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他
        $arrUp = $arrInsert = [];
        $type = 4;
        foreach ($orders as $order) {
            $has = $orderModel->fetchData(['order_sn' => $order['trade_id'],'type'=>$type]);
            //已付款：指订单已付款，但还未确认收货 已收货：指订单已确认收货，但商家佣金未支付 已结算：指订单已确认收货，且商家佣金已支付成功 已失效：指订单关闭/订单佣金小于0.01元，订单关闭主要有：1）买家超时未付款； 2）买家付款前，买家/卖家取消了订单；3）订单付款后发起售中退款成功；3：订单结算，12：订单付款， 13：订单失效，14：订单成功
            $status = in_array($order['tk_status'], [12]) ? -1 : 0;
            if (empty($order['uid']) && !empty($order['relation_id'])) {
                $uid = (new CommonUserTbauth())->getValue(['relation_id' => $order['relation_id']], 'uid');
                if ($uid) $order['uid'] = $uid;
            }

            if (!empty($has['id'])) {
                $arrUp[] = [
                    'id' => $has['id'],
                    'uid' => !empty($has['uid']) ? $has['uid'] : $order['uid'],
                    'item_thumb' => $order['item_img'],
                    'item_title' => $order['item_title'],
                    'price' => $order['alipay_total_price'],
                    'commission_rate' => $order['total_commission_fee'],
                    'commission' => $order['pub_share_fee'],
                    'status' => $has['status'] == 1 ? 1 : $status,//-1-已无效，0-待结算，1-已结算
                ];

            } else {
                $arrInsert[] = [
                    'type' => $type,
                    'akey' => $order['akey'],
                    'uid' => $order['uid'],
                    'order_sn' => $order['trade_id'],
                    'item_thumb' => $order['item_img'],
                    'item_title' => $order['item_title'],
                    'price' => $order['alipay_total_price'],
                    'commission_rate' => $order['total_commission_fee'],
                    'commission' => $order['pub_share_fee'],
                    'status' => $has['status'] == 1 ? 1 : $status,//-1-已无效，0-待结算，1-已结算
                ];
            }
        }
        if ($arrInsert) {
            $orderModel->addData($arrInsert, true);
        }
        if ($arrUp) {
            $orderModel->saveData(false, $arrUp, true);
        }

        return data_return('ok', 0, ['count' => count($orders),'countUp'=>count($arrUp),'countNew'=>count($arrInsert)], !$syn);
    }


}