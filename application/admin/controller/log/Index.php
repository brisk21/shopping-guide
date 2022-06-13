<?php


namespace app\admin\controller\log;


use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\AddShortUrlResponseBody\data;
use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\service\ErrorService;
use app\service\Page;

class Index extends Admin
{
    //验证码记录
    public function verifycode()
    {
        $where = [];
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;

        $data = AppCommon::data_list('verify_code_log', $where, $page . ',' . $pageSize, '*', $orderBy);

        $total = AppCommon::data_count('verify_code_log', $where);
        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    //管理操作日志
    public function admin_log()
    {
        $where = [];
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;

        $data = AppCommon::data_list('admin_action_log', $where, $page . ',' . $pageSize, '*', $orderBy);

        $total = AppCommon::data_count('admin_action_log', $where);
        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    //异常日志
    public function error_log()
    {
        $where = [];
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;

        $data = AppCommon::data_list('error_log', $where, $page . ',' . $pageSize, '*', $orderBy);

        $total = AppCommon::data_count('error_log', $where);
        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    //删除日志
    public function error_log_del()
    {
        if (empty($this->param['id']) && empty($this->param['isall'])) {
            data_return('参数有误', -1);
        }
        if (!empty($this->param['id'])) {
            AppCommon::data_del('error_log', ['id' => intval($this->param['id'])]);
        } else {
            AppCommon::data_del('error_log', ['id' => ['>', 0]]);
        }

        data_return();
    }

    //上传日志
    public function upload_log()
    {
        $where = [];
        $orderBy = 'id desc';
        $page = !empty($this->param['page']) ? intval($this->param['page']) : 1;
        $pageSize = 10;

        $data = AppCommon::data_list('upload_files_log', $where, $page . ',' . $pageSize, '*', $orderBy);

        $total = AppCommon::data_count('upload_files_log', $where);

        if (!empty($data)) {
            foreach ($data as &$v) {
                $v['size'] = $v['size'] / 1024;
                if ($v['size'] >= 1024) {
                    $v['size'] = round($v['size'] / 1024, 2) . 'Mb';
                } else {
                    $v['size'] = round($v['size'], 2) . 'Kb';
                }
            }
            unset($v);
        }

        $this->assign('page', Page::set($data, $pageSize, $page, $total, $this->param, url()));
        $this->assign('data', $data);
        return $this->fetch();
    }

    //删除上传日志
    public function upload_log_del()
    {
        if (empty($this->param['id'])) {
            data_return('参数有误', -1);
        }
        $data = AppCommon::data_get('upload_files_log',['id'=>intval($this->param['id'])]);

        if (empty($data)){
            data_return('记录不存在',-1);
        }
        if ($data['upload_type']=='local'){
            AppCommon::data_del('upload_files_log',['id'=>$data['id']]);
            //删除文件
            if (is_file(PUBLIC_PATH.$data['path'])){
               $res = @unlink(PUBLIC_PATH.$data['path']) ;
            }
            data_return('删除成功');
        }else{
            data_return('目前仅限清理本地储存类型的文件',-1);
        }
    }
}