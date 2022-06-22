<?php


namespace app\service;


use app\common\controller\AppCommon;

class Credits
{
    /**
     * @param $uid int|string 用户的id或者uid
     * @param string $field
     */
    public static function get($uid, $field = '*')
    {
        if (!CommonUser::get($uid, 'uid')) {
            return [];
        }

        $where = ['uid' => $uid];
        if (is_numeric($uid)) {
            $where = ['id' => intval($uid)];
        }


        $data = AppCommon::data_get('common_user_credits', $where, $field);

        if (empty($data)) {
            self::add($uid);
            $data = AppCommon::data_get('common_user_credits', $where, $field);
        }
        return $data;
    }

    public static function add($uid)
    {
        AppCommon::data_add('common_user_credits', [
            'credit' => 0,
            'point' => 0,
            'uid' => $uid
        ]);
    }

    /**
     * 更新账户余额
     * @param $uid string 用户uid
     * @param $field string 字段,credit-余额，point-积分
     * @param $num float 大于零是增加，否则减少
     * @param $arg array 扩展参数，remark-备注，type-类型
     * @return false|int|string
     */
    public static function set($uid, $field, $num, $arg)
    {
        return self::update($uid, $field, $num, $arg);
    }

    /**
     * 更新账户余额
     * @param $uid string 用户uid
     * @param $field string 字段,credit-余额，point-积分
     * @param $num float 大于零是增加，否则减少
     * @param $arg array 扩展参数，remark-备注，type-类型
     * @return false|int|string
     */
    public static function update($uid, $field, $num, $arg)
    {
        $account = self::get($uid, $field);
        if (!isset($account[$field]) || $num == 0) {
            return false;
        }
        $before = $account[$field];
        if ($num < 0) {
            $after = $before - abs($num);
        } else {
            $after = $before + abs($num);
        }
        $res = AppCommon::data_update('common_user_credits', ['uid' => $uid], [$field => $after]);
        if (!$res) {
            return false;
        }
        //资金扣除流水记录
        $log = [
            'uid' => $uid,
            'remark' => $arg['remark'],
            'type' => isset($arg['type']) ? $arg['type'] : ($num > 0 ? 2 : 1),//类型：2-收入，1-支出
            'before_num' => $before,
            'num' => $num,
            'after_num' => $after
        ];
        //积分操作
        if ($field == 'point') {
            unset($log['type']);
            return self::add_point_log($log);
        }
        return self::add_credit_log($log);
    }

    //积分记录
    private static function add_point_log($data)
    {
        $data['add_time'] = time();
        return AppCommon::data_add('common_user_point_log', $data);
    }


    //余额记录
    private static function add_credit_log($data)
    {
        $data['add_time'] = time();
        return AppCommon::data_add('common_user_credit_log', $data);
    }
}