<?php


namespace app\admin\controller\auth;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\service\Page;
use think\Request;

class Auser extends Admin
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    public function form()
    {
        if (!empty($this->param['id'])) {
            $this->assign('data', AppCommon::data_get('admin', ['id' => intval($this->param['id'])]));
        }
        $roles = AppCommon::data_list_nopage('admin_role', null, '*', 'id desc');
        $this->assign('roles', $roles);
        return $this->fetch();
    }

    public function index()
    {
        $where = [];
        $status = isset($this->param['status']) && is_numeric($this->param['status']) ? intval($this->param['status']) : '';
        $roleId = !empty($this->param['roleId']) ? intval($this->param['roleId']) : 0;
        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;
        if (!empty($status)) {
            $where['status'] = 1;
        } elseif (is_numeric($status)) {
            $where['status'] = '0';
        }

        if (!empty($roleId)) {
            $where['role_id'] = $roleId;
        }
        if (!empty($keyword)) {
            if (is_uid($keyword)){
                $where['uid'] = $keyword;
            }else{
                $where['account'] = $keyword;
            }

        }
        $data = AppCommon::data_list('admin', $where, $page . ',' . $pageSize, '*', $orderBy);

        $total = AppCommon::data_count('admin', $where);
        $roles = AppCommon::data_list_nopage('admin_role');

        if ($data && $roles) {
            $roles = array_column($roles, null, 'id');
            foreach ($data as &$v) {
                if ($v['role_id'] == 0) {
                    $v['roleName'] = '超级管理';
                } else {
                    if (isset($roles[$v['role_id']])) {
                        $v['roleName'] = $roles[$v['role_id']]['name'];
                    } else {
                        //角色被删除了
                        $v['roleName'] = '未分配';
                    }
                }
            }
            unset($v);
        }

        $this->assign('roles', $roles);
        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    //管理员操作
    public function action()
    {
        $id = !empty($this->param['id']) ? intval($this->param['id']) : 0;
        if (!empty($id)) {
            $data = AppCommon::data_get('admin', ['id' => $id]);
            if (empty($data)) {
                data_return('账户不存在', -1);
            }
            //仅删除
            if (!empty($this->param['ac']) && $this->param['ac'] == 'del') {
                if ($data['id'] == 1) {
                    data_return('创始人账号不支持删除', -1);
                }
                AppCommon::data_del('admin', ['id' => $data['id']]);
                parent::add_admin_log(['title' => '删除管理员', 'content' => $data]);
                data_return('删除成功');
            }
        }

        $rule = [
            ['type' => 'length', 'key' => 'user_name', 'rule' => '2,32', 'msg' => '昵称1~32字符',],
            ['type' => 'empty', 'key' => 'account', 'rule' => '1,16', 'msg' => '登录账号1~16字符',],
        ];
        $check = check_param($this->param, $rule);
        if ($check['code'] <> 0) {
            data_return($check['msg'], $check['code']);
        }

        //修改或者设置密码
        if (!empty($this->param['pwd1'])) {
            if (strlen($this->param['pwd1']) < 6) {
                data_return('密码不够安全', -1);
            }
            if ($this->param['pwd1'] !== $this->param['pwd2']) {
                data_return('两次密码不一样', -1);
            }
        }

        if (empty($data) && empty($this->param['pwd1'])) {
            data_return('请设置密码', -1);
        }
        $baseData = [
            'account' => trim($this->param['account']),
            'user_name' => trim($this->param['user_name']),
            'user_desc' => trim($this->param['desc']),
            'role_id' => !empty($this->param['role_id']) ? intval($this->param['role_id']) : 0,
            'up_time' => time(),
            'status' => !empty($this->param['status']) ? 1 : 0,
        ];
        //添加
        if (empty($data)) {
            $has = AppCommon::data_get('admin', ['account' => trim($this->param['account'])], 'id');
            if (!empty($has['id'])) {
                data_return('登录账号已存在', -1);
            }
            $salt = get_random(10, false);
            $pwd = md5($this->param['pwd1'] . $salt);
            $uid = 'bs' . md5($this->param['account'] . rand(1, 999999) . time());
            while (true) {
                $tmp = AppCommon::data_get('admin', ['uid' => $uid], 'id');
                if (empty($tmp['id'])) {
                    break;
                }
                $uid = 'bs' . md5($this->param['account'] . rand(1, 999999) . time() . get_random(10, false));
            }
            $baseData = array_merge($baseData, [
                'uid' => $uid,
                'pwd' => $pwd,
                'salt' => $salt,
                'add_time' => time(),
            ]);
            AppCommon::data_add('admin', $baseData);
        } else {
            if (!empty($this->param['pwd1'])) {
                $salt = get_random(10, false);
                $pwd = md5($this->param['pwd1'] . $salt);
                $baseData = array_merge($baseData, [
                    'pwd' => $pwd,
                    'salt' => $salt,
                ]);
            }

            AppCommon::data_update('admin', ['id' => $data['id']], $baseData);
        }

        parent::add_admin_log(['title' => '增改管理员', 'content' => $baseData]);
        data_return('操作成功');
    }

    //角色列表
    public function role()
    {
        $where = [];
        $keyword = !empty($this->param['keyword']) ? trim($this->param['keyword']) : '';
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;
        if (!empty($keyword)) {
            $where['name'] = ['like', '%' . $keyword . '%'];
        }
        $data = AppCommon::data_list('admin_role', $where, $page . ',' . $pageSize, '*', $orderBy);

        $total = AppCommon::data_count('admin_role', $where);
        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function role_action()
    {
        $id = !empty($this->param['id']) ? intval($this->param['id']) : 0;
        if (!empty($id)) {
            $data = AppCommon::data_get('admin_role', ['id' => $id]);
            if (empty($data)) {
                data_return('角色不存在', -1);
            }
            //仅删除
            if (!empty($this->param['ac']) && $this->param['ac'] == 'del') {
                $res = AppCommon::data_del('admin_role', ['id' => $data['id']]);
                if ($res) {
                    //清理角色权限
                    AppCommon::data_del('admin_role_auth', ['role_id' => $data['id']]);
                }
                parent::add_admin_log(['title' => '删除角色', 'content' => $data]);
                data_return('删除成功');
            }
        }
        if (empty($this->param['name'])) {
            data_return('请填写角色名称', -1);
        }
        if (!empty($data)) {
            AppCommon::data_update('admin_role', ['id' => $data['id']], ['name' => trim($this->param['name'])]);
        } else {
            AppCommon::data_add('admin_role', ['name' => trim($this->param['name'])]);
        }
        parent::add_admin_log(['title' => '增改角色', 'content' => $this->param]);
        data_return('操作成功');

    }

    //权限设置页面
    public function role_set()
    {
        if (empty($this->param['id'])) {
            return $this->error('参数有误');
        }
        $hasAuth = AppCommon::data_list_nopage('admin_role_auth', ['role_id' => intval($this->param['id'])], 'menu_id');
        $data = AppCommon::data_list_nopage('admin_menu', [], '*', 'id desc');
        if ($data) {
            if ($hasAuth) {
                $hasIds = array_column((array)$hasAuth, 'menu_id');
                foreach ($data as &$v) {
                    if (in_array($v['id'], $hasIds)) {
                        $v['checked'] = 1;
                    } else {
                        $v['checked'] = 0;
                    }
                }
                unset($v);
            }
            $this->assign('data', tree($data, 'id', 'fid', 'subcat'));
        }
        return $this->fetch();
    }

    public function role_auth_action()
    {
        if (empty($this->param['id'])) {
            data_return('参数有误', -1);
        }
        $data = AppCommon::data_get('admin_role', ['id' => intval($this->param['id'])]);
        if (empty($data)) {
            data_return('角色不存在', -1);
        }
        $array = [];
        parent::add_admin_log(['title' => '修改角色权限', 'content' => ['role' => $data, 'arg' => $this->param]]);
        //清理已有授权
        AppCommon::data_del('admin_role_auth', ['role_id' => $data['id']]);
        if (empty($this->param['ids'])) {
            data_return('操作成功');
        }
        foreach ($this->param['ids'] as $menu_id) {
            $array[] = [
                'role_id' => $data['id'],
                'menu_id' => $menu_id
            ];
        }
        AppCommon::data_add_array('admin_role_auth', $array);
        //更新菜单缓冲,针对tag清理全部
        cache(null, 'admin_menu');
        data_return('操作成功');
    }



    //登录记录
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
        $total = AppCommon::data_count('admin_login_log', $where);
        $data = AppCommon::data_list('admin_login_log', $where, $page . ',' . $pageSize, '*', $orderBy);


        if ($total){
            foreach ($data as &$v){
                $v['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
                $v['user'] = AppCommon::data_get('admin',['uid'=>$v['uid']],'uid,account,user_name');
            }
            unset($v);
        }



        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);

        return $this->fetch();
    }
}