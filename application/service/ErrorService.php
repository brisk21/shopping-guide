<?php


namespace app\service;


use app\common\controller\AppCommon;
use Exception;
use think\exception\ErrorException;
use think\exception\ThrowableError;

use think\Lang;

define('DEBUG_LOG_TMP_PATH', LOG_PATH . 'debuglog/');

class ErrorService extends Exception
{
    public static $savePath = DEBUG_LOG_TMP_PATH;

    // 构造函数
    public function __construct()
    {
        parent::__construct();
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);
        set_error_handler([__CLASS__, 'appError']);
        set_exception_handler([__CLASS__, 'appException']);
        register_shutdown_function([__CLASS__, 'appShutdown']);
    }

    /**
     * 捕获异常
     * @param bool $catch
     * @return false|void
     */
    public static function catch_error($catch = true)
    {
        if (!$catch) {
            return false;
        }
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);
        set_error_handler([__CLASS__, 'appError']);
        set_exception_handler([__CLASS__, 'appException']);
        register_shutdown_function([__CLASS__, 'appShutdown']);
    }

    /**
     * 错误处理
     * @access public
     * @param integer $errno 错误编号
     * @param integer $errstr 详细错误信息
     * @param string $errfile 出错的文件
     * @param integer $errline 出错行号
     * @return void
     * @throws ErrorException
     */
    public static function appError($errno, $errstr, $errfile = '', $errline = 0)
    {

        $exception = new ErrorException($errno, $errstr, $errfile, $errline);

        // 符合异常处理的则将错误信息托管至 think\exception\ErrorException
        if (error_reporting() & $errno) {
            throw $exception;
        }

        self::debug_log([$errno, $errstr, $errfile, $errline]);
    }

    /**
     * 异常处理
     * @access public
     * @param Exception $e 异常
     * @return void
     * @throws ErrorException
     */
    static function appException($e)
    {
        if (!$e instanceof Exception) {
            $e = new ThrowableError($e);
        }
        $data = [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => self::getErrMessage($e),
            'code' => self::getErrCode($e),
        ];
        self::debug_log($data);
    }

    /**
     * 获取错误编码
     */
    static function getErrCode(Exception $exception)
    {
        $code = $exception->getCode();
        if (!$code && $exception instanceof ErrorException) {
            $code = $exception->getSeverity();
        }
        return $code;
    }

    /**
     * 获取错误信息
     * ErrorException则使用错误级别作为错误编码
     * @param Exception $exception
     * @return string                错误信息
     */
    static function getErrMessage(Exception $exception)
    {
        $message = $exception->getMessage();
        if (IS_CLI) {
            return $message;
        }

        if (strpos($message, ':')) {
            $name = strstr($message, ':', true);
            $message = Lang::has($name) ? Lang::get($name) . strstr($message, ':') : $message;
        } elseif (strpos($message, ',')) {
            $name = strstr($message, ',', true);
            $message = Lang::has($name) ? Lang::get($name) . ':' . substr(strstr($message, ','), 1) : $message;
        } elseif (Lang::has($message)) {
            $message = Lang::get($message);
        }
        return $message;
    }

    /**
     * 异常中止处理
     * @access public
     * @return void
     */
    public static function appShutdown()
    {
        $error = error_get_last();
        if ($error) {
            // 写入日志
            self::debug_log(['error' => $error, 'error_time' => date('Y-m-d H:i:s')]);
        }
    }

    /**
     * 确定错误类型是否致命
     * @access protected
     * @param int $type 错误类型
     * @return bool
     */
    protected static function isFatal($type)
    {
        return in_array($type, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]);
    }

    /**
     * 添加日志
     * @param $content
     * @return false|int|string
     */
    public static function debug_log($content)
    {
        $content = empty($content) ? '' : is_array($content) ? json_encode($content, JSON_UNESCAPED_UNICODE) : $content;
        if (empty($content)) {
            return false;
        }
        //过滤
        if (stripos($content,'模块不存在')){
            return false;
        }
        $data = [
            'add_time' => time(),
            'content' => mb_substr($content, 0, 65535),
        ];
        return self::file_log( $data,'error_');
        return AppCommon::data_add('error_log', $data);
    }

    /**
     * 文件日志
     * @param string $content
     * @param string $logName
     * @param false $replace
     */
    public static function file_log($content = '', $logName = '', $replace = false)
    {

        $time = date('Y-m-d H:i:s');
        $log = var_export(array(
            'time' => $time,
            'content' => $content,
        ), true);
        self::$savePath = self::$savePath.date('Ym').'/';
        if (!is_dir(self::$savePath)) {
            @mkdir(self::$savePath, 0777, true);
        }
        if (is_dir(self::$savePath) && is_writable(self::$savePath)) {
            if ($logName) {
                $fileName = self::$savePath . $logName . date('d') . '.log';
            } else {
                $fileName = self::$savePath . date('d') . '.log';
            }
            if ($replace) {
                file_put_contents($fileName, $log);
            } else {
                file_put_contents($fileName, PHP_EOL . $log, FILE_APPEND);
            }
        }
    }


}