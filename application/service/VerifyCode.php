<?php


namespace app\service;

use app\common\common;
use app\common\controller\AppCommon;
use Yunpian\Sdk\YunpianClient;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;

/**
 * 验证码类
 * Class VerifyCode
 * @package app\service
 */
class VerifyCode
{
    /**
     * 发送验证码
     * @param $account string 手机号或者邮箱
     * @return array
     */
    public static function send($account)
    {
        if (!is_phone($account) && !is_email($account)) {
            return ['code' => -1, 'msg' => '仅支持手机号或者邮箱'];
        }
        $code = rand(100000, 999999);
        if (is_email($account)) {
            $data = [
                'to' => trim($account),
                'title' => '动态码',
                'content' => '您的动态码为：' . $code . '，如非本人操作，请忽略。'
            ];
            $res = Mailer::send($data);
            if ($res['code'] <> 0) {
                return $res;
            }
            self::add_log([
                'type' => 1,//0-手机，1-邮箱
                'code' => $code,
                'account' => $account,
            ]);
            return ['code' => 0, 'msg' => '发送成功'];
        } else {
            if (\config('sms.is_tester')){
                self::add_log([
                    'type' => 0,//0-手机，1-邮箱
                    'code' => 123456,
                    'account' => $account,
                ]);
                return ['code' => 0, 'msg' => '发送成功'];
            }
            $webConf = ConfigService::get('web');
            if (empty($webConf['sms_type'])) {
                return ['code' => -1, 'msg' => '未配置发送短信厂商'];
            }

            $has = self::get($account);
            //每分钟发送一条
            if (!empty($has) && ($has['add_time'] + 60 > time())) {
                return ['code' => -1, 'msg' => ($has['add_time'] + 60 - time()) . '秒后可再次发送'];
            }
            //todo 扩展其他云厂商
            $smsConf = ConfigService::get('sms');
            if ($webConf['sms_type'] == 'yunpian') {
                if (empty($smsConf['yunpian']['api_key'])) {
                    return ['code' => -1, 'msg' => '短信验证码未配置'];
                }
                $apikey = trim($smsConf['yunpian']['api_key']);

                //初始化client,apikey作为所有请求的默认值
                $client = YunpianClient::create($apikey);
                $smsTpl = str_replace('#code#', $code, $smsConf['yunpian']['sms_tpl']);
                $param = [
                    YunpianClient::MOBILE => $account,
                    YunpianClient::TEXT => $smsTpl
                ];
                $ret = $client->sms()->single_send($param);

                if (!$ret->isSucc() || $ret->code() <> 0) {
                    common::add_log('云短信发送失败',$ret);
                    return ['code' => -1, 'msg' => '短信验证码发送失败'];
                }
                self::add_log([
                    'type' => 0,//0-手机，1-邮箱
                    'code' => $code,
                    'account' => $account,
                ]);
                return ['code' => 0, 'msg' => '发送成功'];
            } elseif ($webConf['sms_type'] == 'aliyun') {
                if (empty($smsConf['aliyun'])) {
                    return ['code' => -1, 'msg' => '未配置阿里云短信'];
                }
                $conf = $smsConf['aliyun'];
                $argv = [
                    'PhoneNumbers' => $account,
                    'SignName' => $conf['sms_sign'],
                    'TemplateCode' => $conf['sms_id'],
                ];
                $client = self::aliyun_createClient($conf['accessKeyId'], $conf['accessKeySecret']);
                $sendSmsRequest = new SendSmsRequest($argv);

                $ret = $client->sendSms($sendSmsRequest)->toMap();
                if (!empty($ret['body']['Code']) && strtolower($ret['body']['Code']) == 'ok') {
                    self::add_log([
                        'type' => 0,//0-手机，1-邮箱
                        'code' => $code,
                        'account' => $account,
                    ]);
                    return ['code' => 0, 'msg' => '发送成功'];
                } else {
                    return ['code' => -1, 'msg' => '阿里云短信发送失败'];
                }
            }

            return ['code' => -1, 'msg' => '发送短信配置厂商不支持'];
        }
    }

    /**
     * 使用AK&SK初始化账号Client
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return Dysmsapi Client
     */
    public static function aliyun_createClient($accessKeyId, $accessKeySecret)
    {
        $config = new Config([
            // 您的AccessKey ID
            "accessKeyId" => $accessKeyId,
            // 您的AccessKey Secret
            "accessKeySecret" => $accessKeySecret
        ]);
        // 访问的域名
        $config->endpoint = "dysmsapi.aliyuncs.com";
        return new Dysmsapi($config);
    }


    /**
     * 获取最新一条
     * @param $account
     * @return array|bool|null
     */
    public static function get($account)
    {
        return AppCommon::data_get('verify_code_log', ['account' => $account], '*', 'id desc');
    }

    /**
     * 检测验证码
     * @param $account
     * @param $code
     * @return array
     */
    public static function check_code($account, $code)
    {
        $data = self::get($account);
        if (empty($data)) {
            return ['code' => -1, 'msg' => '请先获取动态码'];
        } elseif ($data['code'] <> $code) {
            return ['code' => -1, 'msg' => '动态码不正确'];
        } elseif ($data['add_time'] + 300 < time()) {
            return ['code' => -1, 'msg' => '动态码已过期'];
        }
        return ['code' => 0, 'msg' => 'ok'];
    }

    private static function add_log($data)
    {
        $data['add_time'] = time();
        return AppCommon::data_add('verify_code_log', $data);
    }
}