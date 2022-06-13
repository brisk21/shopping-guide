<?php


namespace app\admin\controller\system;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\service\ConfigService;
use app\service\DiyLog;
use app\service\Mailer;
use think\Cache;
use think\Log;

/**
 * 根据key区分不同的设置，谨慎操作
 * Class Index
 * @package app\admin\controller\system
 */
class Index extends Admin
{
    //邮箱配置
    public function email()
    {
        $conf = ConfigService::get('email');
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        return $this->fetch();
    }

    //邮箱配置更新
    public function email_action()
    {
        $rule = [
            ['type' => 'length', 'key' => 'host', 'rule' => '2,80', 'msg' => '发送域名未设置',],
            ['type' => 'empty', 'key' => 'username', 'rule' => '', 'msg' => '发送账号未设置',],
            ['type' => 'empty', 'key' => 'pwd', 'rule' => '', 'msg' => '发送授权密码未设置',],
            ['type' => 'empty', 'key' => 'port', 'rule' => '', 'msg' => '端口号未设置',],
            ['type' => 'empty', 'key' => 'encryption', 'rule' => '', 'msg' => '加密方式未选择',],
        ];
        $check = check_param($this->param, $rule);
        if ($check['code'] <> 0) {
            data_return($check['msg'], $check['code']);
        }
        $data = [
            'host' => trim($this->param['host']),
            'username' => trim($this->param['username']),
            'nickname' => trim($this->param['nickname']),
            'pwd' => trim($this->param['pwd']),
            'port' => trim($this->param['port']),
            'isHtml' => intval($this->param['isHtml']),
            'encryption' => trim($this->param['encryption']),
        ];
        $key = 'email';
        ConfigService::action($key, $data);
        parent::add_admin_log(['title' => '操作邮件配置', 'content' => $data]);
        data_return('保存成功');
    }

    //测试发送
    public function email_test()
    {
        if (empty($this->param['email']) || !is_email($this->param['email'])) {
            data_return('请输入测试邮箱', -1);
        }

        $data = [
            'to' => trim($this->param['email']),
            'title' => '世上无难事只怕有心人',
            'content' => '有没有收到数据，发送时间：' . date('Y-m-d H:i:s')
        ];
        $res = Mailer::send($data);
        if ($res['code'] == 0) {
            data_return($res['msg'], 0);
        }
        data_return($res['msg'], -1);
    }

    //网站
    public function web()
    {
        $conf = ConfigService::get('web');
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        return $this->fetch();
    }

    //网站配置更新
    public function web_action()
    {
        $rule = [
            ['type' => 'length', 'key' => 'title', 'rule' => '2,80', 'msg' => '后台标题未设置',],
            ['type' => 'empty', 'key' => 'enable_reg', 'rule' => '', 'msg' => '是否支持注册后台',],
            ['type' => 'empty', 'key' => 'sms_type', 'rule' => '', 'msg' => '请选择发送短信的厂商',],
        ];
        $check = check_param($this->param, $rule);
        if ($check['code'] <> 0) {
            data_return($check['msg'], $check['code']);
        }
        $data = [
            'enable_reg' => intval($this->param['enable_reg']),
            'title' => trim($this->param['title']),
            'sms_type' => trim($this->param['sms_type']),
            'upload_type' => !empty($this->param['upload_type']) ? trim($this->param['upload_type']) : 'local',
            'upload_fileSizeLimit' => !empty($this->param['upload_fileSizeLimit']) ? floatval($this->param['upload_fileSizeLimit']) : '4096',
            'upload_enable_type' => !empty($this->param['upload_enable_type']) ? str_replace(['，', ';', '；'], ',', strtolower($this->param['upload_enable_type'])) : '',
        ];
        $key = 'web';
        ConfigService::action($key, $data);

        parent::add_admin_log(['title' => '操作网站配置', 'content' => $data]);
        data_return('保存成功');
    }

    //支付
    public function pay()
    {
        $conf = ConfigService::get('wxpay');
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        return $this->fetch();
    }

