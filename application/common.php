<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use app\common\controller\AppCommon;

/**
 * @param string $msg
 * @param int $code
 * @param array $data
 * @param bool $exit
 * @return array|void
 */
function data_return($msg = '操作成功', $code = 0, $data = [], $exit = true)
{
    $ret = [
        'code' => $code,
        'msg' => $msg,
        'data' => $data
    ];
    if ($exit) {
        exit(json_encode($ret, JSON_UNESCAPED_UNICODE));
    }
    return $ret;
}

/**
 * @param string $msg
 * @param int $code
 * @param array $data
 * @return array
 */
function data_return_arr($msg = '操作成功', $code = 0, $data = [])
{
    $ret = [
        'code' => $code,
        'msg' => $msg,
        'data' => $data
    ];
    return $ret;
}

/**
 * 生成随机字符串
 * @param $length integer 字符串长度
 * @param false $numeric 是否纯数字
 * @return string
 */
function get_random($length, $numeric = FALSE)
{
    $seed = base_convert(md5(microtime(true) . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
    if ($numeric) {
        $hash = '';
    } else {
        $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
        $length--;
    }
    $max = strlen($seed) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $seed{mt_rand(0, $max)};
    }
    return $hash;
}

/**
 * 获取IP
 * @return mixed
 */
function get_ip()
{
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    if (isset($_SERVER['HTTP_CDN_SRC_IP'])) {
        $ip = $_SERVER['HTTP_CDN_SRC_IP'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] as $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    }
    return $ip;
}

/**
 * 数据验证
 * @param $data array 需要验证的数组对象
 * @param $rules array 规则
 * @return array
 * @author blog.alipay168.cn
 */
function check_param(&$data, $rules)
{
    if (empty($data) || !is_array($data) || empty($rules) || !is_array($rules)) {
        return ['code' => -500, 'msg' => '数据或者规则为空'];
    }
    foreach ($rules as $value) {
        if (empty($value['key']) || empty($value['msg']) || empty($value['type'])) {
            return ['code' => -500, 'msg' => '内部错误'];
        }
        switch (strtolower($value['type'])) {
            case 'length':
                if (empty($value['rule'])) {
                    return ['code' => -500, 'msg' => '内部错误'];
                }
                if (!isset($data[$value['key']])) {
                    return ['code' => -500, 'msg' => '内部错误:' . $value['key'] . '未设置'];
                }
                $rule = explode(',', $value['rule']);
                $length = mb_strlen($data[$value['key']]);
                if (count($rule) == 1) {
                    //固定长度
                    if ($length <> intval($rule[0])) {
                        return ['code' => -1, 'msg' => $value['msg']];
                    }
                } else {
                    //长度区间
                    if ($length < intval($rule[0]) || $length > intval($rule[1])) {
                        return ['code' => -1, 'msg' => $value['msg']];
                    }
                }
                break;
            case 'empty':
                if (empty($data[$value['key']])) {
                    return ['code' => -1, 'msg' => $value['msg']];
                }
                break;
            case 'isset':
                if (!isset($data[$value['key']])) {
                    return ['code' => -1, 'msg' => $value['msg']];
                }
                break;
            case 'in_array':
                if (empty($value['rule']) || !is_array($value['rule'])) {
                    return ['code' => -500, 'msg' => '内部错误'];
                }

                if (!in_array($data[$value['key']], $value['rule'])) {
                    return ['code' => -1, 'msg' => $value['msg']];
                }

                break;
            case 'func':
            case 'function':
                if (!is_callable($value['rule'])) {
                    return ['code' => -500, 'msg' => '内部错误'];
                }
                if (!isset($data[$value['key']]) || !$value['rule']($data[$value['key']])) {

                    return ['code' => -1, 'msg' => $value['msg']];
                }
                break;
            case 'min':
                if (!isset($data[$value['key']]) || intval($data[$value['key']]) < intval($value['rule'])) {
                    return ['code' => -1, 'msg' => $value['msg']];
                }
                break;
            case 'max':
                if (!isset($data[$value['key']]) || intval($data[$value['key']]) > intval($value['rule'])) {
                    return ['code' => -1, 'msg' => $value['msg']];
                }
                break;
            default:
                //todo 其他扩展

        }
    }
    return ['code' => 0, 'msg' => 'ok'];
}

//通用返回父类和子类分类树，树形，php tree
//getTree($data,'category_id','parent_id');

function tree($arr, $id = 'id', $fid = 'fid', $child_name = 'children')
{
    $refer = array();
    $tree = array();
    foreach ($arr as $k => $v) {
        $refer[$v[$id]] = &$arr[$k]; //创建主键的数组引用
    }
    foreach ($arr as $k => $v) {
        $pid = $v[$fid]; //获取当前分类的父级id
        if ($pid == 0) {
            $tree[] = &$arr[$k]; //顶级栏目
        } else {
            if (isset($refer[$pid])) {
                $refer[$pid][$child_name][] = &$arr[$k]; //如果存在父级栏目，则添加进父级栏目的子栏目数组中
            }
        }
    }
    return $tree;
}

//判断访问的终端
function fromClient()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
        return "weixin";
    } elseif (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient')) {
        return "alipay";
    } elseif (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'QQ')) {
        return "qq";
    } else if (!isMobile()) {
        return 'pc';
    } else {
        return 'other';
    }
}


