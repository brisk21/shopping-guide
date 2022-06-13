<?php
/**
 * 自定义日志类
 */

namespace app\service;

define('DIY_LOG_PATH', RUNTIME_PATH . '/log/diy/' . date('Ymd') . '/');

class DiyLog
{
    //默认保存位置
    public static $save_path = DIY_LOG_PATH;

    /**
     * 文件方式存放
     * @param $log array|string|object|int ...
     * @param string $fileName
     * @param bool $replace 是否只保留最后一份
     * @return false|void
     */
    public static function file($log, $fileName = '', $replace = false)
    {
        if (empty($log)) {
            return false;
        }
        if (!$fileName) {
            $fileName = date('Ymd') . '_log.log';
        }
        $log = json_encode(['time' => date('Y-m-d H:i:s'), 'log' => $log], JSON_UNESCAPED_UNICODE);

        if (!is_dir(self::$save_path)) {
            mkdir(self::$save_path, 0777, true);
        }
        if (!is_dir(self::$save_path) || !is_writable(self::$save_path)) {
            return false;
        }

        if ($replace) {
            file_put_contents(self::$save_path . $fileName, $log);
        } else {
            file_put_contents(self::$save_path . $fileName, PHP_EOL . $log, FILE_APPEND);
        }
    }

    public static function file_trace($log, $fileName = '', $type = 'debug', $replace = false)
    {
        if (empty($log)) {
            return false;
        }
        if (!$fileName) {
            $fileName = date('Ymd') . '_trace.log';
        }
        $log = '[' . $type . '] ' . var_export([
                'time' => date('Y-m-d H:i:s'),
                'log' => $log
            ], 1);
        $log .= PHP_EOL. '----------------------------------------';
        if (!is_dir(self::$save_path)) {
            mkdir(self::$save_path, 0777, true);
        }
        if (!is_dir(self::$save_path) || !is_writable(self::$save_path)) {
            return false;
        }

        if ($replace) {
            file_put_contents(self::$save_path . $fileName, $log);
        } else {
            file_put_contents(self::$save_path . $fileName, PHP_EOL . $log, FILE_APPEND);
        }
    }
}