    //支付配置更新
    public function pay_action()
    {
        $rule = [
            ['type' => 'empty', 'key' => 'app_id', 'rule' => '2,80', 'msg' => '公众号APPID未设置',],
            ['type' => 'empty', 'key' => 'mch_id', 'rule' => '2,80', 'msg' => '支付商户id未设置',],
            ['type' => 'empty', 'key' => 'mch_key', 'rule' => '2,80', 'msg' => '支付商户秘钥未设置',],
        ];
        $check = check_param($this->param, $rule);
        if ($check['code'] <> 0) {
            data_return($check['msg'], $check['code']);
        }
        $data = [
            'app_id' => trim($this->param['app_id']),
            'mch_id' => trim($this->param['mch_id']),
            'mch_key' => trim($this->param['mch_key']),
            'cert_pem' => !empty($this->param['cert_pem']) ? $this->param['cert_pem'] : '',
            'key_pem' => !empty($this->param['cert_pem']) ? $this->param['key_pem'] : '',
        ];
        $key = 'wxpay';
        ConfigService::action($key, $data);
        parent::add_admin_log(['title' => '操作微信支付配置', 'content' => $data]);
        data_return('保存成功');
    }

    //短信
    public function sms()
    {
        $conf = ConfigService::get('sms');
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        return $this->fetch();
    }

    //短信操作
    public function sms_action()
    {
        if (empty($this->param['from'])) {
            data_return('操作厂商有误', -1);
        }
        $key = 'sms';
        $conf = ConfigService::get($key, true);
        $from = trim($this->param['from']);
        if ($from == 'yunpian') {
            $rule = [
                ['type' => 'empty', 'key' => 'sms_tpl', 'rule' => '2,80', 'msg' => '通用验证码模板未填写内容',],
                ['type' => 'empty', 'key' => 'api_key', 'rule' => '2,80', 'msg' => '云片后台的apikey未设置',],
            ];
            $check = check_param($this->param, $rule);
            if ($check['code'] <> 0) {
                data_return($check['msg'], $check['code']);
            }
            $conf['yunpian'] = [
                'sms_tpl' => trim($this->param['sms_tpl']),
                'api_key' => trim($this->param['api_key'])
            ];
            ConfigService::action($key, $conf);
            parent::add_admin_log(['title' => '操作云片短信配置', 'content' => $this->param]);
            data_return('云片操作-保存成功');
        } elseif ($from == 'aliyun') {
            $rule = [
                ['type' => 'empty', 'key' => 'accessKeyId', 'rule' => '2,80', 'msg' => 'accessKeyId未填写内容',],
                ['type' => 'empty', 'key' => 'accessKeySecret', 'rule' => '2,80', 'msg' => 'accessKeySecret未填写内容',],
                ['type' => 'empty', 'key' => 'sms_id', 'rule' => '2,80', 'msg' => '模板ID未设置',],
                ['type' => 'empty', 'key' => 'sms_sign', 'rule' => '2,80', 'msg' => '短信签名没填写',],
            ];
            $check = check_param($this->param, $rule);
            if ($check['code'] <> 0) {
                data_return($check['msg'], $check['code']);
            }
            $conf['aliyun'] = [
                'accessKeyId' => trim($this->param['accessKeyId']),
                'accessKeySecret' => trim($this->param['accessKeySecret']),
                'sms_id' => trim($this->param['sms_id']),
                'sms_sign' => trim($this->param['sms_sign']),
            ];
            ConfigService::action($key, $conf);
            parent::add_admin_log(['title' => '操作阿里云短信配置', 'content' => $this->param]);
            data_return('阿里云操作-保存成功');
        } else {
            //todo 兼容其他类型
            data_return('暂不支持的商户类型', -1);
        }

    }

    //缓存配置
    public function cache_set()
    {
        $data = [
            'opcache' => [
                'name' => 'opcache',
                'status' => false,
            ],
            'memcached' => [
                'name' => 'memcached',
                'status' => false,
            ],
            'redis' => [
                'name' => 'redis',
                'status' => false,
            ]
        ];
        if (extension_loaded('Zend OPcache')) {
            $data['opcache']['status'] = true;
        }
        if (extension_loaded('redis')) {
            $data['redis']['status'] = true;
        }
        if (extension_loaded('memcached')) {
            $data['memcached']['status'] = true;
        }


        $this->assign('data', $data);

        return $this->fetch();
    }

    //模板缓存清理
    public function del_cache_tpl()
    {
        //模板缓存清理
        $tempPath = glob(TEMP_PATH . '*.php');
        array_map('unlink', $tempPath);
        data_return('清理完成');
    }

    //仅清理日志
    public function del_cache_log()
    {
        //内存中的
        Log::clear();
        //本地文件的
        del_dir(LOG_PATH);
        data_return('清理完成');
    }

    //数据缓存
    public function del_cache_data()
    {
        //缓存清理
        Cache::clear();
        data_return('清理完成');
    }


