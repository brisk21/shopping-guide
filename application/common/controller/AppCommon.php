<?php


namespace app\common\controller;


use think\Controller;
use think\Db;

class AppCommon extends Controller
{
    public static $fetch_sql = false;


    /**
     * 新增数据
     * @param $table
     * @param $data
     * @return int|string
     */
    public static function data_add($table, $data)
    {
        return Db::name($table)->fetchSql(self::$fetch_sql)->insertGetId($data);
    }

    /**
     * 新增数据-批量
     * @param $table
     * @param $data
     * @return int|string
     */
    public static function data_add_array($table, $data)
    {
        return Db::name($table)->fetchSql(self::$fetch_sql)->insertAll($data);
    }

    //更新数据
    public static function data_update($table, $where, $newData)
    {
        return Db::name($table)->fetchSql(self::$fetch_sql)->where($where)->update($newData);
    }

    //删除数据
    public static function data_del($table, $where)
    {
        return Db::name($table)->fetchSql(self::$fetch_sql)->where($where)->delete();
    }

    //单条查询
    public static function data_get($table, $where = null, $field = '*', $order = null)
    {
        return Db::name($table)->fetchSql(self::$fetch_sql)->where($where)->order($order)->field($field)->find();
    }

    /**
     * 获取某个字段
     * @param $table
     * @param null $where
     * @param string $column 某个字段名，如username，返回值
     * @param null $order
     * @return false|mixed
     */
    public static function data_get_column($table, $where = null, $column = '', $order = null)
    {
        if (!$column) {
            return false;
        }
        $data = self::data_get($table, $where, $column, $order);
        if (!isset($data[$column])) {
            return false;
        }

        return $data[$column];
    }


    /**
     * 批量查询
     * @param $table
     * @param null $where
     * @param null $page 逗号分开代表分页大小，比如1,20
     * @param string $field
     * @param null $order
     * @return bool|\PDOStatement|string|\think\Collection
     */
    public static function data_list($table, $where = null, $page = null, $field = '*', $order = null)
    {
        return Db::name($table)->fetchSql(self::$fetch_sql)->where($where)->order($order)->page($page)->field($field)->select();
    }

    //统计
    public static function data_count($table, $where = null, $field = '*')
    {
        return Db::name($table)->where($where)->count($field);
    }

    //求和
    public static function data_sum($table, $where = null, $field = '*')
    {
        return Db::name($table)->where($where)->sum($field);
    }

    //原生查询
    public static function query($sql, $bind = [], $master = false, $pdo = false)
    {
        return Db::query($sql, $bind, $master, $pdo);
    }

    //execute用于更新和写入数据的sql操作，如果数据非法或者查询错误则返回false ，否则返回影响的记录数。
    public static function execute($sql, $bind = [], $fetch = null, $getLastInsID = false, $sequence = null)
    {
        return Db::execute($sql, $bind, $fetch, $getLastInsID, $sequence);
    }

    //无需分页
    public static function data_list_nopage($table, $where = null, $field = '*', $order = null)
    {
        return Db::name($table)->fetchSql(self::$fetch_sql)->where($where)->order($order)->field($field)->select();
    }

    public static function db($table)
    {
        return Db::name($table);
    }

}