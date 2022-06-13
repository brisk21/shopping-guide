<?php


namespace app\common\model;


class ConfigSys extends Base
{
    public function get_value($key)
    {
        $data = $this->where(['key'=>$key])->cache(3600)->value('value');

        return $data?json_decode($data,true):[];
    }
}