    //opcache
    public function del_cache_opcache()
    {
        if (extension_loaded('Zend OPcache') && function_exists('opcache_reset')) {
            opcache_reset();
        }
        data_return('清理完成');
    }

    //IP黑名单
    public function ip_blacklist()
    {
        $conf = ConfigService::get('ip_blacklist', 1);
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        $limit_ips = ConfigService::get('request_limit_ips', 1);
        if (!empty($limit_ips)) {
            $this->assign('limitData', $limit_ips);
        }

        return $this->fetch();
    }

    //操作IP黑名单
    public function ip_blacklist_action()
    {
        $ac = !empty($this->param['ac']) ? trim($this->param['ac']) : '';
        if (empty($ac) || !in_array($ac, ['add', 'del'])) {
            data_return('暂不支持的操作', -1);
        }
        $ip = !empty($this->param['ip']) ? $this->param['ip'] : '';
        $conf = ConfigService::get('ip_blacklist');
        if ($ac == 'del') {
            if (!empty($conf)) {
                $conf = array_flip($conf);
                if (isset($conf[$ip])) {
                    unset($conf[$ip]);
                }
                $conf = array_flip($conf);
            }
        } else {
            if (!is_ip($ip)) {
                data_return('IP格式不合法' . $ip, -1);
            }
            if (!empty($conf)) {
                $conf = array_unique(array_merge($conf, [$ip]));
            } else {
                $conf = [$ip];
            }

            //来自可疑名单更新
            if (!empty($this->param['f']) && $this->param['f'] === 'limit_list' && (!empty($this->param['type']) && $this->param['type'] == 'remove')) {
                $limit_ips = ConfigService::get('request_limit_ips');
                if (!empty($limit_ips)) {
                    $limit_ips = array_flip($limit_ips);
                    if (isset($limit_ips[$ip])) {
                        unset($limit_ips[$ip]);
                    }
                    $limit_ips = array_flip($limit_ips);
                    ConfigService::action('request_limit_ips', $limit_ips);
                }
                data_return('ok');
            }


        }
        $data = $conf;
        $key = 'ip_blacklist';
        ConfigService::action($key, $data);
        //来自可疑名单更新
        if (!empty($this->param['f']) && $this->param['f'] === 'limit_list') {
            $limit_ips = ConfigService::get('request_limit_ips');
            if (!empty($limit_ips)) {
                $limit_ips = array_flip($limit_ips);
                if (isset($limit_ips[$ip])) {
                    unset($limit_ips[$ip]);
                }
                $limit_ips = array_flip($limit_ips);
                ConfigService::action('request_limit_ips', $limit_ips);
            }
        }

        parent::add_admin_log(['title' => '操作IP黑名单', 'content' => $this->param]);
        data_return('ok');
    }

    //安全设置
    function safe()
    {
        $conf = ConfigService::get('web_safe', 1);
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        return $this->fetch();
    }

    //保存安全配置
    public function safe_action()
    {
        $count = !empty($this->param['api_limit_set_second']) ? max(0, $this->param['api_limit_set_second']) : 0;
        $sensitive_words = !empty($this->param['sensitive_words']) ? 1 : 0;
        $data = [
            'api_limit_set_second' => $count,
            'sensitive_words' => $sensitive_words,
        ];
        $key = 'web_safe';
        ConfigService::action($key, $data);
        parent::add_admin_log(['title' => '操作安全配置', 'content' => $data]);
        data_return('操作成功');
    }

    //上传配置
    public function upload()
    {
        $conf = ConfigService::get('upload', 1);
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        return $this->fetch();
    }

