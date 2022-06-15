<?php


namespace app\admin\controller\order;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\common\model\UnionOrders;
use app\service\Msg;
use app\service\Order;
use app\service\Order as ServerOrder;
use app\service\Page;
use think\Request;

class Index extends Admin
{
    private $model;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = new UnionOrders();
    }

    public function index()
    {
        $where = [];
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;

        $status = isset($this->param['status']) && is_numeric($this->param['status']) ? intval($this->param['status']) : '';
        $orderType = isset($this->param['orderType']) && is_numeric($this->param['orderType']) ? intval($this->param['orderType']) : '';

        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';
        $timeSet = !empty($this->param['time']) ? explode(' 至 ', $this->param['time']) : '';
        $orderBy = 'id desc';


        if ($status !== '') {
            $where['status'] = $status;
        }

        if (is_numeric($orderType)) {
            $where['type'] = $orderType;
        }
        if (!empty($keyword)) {
            $where['order_sn'] = $keyword;
        }

        if (!empty($timeSet[1])) {
            $where['add_time'] = ['between', [strtotime($timeSet[0] . ' 00:00:00'), strtotime($timeSet[1] . ' 23:59:59')]];
        }

        $data = $this->model->listData($where,$page,$pageSize,$orderBy);
        $this->assign('options',config('param.union_orders'));
        $this->assign('data', $data);
        return $this->fetch();
    }

}