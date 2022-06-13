<?php


namespace app\admin\controller\user;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\service\CommonUser;
use app\service\Credits;
use app\service\Page;

class Index extends Admin
{
    public function index()
    {
        $where = [];
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;

        $status = isset($this->param['status']) && is_numeric($this->param['status']) ? intval($this->param['status']) : '';

        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';
        $timeSet = !empty($this->param['time']) ? explode(' 至 ', $this->param['time']) : '';

        $orderBy = 'id desc';


        if ($status !== '') {
            $where['status'] = $status;
        }
        if (!empty($timeSet[1])) {
            $where['add_time'] = ['between', [strtotime($timeSet[0] . ' 00:00:00'), strtotime($timeSet[1] . ' 23:59:59')]];
        }
        if (!empty($keyword)) {
            if (mb_strlen($keyword) == 34 && stripos($keyword, 'bs') === 0) {
                $where['uid'] = $keyword;
            } else {
                $where['account'] = ['like', '%' . $keyword . '%'];
            }

        }


        $status = [
            '0' => '<span class="bs-green">正常</span>',
            '1' => '<span class="bs-red">封号中</span>',
        ];
        $data = AppCommon::data_list('common_user', $where, $page . ',' . $pageSize, '*', $orderBy);

        if (!empty($data)) {
            foreach ($data as &$v) {
                $v['up_time'] = date('Y-m-d H:i:s', $v['up_time']);
                $v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                $v['statusDesc'] = $status[$v['status']];
                $v['balance'] = AppCommon::data_get('common_user_credits', ['uid' => $v['uid']]);
            }
        }

        $total = AppCommon::data_count('common_user', $where);

        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function form()
    {
        if (!empty($this->param['uid'])) {
            $data = CommonUser::get($this->param['uid'], '*');
            $this->assign('data', $data);
        }

        return $this->fetch();
    }

    //编辑信息
    public function edit_user()
    {
        if (empty($this->param['uid'])) {
            data_return('用户参数有误', -1);
        }
        $data = CommonUser::get($this->param['uid'], 'id,uid,status');
        if (empty($data['uid'])) {
            data_return('记录不存在', -1);
        }
        $upData = [
            'remark' => trim(strip_tags($this->param['remark'])),
            'up_time' => time(),
            'status' => !empty($this->param['status']) ? 1 : 0,
            'account' => trim($this->param['account'])
        ];
        if (!empty($this->param['pwd'])) {
            $salt = get_random(10, false);
            $upData['salt'] = $salt;
            $upData['pwd'] = md5($this->param['pwd'] . $salt);
        }
        CommonUser::update($data['uid'], $upData);
        parent::add_admin_log(['title' => '编辑会员', 'content' => $upData]);
        data_return('修改成功');
    }

    //添加备注
    public function action_remark()
    {
        if (empty($this->param['uid'])) {
            data_return('用户参数有误', -1);
        }
        $data = CommonUser::get($this->param['uid'], 'id,uid,status');
        if (empty($data['uid'])) {
            data_return('记录不存在', -1);
        }
        CommonUser::update($data['uid'], [
            'up_time' => time(),
            'remark' => trim(strip_tags($this->param['remark']))
        ]);
        data_return('设置成功');
    }

    //设置状态
    public function action_status()
    {
        if (empty($this->param['uid'])) {
            data_return('用户参数有误', -1);
        }
        $data = CommonUser::get($this->param['uid'], 'id,uid,status');
        if (empty($data['uid'])) {
            data_return('记录不存在', -1);
        }
        $res = CommonUser::update($data['uid'], [
            'up_time' => time(),
            'status' => $data['status'] == 1 ? 0 : 1
        ]);
        if ($res) {
            parent::add_admin_log(['title' => '修改会员状态为：' . ($data['status'] == 1 ? '解封' : '封号'), 'content' => $data]);
        }

        data_return('设置成功');
    }

    //充值余额
    public function action_recharge()
    {
        if (empty($this->param['uid'])) {
            data_return('用户参数有误', -1);
        }
        //可以是负数
        if (empty($this->param['credit_num'])) {
            data_return('请填写充值数量', -1);
        }
        if (empty($this->param['remark'])) {
            data_return('请填写备注', -1);
        }
        $num = floatval($this->param['credit_num']);
        $data = CommonUser::get($this->param['uid'], 'id,uid,status');
        if (empty($data['uid'])) {
            data_return('记录不存在', -1);
        }
        $res = Credits::update($data['uid'], 'credit', $num, [
            'remark' => '后台操作-' . trim($this->param['remark']),
            'type' => 2,//1-购买商品，2-充值记录，3-提现记录,
        ]);
        if ($res) {
            parent::add_admin_log(['title' => '给会员充值', 'content' => $this->param]);
        }

        data_return('充值成功');
    }

    public function login_log()
    {
        $where = [];
        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;
        if (!empty($keyword)) {
            $where['uid'] = $keyword;
        }
        $total = AppCommon::data_count('common_user_login_log', $where);
        $data = AppCommon::data_list('common_user_login_log', $where, $page . ',' . $pageSize, '*', $orderBy);


        if ($total){
            foreach ($data as &$v){
                $v['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
                $v['user'] = AppCommon::data_get('common_user',['uid'=>$v['uid']],'uid,account,nickname');
            }
            unset($v);
        }



        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);

        return $this->fetch();
    }
}