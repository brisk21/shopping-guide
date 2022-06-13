<?php


namespace base;


class Express
{
    private static $config;

    private static $pt;

    /**
     * 设置配置信息
     * @param $config
     */
    public static function set_config($config)
    {
        self::$config = $config;
    }

    /**
     * 设置平台
     * @param $pt
     */
    public static function set_pt($pt)
    {
        self::$pt = $pt;
    }

    /**
     * @param $expressNo string 物流单号
     * @param null $expressCom 快递公司
     * @param null $ext 扩展数据
     * @return array  成功返回demo： ['code'=>0,'msg'=>'ok','data'=>['list'=>[['time'=>'2021-12-26 11:12:46','status'=>'【广州市】快件已经到达【广州中心】']],'typename'=>'中通快递']]
     */
    public static function run($expressNo, $expressCom = null, $ext = null)
    {
        //阿里云接口
        if (self::$pt == 'aliyun') {
            $data = ['number' => trim($expressNo)];
            if ($expressCom) {
                //快递公司字母简写，不填96%能自动识别，填写查询会更快更准确
                $data['type'] = $expressCom;
            }
            if (!empty($ext['mobile'])) {
                //顺丰需填写收件人/寄件人手机号（后4位即可）
                $data['mobile'] = $ext['mobile'];
            }
            if (empty(self::$config['appcode'])) {
                return ['code' => -1, 'msg' => '阿里云物流接口配置错误'];
            }

            $host = "http://qyexpress.market.alicloudapi.com";
            $path = "/composite/queryexpress";
            $method = "GET";
            $appcode = self::$config['appcode'];
            $headers = array();
            array_push($headers, "Authorization:APPCODE " . $appcode);
            $querys = http_build_query($data);
            $bodys = "";
            $url = $host . $path . "?" . $querys;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_FAILONERROR, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            if (1 == strpos("$" . $host, "https://")) {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            }
            $res = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($res, true);
            if (!empty($res['resp']['RespCode'])){
                return ['code' => -1, 'msg' => $res['resp']['RespMsg']];
            }

            return ['code' => 0, 'msg' => 'ok','data' => $res['data']];
        }

        return ['code' => -1, 'msg' => '暂不支持其他平台接口'];
    }


}