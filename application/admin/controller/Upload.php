<?php


namespace app\admin\controller;


use app\admin\controller\com\Admin;
use app\service\Uploader;

class Upload extends Admin
{
    //上传图片
    public function image()
    {
        if (empty($this->param['fileKey'])) {
            data_return('参数有误', -1);
        }
        if (empty($this->param['from'])) {
            data_return('参数有误', -1);
        }
        $tool_form = !empty($this->param['tool_form']) ? trim($this->param['tool_form']) : '';

        if (empty($_FILES[$this->param['fileKey']])) {
            data_return('请先选择文件', -1);
        }

        $toPath = config('upload')['defaultPath'] . trim($this->param['from']) . '/';
        //拼接全连接
        $returnUrl = str_replace(PUBLIC_PATH, URL_WEB, $toPath);
        $res = Uploader::start_upload($this->param['fileKey'], $toPath, $returnUrl,'',1);
        if ($res['code'] == 0) {
            parent::add_admin_log(['title' => '上传文件', 'content' => $res['data']]);
        }

        data_return(
            $res['code'] == 0 ? 'ok' : $res['msg'],
            $res['code'],
            [
                'url' => isset($res['data']) ? $res['data'] : '',
            ]
        );
    }


}