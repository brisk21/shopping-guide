<?php


namespace app\manager\controller;


use app\common\model\ConfigSys;

class Setting extends Base
{
    public function get_data()
    {
        $data = model('ConfigSys')->get_value(ConfigSys::key_union,false);
        data_return('success',0,$data);
    }

    public function save_data()
    {
        if (!request()->isPost()){
            data_return('非法操作',-1);
        }
        $data = request()->post();
        $res = model('ConfigSys')->saveData(ConfigSys::key_union,$data);
        data_return('保存成功',0,$res);
    }


}