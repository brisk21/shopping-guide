<?php


namespace app\admin\controller\shop;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\service\Page;

class Banner extends Admin
{
    public function index()
    {
        $where = [];
        $status = isset($this->param['status']) && is_numeric($this->param['status']) ? intval($this->param['status']) : '';
        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;
        if (!empty($status)) {
            $where['status'] = 1;
        } elseif (is_numeric($status)) {
            $where['status'] = 0;
        }

        if (!empty($keyword)) {
            $where['title'] = ['like','%'.$keyword.'%'];
        }
        $data = AppCommon::data_list('banner', $where, $page . ',' . $pageSize, '*', $orderBy);

        $total = AppCommon::data_count('banner', $where);

        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function form()
    {
        $id = !empty($this->param['id']) ? intval($this->param['id']) : 0;
        if (!empty($id)) {
            $data = AppCommon::data_get('banner', ['id' => $id]);
            if (!empty($data)) {
                $data['s_time'] = date('Y-m-d H:i:s',$data['s_time']);
                $data['e_time'] = date('Y-m-d H:i:s',$data['e_time']);
                $this->assign('data',$data);
            }

        }
        return $this->fetch();
    }

    //设置状态
    public function action_status()
    {
        if (empty($this->param['id'])) {
            data_return('参数有误', -1);
        }
        $data = AppCommon::data_get('banner', ['id' => intval($this->param['id'])]);
        if (empty($data['id'])) {
            data_return('记录不存在', -1);
        }
        $res = AppCommon::data_update('banner', ['id' => $data['id']], [
            'status' => $data['status'] == 0 ? -1 : 0
        ]);
        if ($res) {
            parent::add_admin_log(['title' => '修改轮播图状态', 'content' => ($data['status'] == 0 ? '下线' : '展示')]);
        }

        data_return('设置成功');
    }

    //操作
    public function banner_action()
    {
        $id = !empty($this->param['id']) ? intval($this->param['id']) : 0;
        if (!empty($id)) {
            $data = AppCommon::data_get('banner', ['id' => $id]);
            if (empty($data)) {
                data_return('记录不存在', -1);
            }
            //仅删除
            if (!empty($this->param['ac']) && $this->param['ac'] == 'del') {
                AppCommon::data_del('banner', ['id' => $data['id']]);
                parent::add_admin_log(['title' => '删除轮播图', 'content' => $data]);
                data_return('删除成功');
            }
        }
        if (empty($this->param['title'])) {
            data_return('请填写名称', -1);
        }
        if (empty($this->param['img'])) {
            data_return('请上传图标', -1);
        }
        if (empty($this->param['url'])) {
            data_return('请设置跳转url', -1);
        }
        if (empty($this->param['stime'])||empty($this->param['etime']) || strtotime($this->param['etime'])<=strtotime($this->param['stime'])){
            data_return('开始和结束时间设置不合理', -1);
        }
        if (!empty($data)) {
            AppCommon::data_update('banner', ['id' => $data['id']], [
                'title' => trim($this->param['title']),
                'url' => trim($this->param['url']),
                'img' => trim($this->param['img']),
                's_time' => strtotime($this->param['stime']),
                'e_time' => strtotime($this->param['etime']),
                'status' => !empty($this->param['status']) ? 0 : -1,
            ]);
        } else {
            AppCommon::data_add('banner', [
                'title' => trim($this->param['title']),
                'url' => trim($this->param['url']),
                'img' => trim($this->param['img']),
                's_time' => strtotime($this->param['stime']),
                'e_time' => strtotime($this->param['etime']),
                'status' => !empty($this->param['status']) ? 0 : -1,
            ]);
        }
        parent::add_admin_log(['title' => '操作轮播图', 'content' => $this->param]);
        data_return('操作成功');
    }
}