<?php


namespace app\admin\controller\auth;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;

class Index extends Admin
{
    function menu($getData = false)
    {
        $data = AppCommon::data_list_nopage('admin_menu', [], '*', 'id desc');
        if ($data) {
            if ($getData) {
                return tree($data, 'id', 'fid', 'subcat');
            }
            $this->assign('data', tree($data, 'id', 'fid', 'subcat'));
        }
        return $this->fetch();
    }

    public function form()
    {
        if (!empty($this->param['id'])) {
            $data = AppCommon::data_get('admin_menu', ['id' => intval($this->param['id'])]);
            if (!empty($data)) {
                $this->assign('data', $data);
            }
        }
        $this->assign('menus', $this->menu(true));
        return $this->fetch();
    }

    //操作菜单
    public function action()
    {
        if (!empty($this->param['id'])) {
            $data = AppCommon::data_get('admin_menu', ['id' => intval($this->param['id'])]);
            if (empty($data)) {
                data_return('菜单不存在', -1);
            }
        }
        //删除操作
        if (!empty($data) && !empty($this->param['ac']) && $this->param['ac'] == 'del') {
            $res = AppCommon::data_del('admin_menu', ['id' => $data['id']]);
            if ($res) {
                $two = AppCommon::data_list_nopage('admin_menu', ['fid' => $data['id']], 'id');
                if (!empty($two)) {
                    //移除二级菜单
                    $ret = AppCommon::data_del('admin_menu', ['fid' => $data['id']]);

                    if ($ret) {
                        //移除三级菜单
                        AppCommon::data_del('admin_menu', ['fid' => ['in', array_column((array)$two, 'id')]]);
                    }
                }
            }
            parent::add_admin_log(['title' => '删除权限菜单', 'content' => $data]);
        } else {
            $rule = [
                ['type' => 'length', 'key' => 'title', 'rule' => '2,80', 'msg' => '名称2~32字符',],
                ['type' => 'isset', 'key' => 'fid', 'rule' => '', 'msg' => '请选择上级',],
                ['type' => 'empty', 'key' => 'url', 'rule' => '', 'msg' => '链接地址未设置',],
            ];
            $check = check_param($this->param, $rule);
            if ($check['code'] <> 0) {
                data_return($check['msg'], $check['code']);
            }


            $baseData = [
                'name' => trim($this->param['title']),
                'url' => trim($this->param['url']),
                'fid' => intval($this->param['fid']),
                'sort' => intval($this->param['sort']),
                'status' => !empty($this->param['status']) ? 1 : 0,
                'is_new' => !empty($this->param['is_new']) ? 1 : 0,
                'type' => intval($this->param['type']),
                'class_name' => !empty($this->param['class_name']) ? trim($this->param['class_name']) : 'fa-cog',
                'qx_str' => strtolower(str_replace(['/', '.'], '@', $this->param['url']))
            ];
            if (empty($data)) {
                AppCommon::data_add('admin_menu', $baseData);
            } else {
                AppCommon::data_update('admin_menu', ['id' => $data['id']], $baseData);
            }
            parent::add_admin_log(['title' => '增改权限菜单', 'content' => $baseData]);
        }


        //更新菜单缓冲,针对tag清理全部
        cache(null, 'admin_menu');

        data_return('操作成功');
    }
}