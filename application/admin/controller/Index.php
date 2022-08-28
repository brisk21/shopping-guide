<?php


namespace app\admin\controller;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\common\model\ConfigSys;
use app\service\AdminMsg;
use app\service\Page;
use app\service\TongJiService;
use app\service\UpdateService;
use think\Request;

class Index extends Admin
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    public function default_index()
    {
        $this->assign('data', $this->index(true));
        return $this->fetch();
    }

    public function index($return = false)
    {
        $k = 'admin_default_frame_style' . $this->admin_uid;
        $type = cache($k);
        if (IS_AJAX) {
            if ($type == 'iframe') {
                $type = 'single_page';
                $url = url('/admin/index/index');
            } else {
                $type = 'iframe';
                $url = url('/admin/index/index_iframe');
            }
            cache($k, $type);

            data_return('ok', 0, ['type' => $type, 'url' => $url]);
        }

        $data = [];

        $time = date('Y-m');
        if (!empty($this->param['date'])) {
            $time = $this->param['date'];
        }



        if ($return) {
            return $data;
        }
        if ($type == 'iframe') {
            return $this->redirect(url('/admin/index/index_iframe'));
        }
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function index_iframe()
    {
        $k = 'admin_default_frame_style' . $this->admin_uid;
        $type = cache($k);
        if ($type <> 'iframe') {
            return $this->redirect(url('/admin/index/index'));
        }
        return $this->fetch();
    }

    public function msg()
    {
        if (IS_AJAX) {
            if (!empty($this->param['id'])) {
                $data = AppCommon::data_get('admin_msg', ['id' => intval($this->param['id'])]);
                if (empty($data)) {
                    data_return('消息不存在', -1);
                }
                data_return('success', 0, $data);
            }
        }
        $where = [];
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;
        $is_favorite = !empty($this->param['is_favorite']);
        $is_read = !empty($this->param['is_read']) ? intval($this->param['is_read']) : '';
        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';

        if (!empty($keyword)) {
            $where['title'] = ['like', '%' . $this->param['keyword'] . '%'];
        }
        if ($is_read == 1) {
            $where['read_time'] = ['>', 0];
        } elseif ($is_read == -1) {
            $where['read_time'] = 0;
        }
        if ($is_favorite) {
            $where['is_favorite'] = 1;
        }

        $total = AppCommon::data_count('admin_msg', $where);
        $data = AppCommon::data_list('admin_msg', $where, $page . ',' . $pageSize, '*', $orderBy);
        if (!empty($data)) {
            foreach ($data as &$v) {
                $v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                if ($v['msg_type'] == 'order') {
                    $v['msg_type_desc'] = '订单消息';
                } elseif ($v['msg_type'] == 'feedback') {
                    $v['msg_type_desc'] = '留言反馈';
                } elseif ($v['msg_type'] == 'kefu') {
                    $v['msg_type_desc'] = '客服消息';
                } else {
                    $v['msg_type_desc'] = '未分类';
                }
                $v['content'] = mb_substr($v['content'], 0, 15, 'utf8') . '...';
            }
            unset($v);
        }

        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    //未读消息统计
    public function msg_count()
    {
        $total = AppCommon::data_count('admin_msg', ['read_time' => 0]);

        $data = AppCommon::query("select msg_type,count(*) as total from " . table_name('admin_msg')
            . " where read_time=0 group by msg_type");

        if (!empty($data)) {
            foreach ($data as &$v) {
                $v['icon'] = 'fa-envelope';
                if ($v['msg_type'] == 'order') {
                    $v['msg_type_desc'] = '订单消息';
                    $v['icon'] = 'fa-database';
                } elseif ($v['msg_type'] == 'feedback') {
                    $v['msg_type_desc'] = '留言反馈';
                } elseif ($v['msg_type'] == 'kefu') {
                    $v['msg_type_desc'] = '客服消息';
                    $v['icon'] = 'fa-comment-dots';
                } else {
                    $v['msg_type_desc'] = '未分类';
                    $v['icon'] = 'fa-comment-dots';
                }
            }
            unset($v);
        }
        data_return('ok', 0, [
            'msg_list' => $data,
            'total' => $total
        ]);
    }

    public function msg_action()
    {
        $ac = !empty($this->param['ac']) ? $this->param['ac'] : '';
        if (!$ac) {
            data_return('参数有误', -1);
        }
        $id = !empty($this->param['id']) ? intval($this->param['id']) : 0;
        if (!empty($id)) {
            $data = AppCommon::data_get('admin_msg', ['id' => $id]);
            if (empty($data)) {
                data_return('参数有误', -1);
            }
            if ($ac == 'favorite') {
                AdminMsg::update(['id' => $data['id']], ['is_favorite' => empty($data['is_favorite']) ? 1 : 0]);
            } elseif ($ac == 'readstate') {
                AdminMsg::update(['id' => $data['id']], ['read_time' => empty($data['read_time']) ? time() : 0]);
            }
        } elseif ($ac == 'del_all') {
            if (empty($this->param['values'])) {
                data_return('请先选记录', -1);
            }
            $ids = array_unique($this->param['values']);
            array_walk($ids, function (&$id) {
                $id = intval($id);
            });
            AdminMsg::del(['id' => ['in', $ids]]);
        } elseif ($ac == 'read_all') {
            if (empty($this->param['values'])) {
                data_return('请先选记录', -1);
            }
            $ids = array_unique($this->param['values']);
            array_walk($ids, function (&$id) {
                $id = intval($id);
            });
            AdminMsg::update(['id' => ['in', $ids], 'read_time' => 0], ['read_time' => time()]);
        }

        data_return('操作成功');
    }

    //检测是否需要更新
    public function check_update($get = false)
    {
        if (!IS_AJAX) {
            data_return('非法操作', -1);
        }
        $version = UpdateService::get_version();
        $res = [
            'v' => $version
        ];
        $res['status'] = 0;
        if (!empty($version['new']) && !empty($version['old'])) {
            //只检测是否需要更新sql字段、表等
            if ($version['old']['sql_version'] < $version['new']['sql']) {
                $res['status'] = 1;
            }
        }
        if ($get) {
            return $res;
        }
        data_return('ok', 0, $res);
    }

    public function start_update()
    {
        $res = $this->check_update(true);
        if ($res['status'] <> 1) {
            data_return('无需更新', -1);
        }
        $action = UpdateService::app_update();
        data_return($action['msg'], $action['code']);
    }
}