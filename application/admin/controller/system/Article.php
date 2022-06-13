<?php


namespace app\admin\controller\system;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\service\Page;

class Article extends Admin
{
    public function index()
    {
        $where = [];
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;

        $status = isset($this->param['status']) && is_numeric($this->param['status']) ? intval($this->param['status']) : '';
        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';
        $orderBy = 'id desc';


        if ($status !== '') {
            $where['status'] = $status;
        }

        if (!empty($keyword)) {
            $where['title'] = ['like', '%' . $keyword . '%'];
        }


        $status = [
            '1' => '<span class="bs-green">展示中</span>',
            '0' => '<span class="bs-red">已下线</span>',
        ];
        $data = AppCommon::data_list('article_sys', $where, $page . ',' . $pageSize, 'title,id,status,count_view,add_time,up_time', $orderBy);

        if (!empty($data)) {

            array_walk($data, function (&$v, $k, $arg) {
                $v['up_time'] = date('Y-m-d H:i:s', $v['up_time']);
                $v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                $v['statusDesc'] = $arg['status'][$v['status']];
            }, ['status' => $status]);
        }

        $total = AppCommon::data_count('article_sys', $where);

        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    //设置状态
    public function action_status()
    {
        if (empty($this->param['id'])) {
            data_return('参数有误', -1);
        }
        $data = AppCommon::data_get('article_sys', ['id' => intval($this->param['id'])]);
        if (empty($data['id'])) {
            data_return('记录不存在', -1);
        }
        $res = AppCommon::data_update('article_sys', ['id' => $data['id']], [
            'up_time' => time(),
            'status' => $data['status'] == 1 ? 0 : 1
        ]);
        if ($res) {
            parent::add_admin_log(['title' => '修改系统文章状态', 'content' => ($data['status'] == 1 ? '下线' : '展示')]);
        }

        data_return('设置成功');
    }

    public function form()
    {
        $id = !empty($this->param['id']) ? intval($this->param['id']) : 0;
        if (!empty($id)) {
            $data = AppCommon::data_get('article_sys', ['id' => $id]);
            if (!empty($data)) {
                $this->assign('data',$data);
            }

        }
        return $this->fetch();
    }

    //操作公告
    public function action()
    {
        $id = !empty($this->param['id']) ? intval($this->param['id']) : 0;
        if (!empty($id)) {
            $data = AppCommon::data_get('article_sys', ['id' => $id]);
            if (empty($data)) {
                data_return('记录不存在', -1);
            }
            //仅删除
            if (!empty($this->param['ac']) && $this->param['ac'] == 'del') {
                if ($data['id']==1){
                    data_return('协议不支持删除',-1);
                }
                AppCommon::data_del('article', ['id' => $data['id']]);
                data_return('删除成功');
            }
        }
        if (empty($this->param['title'])) {
            data_return('请填写标题', -1);
        }
        if (empty($this->param['content'])) {
            data_return('请填写内容', -1);
        }
        if (!empty($data)) {
            AppCommon::data_update('article_sys', ['id' => $data['id']], [
                'title' => trim($this->param['title']),
                'content' => $this->param['content'],
                'up_time' => time(),
                'status' => !empty($this->param['status']) ? 1 : 0,
            ]);
        } else {
            AppCommon::data_add('article_sys', [
                'title' => trim($this->param['title']),
                'content' => $this->param['content'],
                'up_time' => time(),
                'add_time' => time(),
                'status' => !empty($this->param['status']) ? 1 : 0,
            ]);
        }

        data_return('操作成功');
    }


}