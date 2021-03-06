<?php


namespace app\manager\controller;


use app\common\model\UnionOrders;
use app\common\model\UnionPddOrder;
use app\common\model\UnionTbOrder;

class Order extends Base
{
    //归集订单
    public function union_list()
    {
        $page = request()->post('page',1);
        $pageSize = request()->post('pageSize',20);
        $keyword = request()->post('keyword','');
        $where = [];
        if ($keyword){
            $where['order_sn'] = $keyword;
        }
        $data = (new UnionOrders())->listData($where,$page,$pageSize);
        data_return('success',0,$data);
    }

    public function pdd_list()
    {
        $page = request()->post('page',1);
        $pageSize = request()->post('pageSize',20);
        $keyword = request()->post('keyword','');
        $where = [];
        if ($keyword){
            $where['order_sn'] = $keyword;
        }
        $data = (new UnionPddOrder())->listData($where,$page,$pageSize);
        data_return('success',0,$data);
    }

    public function tb_list()
    {
        $page = request()->post('page',1);
        $pageSize = request()->post('pageSize',20);
        $keyword = request()->post('keyword','');
        $where = [];
        if ($keyword){
            $where['order_sn'] = $keyword;
        }
        $data = (new UnionTbOrder())->listData($where,$page,$pageSize);
        data_return('success',0,$data);
    }
}