    public function upload_action()
    {
        if (empty($this->param['from'])) {
            data_return('操作厂商有误', -1);
        }
        $key = 'upload';
        $conf = ConfigService::get($key, true);
        $from = trim($this->param['from']);
        if ($from == 'qiniu') {
            $rule = [
                ['type' => 'empty', 'key' => 'accessKey', 'rule' => '2,80', 'msg' => 'accessKey必填',],
                ['type' => 'empty', 'key' => 'secretKey', 'rule' => '2,80', 'msg' => 'secretKey必填',],
                ['type' => 'empty', 'key' => 'bucket', 'rule' => '2,80', 'msg' => 'bucket必填',],
                ['type' => 'empty', 'key' => 'domain', 'rule' => '2,80', 'msg' => '域名必填',],
            ];
            $check = check_param($this->param, $rule);
            if ($check['code'] <> 0) {
                data_return($check['msg'], $check['code']);
            }
            $conf['qiniu'] = [
                'accessKey' => trim($this->param['accessKey']),
                'secretKey' => trim($this->param['secretKey']),
                'bucket' => trim($this->param['bucket']),
                'domain' => trim($this->param['domain']),
            ];
            ConfigService::action($key, $conf);
            parent::add_admin_log(['title' => '操作七牛云配置', 'content' => $this->param]);
            data_return('七牛云操作-保存成功');
        } elseif ($from == 'oss') {
            $rule = [
                ['type' => 'empty', 'key' => 'accessKeyId', 'rule' => '2,80', 'msg' => 'accessKeyId未填写内容',],
                ['type' => 'empty', 'key' => 'accessKeySecret', 'rule' => '2,80', 'msg' => 'accessKeySecret未填写内容',],
                ['type' => 'empty', 'key' => 'endpoint', 'rule' => '2,80', 'msg' => 'endpoint未填写内容',],
                ['type' => 'empty', 'key' => 'domain', 'rule' => '2,80', 'msg' => '域名未设置',],
            ];
            $check = check_param($this->param, $rule);
            if ($check['code'] <> 0) {
                data_return($check['msg'], $check['code']);
            }
            $conf['oss'] = [
                'accessKeyId' => trim($this->param['accessKeyId']),
                'accessKeySecret' => trim($this->param['accessKeySecret']),
                'endpoint' => trim($this->param['endpoint']),
                'domain' => trim($this->param['domain']),
                'bucket' => trim($this->param['bucket']),
            ];
            ConfigService::action($key, $conf);
            parent::add_admin_log(['title' => '操作阿里云OSS配置', 'content' => $this->param]);
            data_return('阿里云OSS操作-保存成功');
        } else {
            //todo 兼容其他类型
            data_return('暂不支持的商户类型', -1);
        }
    }

    //物流配送
    public function express()
    {
        $conf = ConfigService::get('express', 1);
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        return $this->fetch();
    }

    public function express_action()
    {
        if (empty($this->param['from'])) {
            data_return('操作表单目标有误', -1);
        }
        $key = 'express';
        $conf = ConfigService::get($key, true);
        $from = trim($this->param['from']);
        $pt = !empty($this->param['pt']) ? trim($this->param['pt']) : 'aliyun';
        if ($from == 'express') {
            $rule = [
                ['type' => 'empty', 'key' => 'appcode', 'rule' => '2,80', 'msg' => 'appcode必填',],
            ];
            $check = check_param($this->param, $rule);
            if ($check['code'] <> 0) {
                data_return($check['msg'], $check['code']);
            }
            $conf['pt'] = $pt;
            $conf['aliyun'] = [
                'appcode' => trim($this->param['appcode']),
            ];
            ConfigService::action($key, $conf);
            parent::add_admin_log(['title' => '操作物流配置', 'content' => $this->param]);
            data_return('保存成功');
        }
        data_return('未知表单', -1);
    }

    //微信配置
    public function wechat()
    {
        $conf = ConfigService::get('wechat', 1);
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        return $this->fetch();
    }

    public function wechat_action()
    {
        if (empty($this->param['from'])) {
            data_return('操作表单目标有误', -1);
        }
        $key = 'wechat';
        $conf = ConfigService::get($key, true);
        $from = trim($this->param['from']);
        if ($from == 'wechat') {
            $rule = [
                ['type' => 'empty', 'key' => 'appid', 'rule' => '2,80', 'msg' => 'appid必填',],
                ['type' => 'empty', 'key' => 'appSecret', 'rule' => '2,80', 'msg' => 'appSecret必填',],
                ['type' => 'empty', 'key' => 'pt', 'rule' => '2,80', 'msg' => '平台未选择',],
            ];
            $check = check_param($this->param, $rule);
            if ($check['code'] <> 0) {
                data_return($check['msg'], $check['code']);
            }

            $conf['gzh'] = [
                'appid' => trim($this->param['appid']),
                'appSecret' => trim($this->param['appSecret']),
                'pt' => trim($this->param['pt']),
                'akey' => trim($this->param['akey']),
                'userinfo' => !empty($this->param['userinfo']) ? 1 : 0,
            ];
            ConfigService::action($key, $conf);
            parent::add_admin_log(['title' => '操作物公众号', 'content' => $this->param]);
            data_return('保存成功');
        }
        data_return('未知表单', -1);
    }
}