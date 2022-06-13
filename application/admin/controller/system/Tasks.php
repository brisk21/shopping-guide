<?php


namespace app\admin\controller\system;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\service\Page;

class Tasks extends Admin
{
    //任务列表
    public function index()
    {
        $where = [];
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;
        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';

        if (!empty($keyword)) {
            $where['name'] = ['like', '%' . $keyword . '%'];

        }

        $total = AppCommon::data_count('timer_tasks', $where);
        $data = AppCommon::data_list('timer_tasks', $where, $page . ',' . $pageSize, '*', $orderBy);
        if (!empty($data)) {
            foreach ($data as &$v) {
                $v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                $v['up_time'] = date('Y-m-d H:i:s', $v['up_time']);
            }
            unset($v);
        }

        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function form()
    {
        $id = !empty($this->param['id']) ? intval($this->param['id']) : 0;
        if (!empty($id)) {
            $data = AppCommon::data_get('timer_tasks', ['id' => $id]);
            if (!empty($data)) {
                $this->assign('data', $data);
            }
        }

        return $this->fetch();
    }

    public function tasks_action()
    {
        $id = !empty($this->param['id']) ? intval($this->param['id']) : 0;
        if (!empty($id)) {
            $data = AppCommon::data_get('timer_tasks', ['id' => $id]);
            if (empty($data)) {
                data_return('记录不存在', -1);
            }
            //仅删除
            if (!empty($this->param['ac']) && $this->param['ac'] == 'del') {
                AppCommon::data_del('timer_tasks', ['id' => $data['id']]);
                data_return('删除成功');
            } elseif (!empty($this->param['ac']) && $this->param['ac'] == 'status') {
                AppCommon::data_update('timer_tasks', ['id' => $data['id']], [
                    'status' => $data['status'] == 0 ? 1 : 0
                ]);
                data_return('操作成功');
            }
        }
        if (empty($this->param['name'])) {
            data_return('请填写名称', -1);
        }
        if (empty($this->param['content'])) {
            data_return('请填写任务内容', -1);
        }
        $baseData = [
            'name' => $this->param['name'],
            'content' => $this->param['content'],
            'do_type' => $this->param['do_type'],
            'up_time' => time(),
            'status' => !empty($this->param['status']) ? 1 : 0,
            'ext_data' => !empty($this->param['ext_data']) ? $this->param['ext_data'] : '',
            'time_set' => !empty($this->param['time_set']) ? $this->param['time_set'] : '',
        ];
        if (!empty($data)) {
            AppCommon::data_update('timer_tasks', ['id' => $data['id']], $baseData);
        } else {
            $baseData['add_time'] = time();
            AppCommon::data_add('timer_tasks', $baseData);
        }

        data_return('操作成功');
    }
}