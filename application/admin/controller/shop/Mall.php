<?php


namespace app\admin\controller\shop;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;

//todo 多店铺
class Mall extends Admin
{
    public function index()
    {
        $data = AppCommon::data_get('stores');
        if (!empty($data)) {
            $this->assign('data', $data);
        }
        return $this->fetch();
    }


    public function mall_action()
    {
        if (empty($this->param['store_name'])) {
            data_return('店铺名称必填', -1);
        }
        $data = AppCommon::data_get('stores');
        $upData = [
            'store_name' => trim($this->param['store_name']),
            'store_logo' => trim($this->param['img']),
            'up_time' => time(),
            'status' => !empty($this->param['status']) ? 1 : -1,
        ];
        if (empty($data)) {
            $upData['add_time'] = time();

            $upData['is_check'] = 1;//fixme 默认已通过审核
            $upData['store_num'] = getNumberCode(10);

            AppCommon::data_add('stores', $upData);
        } else {
            AppCommon::data_update('stores', ['id' => $data['id']], $upData);
        }

        parent::add_admin_log(['title' => '修改店铺', 'content' => $upData]);
        data_return();
    }
}