/*移动端判断*/
function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia',
            'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel',
            'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce',
            'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;

}

/**
 * 打印数据
 * @param $data
 * @param bool $hide
 */
function view_data($data, $hide = false)
{
    if ($hide) {
        echo '<!--';
        print_r($data);
        echo '-->';
    } else {
        print_r($data);
    }
}

//浏览器控制台调试
function view_data_console($data)
{
    if (is_object($data) || is_array($data)) {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    $js = '<script >console.log(' . $data . ')</script>';
    echo $js;
}

/**
 * @param $str
 * @return bool
 */
function is_url($str)
{
    $pattern = "#(http|https)://(.*\.)?.*\..*#i";
    if (preg_match($pattern, $str)) {
        return true;
    } else {
        return false;
    }
}

/***
 * 随机生成数字
 * @param int $length
 * @return string
 */
function getNumberCode($length = 6)
{
    $code = '';
    for ($i = 0; $i < intval($length); $i++) $code .= rand(1, 9);
    return $code;
}

/**
 * 隐藏部分字符串,比如隐藏手机中间4位，用*号代表：str_hidden(13500000000,3,4,'****');//135****0000
 * @param $str string 要处理的字符串
 * @param $start int 开始位置
 * @param $length int 处理长度
 * @param string $replaceTo 替换后的字符串
 * @return mixed
 */

function str_hidden($str, $start, $length, $replaceTo = '****')
{
    return substr_replace($str, $replaceTo, $start, $length);
}

/**
 * 支持中文的字符串截取
 * @param $str
 * @param $start
 * @param $length
 * @param null $enc
 * @return string
 */
function str_mb_hidden($str, $start, $length, $enc = null)
{
    return mb_substr($str, $start, $length, $enc = null);
}

/**
 * 截取字符串
 * @param $str
 * @param $length
 * @param int $start
 * @return string
 */
function str_cut($str, $length, $start = 0)
{
    return mb_substr($str, $start, $length, 'utf-8');
}


/**
 * 获取设备类型
 * @return string
 */
function get_device_type()
{
    //全部变成小写字母
    $agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
    $type = 'other';
    //分别进行判断
    if (strpos($agent, 'iphone') || strpos($agent, 'ipad')) {
        $type = 'ios';
    }

    if (strpos($agent, 'android')) {
        $type = 'android';
    }
    return $type;
}

/**
 * 是否是手机号
 * @param $mobile
 * @return bool
 */
function is_phone($mobile)
{
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match('#^1[3,4,5,7,8,9]{1}[\d]{9}$#', $mobile) ? true : false;
}


/**
 * 判断是否属于uid
 * @param $str
 * @return bool
 */
function is_uid($str)
{
    if (stripos($str, 'bs') !== false && mb_strlen($str) === 34) {
        return true;
    }
    return false;
}

/**
 * 是否为邮箱
 * @param $email
 * @return bool
 */
function is_email($email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($email, '@') !== false && strpos($email, '.') !== false) {
        if (preg_match($chars, $email)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }

}

/**
 * 删除目录
 * @param $dirName
 */
function del_dir($dirName)
{
    if (is_dir($dirName)) {
        $dir = opendir($dirName);
        while ($fileName = readdir($dir)) {
            if ($fileName != "." && $fileName != "..") {
                $file = $dirName . "/" . $fileName;
                if (is_dir($file)) {
                    del_dir($file);
                } else {
                    @unlink($file);
                }
            }
        }
        closedir($dir);
        //删除目录
        rmdir($dirName);
    }
}


/**
 * 判断IP输入是否合法
 * @param string $ip IP地址
 * @return bool
 */
function is_ip($ip)
{
    if (preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name)
{
    $result = false;
    if (is_dir($dir_name)) {
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {

                        unlink($dir_name . DS . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }
    return $result;
}

/**
 * 获取表全名
 * @param $table
 * @return string
 */
function table_name($table)
{
    $prefix = config('database.prefix');
    return $prefix . $table;
}

/**
 * 封装curl的调用接口，post的请求方式
 * @param $url
 * @param $requestString
 * @param int $timeout
 * @return bool|mixed
 */
function curl_post_request($url, $requestString, $timeout = 5)
{
    if ($url == "" || $requestString == "" || $timeout <= 0) {
        return false;
    }
    $con = curl_init((string)$url);
    curl_setopt($con, CURLOPT_HEADER, false);
    curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
    curl_setopt($con, CURLOPT_POST, true);
    curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
    curl_setopt($con, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名,0不验证
    curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
    return curl_exec($con);
}

/**
 * 新增post请求
 * @param $url
 * @param $post_data
 * @param int $timeout
 * @return bool|string
 */
function curl_post_request_array($url, $post_data, $timeout = 10)
{
    $con = curl_init();
    curl_setopt($con, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($con, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($con, CURLOPT_POST, 1);
    curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
    curl_setopt($con, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名,0不验证
    //请求时间
    //设置header信息

    curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
    $res = curl_exec($con);
    //print_r(curl_error($con));
    curl_close($con);
    return $res;
}

/**
 * 封装curl的调用接口，get的请求方式
 * @param $url
 * @param array $data
 * @param int $timeout
 * @param array $headers
 * @return bool|mixed
 */
function curl_get_request($url, $data = array(), $timeout = 10, $headers = [])
{
    if ($url == "" || $timeout <= 0) {
        return false;
    }
    if ($data != array()) {
        $url = $url . '?' . http_build_query($data);
    }
    $con = curl_init((string)$url);
    curl_setopt($con, CURLOPT_HEADER, false);
    curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
    curl_setopt($con, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名,0不验证
    if (!empty($headers)) {
        curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
    return curl_exec($con);
}

/**
 * 移除url的某个参数
 * @param $url
 * @param $keys array|string 需要移除的一个或者多个参数
 * @return string
 * @example $url = 'https://wei1.top?a=1&b=2&user=cccc&x=ad';
 *          $newUrl = remove_query_var($url,'user');
 *          echo $newUrl;//https://wei1.top?a=1&b=2&x=ad
 */
function remove_query_var($url, $keys)
{
    $url = parse_url($url);
    if (!empty($url['query'])) {
        parse_str($url['query'], $arr);
        if (is_array($keys)) {
            foreach ($keys as $key) {
                if (isset($arr[$key])) {
                    unset($arr[$key]);
                }
            }
        } else {
            if (isset($arr[$keys])) {
                unset($arr[$keys]);
            }
        }
        $url = $url['scheme'] . '://' . $url['host'] . (isset($url['port']) ? ':' . $url['port'] : '') . $url['path'] . '?' . http_build_params($arr);
    }
    return $url;
}

/**数组拼接
 * @param $params
 * @return string
 */
function http_build_params($params)
{
    if (empty($params) || !is_array($params)) {
        return '';
    }
    $str = '&';
    foreach ($params as $k => $v) {
        $str .= "&$k=$v";
    }
    return str_replace('&&', '', $str);
}

/**
 * 判断插件是否存在
 * @param $tag
 * @return bool
 */
function bs_p($tag)
{
    if (!$tag) {
        return false;
    }
    if (!file_exists(APP_PATH . 'plugin/controller/' . strtolower($tag) . '/config.json')) {
        return false;
    }
    $has = AppCommon::data_get('plugins', ['plugin_tag' => $tag], 'id,disable');
    if (empty($has['id']) || !empty($has['disable'])) {
        return false;
    }
    return true;
}

/**
 * 当前登录是否为超级超级管理
 * @return bool
 */
function is_root_role()
{
    $admin_uid = session('admin_uid', '', 'bs_admin_');
    if (empty($admin_uid)) {
        return false;
    }

    $admin_info = AppCommon::data_get('admin', ['uid' => $admin_uid], 'account,role_id,uid,status');
    if (empty($admin_info) || $admin_info['status'] <> 1) {
        return false;
    }
    //创始人或者超级管理角色
    if ($admin_info['role_id'] <> 0 && $admin_info['role_id'] <> 1) {
        return false;
    }
    return true;
}

/**
 * 缓存状态监测
 * @param $type
 * @return bool
 */
function cache_service_check($type)
{
    static $handler;
    //2分钟检查一次，不用每个请求都连接一次
    $expire = 120;
    $key = 'cache_service_check_' . $type;
    if (!empty($handler[$type])) {
        return true;
    }
    $c = cache($key);
    if ($c) {
        return $c == 1;
    }

    if (!in_array($type, ['redis', 'memcache', 'memcached'])) {
        if ($type == 'default') {
            //默认用文件系统
            cache($key, 1, $expire);
            return true;
        }
        cache($key, -1, $expire);
        return false;
    }
    if (!extension_loaded(strtolower($type))) {
        cache($key, -1, $expire);
        return false;
    }
    $class = ucfirst($type);
    if (!class_exists($class)) {
        cache($key, -1, $expire);
        return false;
    }
    // 获取默认缓存配置，并连接
    $options = \think\Config::get('cache.' . $type);
    if (empty($options)) {
        cache($key, -1, $expire);
        return false;
    }

    try {
        $handler[$type] = \think\Cache::connect($options);
    } catch (Exception $e) {
        cache($key, -1, $expire);
        return false;
    }
    cache($key, 1, $expire);
    return true;
}

/**
 * 用fsockopen异步请求发送数据
 * @param $url
 * @param array $data
 * @param string $method
 * @return array|int[]
 * @author blog.alipay168.cn
 */
function sock_request($url, $data = [], $method = 'POST')
{
    $method = strtoupper($method);
    $parse = parse_url($url);
    $host = $parse['host'];
    $port = !empty($parse['port']) ? intval($parse['port']) : 80;
    $path = !empty($parse['path']) ? trim($parse['path']) : '';
    $scheme = !empty($parse['scheme']) ? trim($parse['scheme']) : '';
    $fp = fsockopen($host, $port, $error_code, $error_msg, 1);
    if (!$fp) {
        return array('code' => $error_code, 'msg' => $error_msg);
    }
    $query_str = '';
    if ($data) {
        $query_str = is_array($data)? http_build_query($data):$data;
    }
    ////阻塞模式:0-非阻塞，1-阻塞
    stream_set_blocking($fp, 0);
    //超时时间
    stream_set_timeout($fp, 1);

    if ($method=='GET'){
        $con =  "GET $path?$query_str HTTP/1.1\r\n";
        $con .= "Host: $host\r\n";
        $con .= "Connection: close\r\n\r\n";//长连接关闭
    }else{
        $con =  "POST $path HTTP/1.1\r\n";
        $con .= "Host: $host\r\n";
        //类型自定义,下面的方式可以用$_POST获取
        //  $con .="Content-Type: application/x-www-form-urlencoded\r\n";
        $con .="Content-Length:".strlen($query_str)."\r\n\r\n";
        //post内容
        $con .="$query_str\r\n";
        $con .= "Connection: close\r\n\r\n";//长连接关闭

    }
    fwrite($fp, $con);
    //修复nginx请求不成功问题
    usleep(1000);
    fclose($fp);
    //输出字符串
    //echo $con;
    return array('code' => 0);
}
