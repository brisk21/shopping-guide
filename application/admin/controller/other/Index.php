<?php


namespace app\admin\controller\other;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\service\FeedBackService;
use app\service\Page;

class Index extends Admin
{
    //留言反馈
    public function feedback()
    {
        $where = [];
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;
        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';

        if (!empty($keyword)) {
            if (is_uid($keyword)) {
                $where['uid'] = $keyword;
            } else {
                $user = AppCommon::data_list_nopage('common_user', ['account' => ['like', '%' . $keyword . '%']], 'uid');
                if (!empty($user)) {
                    $where['uid'] = ['in', array_column($user, 'uid')];
                } else {
                    $where['uid'] = '';
                }
            }

        }

        $total = AppCommon::data_count('feedback', $where);
        $data = AppCommon::data_list('feedback', $where, $page . ',' . $pageSize, '*', $orderBy);
        if (!empty($data)) {
            foreach ($data as &$v) {
                $v['user'] = AppCommon::data_get('common_user', ['uid' => $v['uid']], 'account,uid');
                if (empty($v['user'])) {
                    $v['user'] = [
                        'uid' => $v['uid'],
                        'account' => '<span class="bs-red">已注销</span>'
                    ];
                }
                if (!empty($v['imgs'])) {
                    $v['imgs'] = explode(',', $v['imgs']);
                }
                if ($v['status'] == 0) {
                    $v['statusDesc'] = '<span class="bs-red">待处理</span>';
                } else {
                    $v['statusDesc'] = '<span class="bs-green">已处理</span>';
                }
            }
            unset($v);
        }

        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    function feed_action()
    {
        $ac = !empty($this->param['ac']) ? trim($this->param['ac']) : '';
        if (empty($this->param['id'])) {
            data_return('操作参数有误', -1);
        }
        $data = FeedBackService::get($this->param['id']);
        if (empty($data)) {
            data_return('记录不存在', -1);
        }
        if ($ac == 'del') {
            FeedBackService::del($data['id']);
            data_return('删除成功');
        } elseif ($ac == 'set_status') {
            FeedBackService::update($data['id'], ['status' => $data['status'] == 0 ? 1 : 0]);
        }

        data_return();

    }
}