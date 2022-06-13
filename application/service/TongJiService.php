<?php

namespace app\service;


use app\common\controller\AppCommon;

class TongJiService
{
    /**
     * @param string $table order_sms|order_recharge|order_flowcard|order_machine
     * @param string $time eg:2019(按月统计) 或者2019-10(按日统计)
     * @param string $type month or day
     * @param string $storeNum
     * @return mixed
     */
    public static function tongji_order($table, $time = '', $type = 'day', $storeNum = '')
    {
        $key = 'statistics_'.md5($table.$time.$type.$storeNum);
        $data = cache($key);
        if ($data){
            return  $data;
        }
        if ($time) {
            $stime = date('Y-m-01 00:00:00', strtotime($time));
            $etime = date('Y-m-d 23:59:59', strtotime("-1 second", strtotime("+1 month", strtotime($stime))));
            if ($type == 'month') {
                $stime = $time . '-01-01 00:00:00';
                $etime = $time . '-12-31 23:59:59';
            }
        } else {
            $stime = date('Y-m-01 00:00:00');
            $etime = date('Y-m-d 23:59:59', strtotime("-1 second", strtotime("+1 month", strtotime($stime))));
            if ($type == 'month') {
                $stime = date('Y-01-01 00:00:00');
                $etime = date('Y-12-31 23:59:59');
            }
        }
        $stime = strtotime($stime);
        $etime = strtotime($etime);
        $prefix = config('database.prefix');

        $where = " pay_time >= '" . $stime . "'  AND pay_time <= '" . $etime . "'  ";
        if ($storeNum) {
            $where .= " and store_num='{$storeNum}'";
        }


        $queryType = "DATE";
        if ($type == 'month') {
            $queryType = "MONTH";
        };
        $sql = "SELECT SUM(pay_price - refund_total) as  total, $queryType(FROM_UNIXTIME(pay_time)) as pay_time FROM " . $prefix . $table . " 
               WHERE $where
               GROUP BY $queryType(FROM_UNIXTIME(pay_time)) 
               ORDER BY $queryType(FROM_UNIXTIME(pay_time)) ASC ";
        $data = AppCommon::query($sql);

        $data =  self::format_data($data, $stime, $type);
        cache($key,$data,60);
        return $data;
    }

    private static function format_data($data, $stime, $type)
    {
        if ($data) {
            $payTime = array_column($data, 'pay_time');
        } else {
            $payTime = [];
        }
        if ($type == 'month') {
            for ($i = 1; $i <= 12; $i++) {
                if (!in_array($i, $payTime)) {
                    $data[] = ['total' => '0.00', 'pay_time' => $i];
                }
            }
            $payTime = array_column($data, 'pay_time');
            array_multisort($payTime, SORT_ASC, $data);//按时间
        } else {
            $t = date('t', $stime);
            $format = date('Y-m', $stime);//2019-10
            for ($i = 1; $i <= $t; $i++) {
                if ($i < 10) $i = '0' . $i;
                //未来过滤
                if ($format == date('Y-m', time()) && $i > date('d')) {
                    break;
                }
                if (!in_array($format . '-' . $i, $payTime)) {
                    //模拟操作
                    //$data[] = ['total' => rand(1, 200) . '.' . rand(0, 99), 'pay_time' => $format . '-' . $i];
                    $data[] = ['total' => '0.00', 'pay_time' => $format . '-' . $i];
                }
            }
            $payTime = array_column($data, 'pay_time');
            array_multisort($payTime, SORT_ASC, $data);//按时间
        }
        return $data;
    }

    public static function get_xAxis($time, $type)
    {
        $data = [];
        if ($type == 'month') {
            for ($i = 1; $i <= 12; $i++) {
                $data[] = "'" . $i . "月'";
            }
        } else {
            if ($time) {
                $t = date('t', strtotime($time));
            } else {
                $t = date('t');
            }
            for ($i = 1; $i <= $t; $i++) {
                if ($i < 10) $i = '0' . $i;
                //未来过滤
                if (date('Y-m') == date('Y-m', strtotime($time)) && $i > date('d') && $i > 15) {
                    break;
                }
                $data[] = $i;
            }
        }
        return $data;
    }
}