<?php


namespace app\service;


use app\common\controller\AppCommon;

class ConfigService
{
    /**
     * 操作配置
     * @param $key
     * @param $data
     * @return int|string
     */
    public static function action($key, $data)
    {
        $data = ['key' => $key, 'value' => json_encode($data, JSON_UNESCAPED_UNICODE)];
        if (AppCommon::data_get('config', ['key' => $key], 'id')) {
            $res = AppCommon::data_update('config', ['key' => $key], $data);
        } else {
            $res = AppCommon::data_add('config', $data);
        }
        //更新一下缓存到最新配置
        self::get($key,true);
        return $res;
    }

    /**
     * 获取配置
     * @param $key
     * @param false $latest 是否强制获取最新的
     * @return array|mixed
     */
    public static function get($key, $latest = false)
    {
        $cacheKey = 'config_' . md5(__FILE__ . __CLASS__ . __FUNCTION__ . 'abc'.$key);
        if (!$latest) {
            $data = cache($cacheKey);
            if ($data) {
                return $data;
            }
        }

        $conf = AppCommon::data_get('config', ['key' => $key], 'value');
        if (empty($conf['value'])) {
            return [];
        }
        $data = json_decode($conf['value'], true);

        cache($cacheKey, $data, 86400 * 7);
        return $data;
    }
}