<?php


namespace app\service;


use app\common\controller\AppCommon;

class AdminMsg
{
    /**
     * 消息发送
     * @param $data array title-标题，content-内容，msg_type-[自定义消息类型，order-订单类型，feedback-留言反馈，kefu-客服消息]
     * @return int|string
     */
    public static function add($data)
    {
        if (empty($data['content'])) {
            return 0;
        }
        return AppCommon::data_add('admin_msg', [
            'add_time' => time(),
            'title' => !empty($data['title']) ? mb_substr(trim($data['title']), 0, 128) : '未设置',
            'content' => !empty($data['content']) ? trim($data['content']) : '',
            //自定义消息类型，order-订单类型，feedback-留言反馈，kefu-客服消息]
            'msg_type' => !empty($data['msg_type']) ? trim($data['msg_type']) : '',
        ]);
    }

    /**
     * 更新消息
     * @param $where
     * @param $data
     * @return int|string
     */
    public static function update($where, $data)
    {
        return AppCommon::data_update('admin_msg', $where, $data);
    }

    /**
     * 删除消息
     * @param $where
     * @return false|int
     */
    public static function del($where)
    {
        return AppCommon::data_del('admin_msg', $where);
    }
}