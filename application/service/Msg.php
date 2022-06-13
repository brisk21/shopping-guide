<?php


namespace app\service;


use app\common\controller\AppCommon;

/**
 * 用户消息记录
 * Class Msg
 * @package app\service
 */
class Msg
{
    /**
     * 消息发送
     * @param $uid string 用户标识
     * @param $data array title-标题，content-内容，type-类型(0-普通消息，1-系统通知)
     * @return int|string
     */
    public static function add($uid, $data)
    {
        if (empty($data['content'])) {
            return 0;
        }
        return AppCommon::data_add('common_user_msg', [
            'uid' => $uid,
            'add_time' => time(),
            'title' => !empty($data['title']) ? mb_substr(trim($data['title']), 0, 128) : '未设置',
            'content' => !empty($data['content']) ? trim($data['content']) : '',
            //0-普通消息，1-系统通知
            'type' => !empty($data['type']) ? intval($data['type']) : 0,
        ]);
    }

    public static function update($id, $data)
    {
        return AppCommon::data_update('common_user_msg', ['id' => intval($id)], $data);
    }

    /**
     * 删除消息
     * @param int $id 某记录ID
     * @param string $uid 某用户uid
     * @param false $isAll 是否清空全部
     * @return false|int
     */
    public static function del($id = 0, $uid = '', $isAll = false)
    {
        if (empty($id) && empty($uid)) {
            return false;
        }
        if ($isAll && !$uid) {
            return false;
        }
        if ($isAll) {
            return AppCommon::data_del('common_user_msg', ['uid' => $uid]);
        }
        return AppCommon::data_del('common_user_msg', ['id' => intval($id)]);
    }
}