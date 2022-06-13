<?php


namespace app\service;


use app\common\controller\AppCommon;

class FeedBackService
{
    /**
     * 新增
     * @param $data array ['uid'=>'用户标识','category'=>'分类','content'=>'内容','imgs'=>'']
     * @return false|int|string
     */
    public static function add($data)
    {
        if (empty($data['uid']) || empty($data['category']) || empty($data['content'])) {
            return false;
        }
        return AppCommon::data_add('feedback', [
            'add_time' => time(),
            'up_time' => time(),
            'category' => SafeService::filter_str($data['category']),
            'content' => SafeService::filter_str($data['content']),
            'imgs' => !empty($data['imgs']) ? $data['imgs'] : '',
            'status' => 0,
            'uid' => $data['uid']
        ]);
    }

    public static function update($id, $data)
    {
        if (!self::get($id, 'id')) {
            return false;
        }
        return AppCommon::data_update('feedback', ['id' => intval($id)], $data);
    }

    public static function get($id, $field = '*')
    {
        return AppCommon::data_get('feedback', ['id' => intval($id)], $field);
    }

    public static function del($id)
    {
        if (!self::get($id, 'id')) {
            return false;
        }
        return AppCommon::data_del('feedback', ['id' => intval($id)]);
    }
}