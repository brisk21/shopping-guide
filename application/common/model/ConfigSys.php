<?php


namespace app\common\model;


class ConfigSys extends Base
{
    const key_union = 'union';
    const key_thumb_domain = 'thumb_domain';

    public function get_value($key, $cache = 3600)
    {
        $data = $this->where(['key' => $key])->cache($cache)->value('value');

        return $data ? json_decode($data, true) : [];
    }

    public function saveData($key, $newData)
    {
        $data = $this->get_value($key, false);
        foreach ($newData as $k => $value) {
            $data[$k] = $value;
        }
        return $this->isUpdate(true)->save([
            'value' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ], ['key' => $key]);
    }
}