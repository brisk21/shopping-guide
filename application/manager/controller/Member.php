<?php


namespace app\manager\controller;


use app\common\model\CommonUser;
use think\Request;

class Member extends Base
{
    protected $model;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = new CommonUser();
    }

    public function list_data()
    {
        $page = request()->post('page',1);
        $pageSize = request()->post('pageSize',20);
        $where = request()->only('union_code,account,nickname');

        $data = $this->model->listData($where,$page,$pageSize);
        data_return('success',0,$data);
    }

    public function save_data(Request $request)
    {
        if (!$request->isPut()){
            data_return('非法操作',-1);
        }
        $param = $request->only('status,id,uid,nickname');
        if (empty($param['id'])){
            data_return('参数有误');
        }
        $data = $this->model->fetchData(['id'=>$param['id']]);
        if (empty($data)){
            data_return('用户不存在',-1);
        }
        $res = $data->saveData($data['id'],['status'=>intval($param['status'])]);
        data_return('操作成功',0,$res);
    }

    public function get_data(Request $request)
    {
        $id = $request->get('id',0,'intval');
        $data = $this->model->fetchData(['id'=>$id]);

        data_return('success',0,$data);
    }
}