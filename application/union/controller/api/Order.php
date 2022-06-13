<?php


namespace app\union\controller\api;


use app\common\model\UnionOrders;
use think\Request;

class Order extends DgApiBase
{
    private $model;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = new UnionOrders();
    }

    //刷新订单，去重新拉取
    public function refresh()
    {
        $key = md5(__FILE__ . __FUNCTION__);
        if ($second = cache($key)) {
            data_return('操作过于频繁，' . ($second - time()) . '秒后可再次刷新', -1);
        }
        cache($key, time() + 30, 30);
        $res = (new \app\union\controller\crontab\Order())->syn_pdd(true);
        data_return('success', 0, [
            'status' => !empty($res['data']['orderCount'])
        ]);
    }

    public function del()
    {
        $orderSn = !empty($this->params['order_sn']) ? trim($this->params['order_sn']) : '';
        if (!$orderSn) {
            data_return('订单不存在', -1);
        }
        $data = $this->model->fetchData([
            'order_sn'=>$orderSn,
        ]);
        if (!$data['id']) {
            data_return('订单不存在', -1);
        }
        $this->model->destroy($data['id']);
        data_return('删除成功');
    }

    public function getList()
    {
        $where = [
            'uid'=>$this->uid
        ];
        //单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他，8-美团
        $type = !empty($this->params['type']) ? intval($this->params['type']) : '';
        $keyword = !empty($this->params['keyword']) ? trim($this->params['keyword']) : '';
        $page = !empty($this->params['offset']) ? intval($this->params['offset']) : 1;
        $pageSize = !empty($this->params['limit']) ? min(intval($this->params['limit']), 50) : 10;
        if ($keyword) {
            $where['order_sn'] = trim(strip_tags($keyword));
        }
        if ($type) {
            $where['type'] = intval($type);
        }

        $data = $this->model->listData($where, $page, $pageSize);
        data_return('success', 0, $data);
    }

    public function getDetail()
    {
        //单类型，1-拼多多，2-小程序，3-亿起发，4-淘宝，5-京东，6-唯品会，7-其他，8-美团
        $type = !empty($this->params['type']) ? intval($this->params['type']) : '';
        $order_sn = !empty($this->params['order_sn']) ? trim($this->params['order_sn']) : '';
        if (!$order_sn) {
            data_return('订单号不存在', -1);
        }
        $data = $this->model->fetchData(['order_sn'=>$order_sn,'uid'=>$this->uid,'type'=>$type]);
        data_return('success', 0, $data);
    }
}