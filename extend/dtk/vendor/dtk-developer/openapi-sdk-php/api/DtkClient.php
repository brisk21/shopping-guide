<?php

class DtkClient
{
    protected $appKey = '';
    protected $appSecret = '';
    protected $version = '';
    protected $timeout = 10;

    const HOST = 'https://openapi.dataoke.com';

    /**
     * 设置appKey
     * @param $appKey
     * @return $this
     */
    public function setAppKey($appKey)
    {
        $this->appKey = $appKey;
        return $this;
    }

    /**
     * 获取appKey
     * @return string
     */
    protected function getAppKey()
    {
        return $this->appKey;
    }

    /**
     * 设置appSecret
     * @param $appSecret
     * @return $this
     */
    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
        return $this;
    }

    /**
     * 获取appSecret
     * @return string
     */
    protected function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * 设置version
     * @param $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * 获取version
     * @return string
     */
    protected function getVersion()
    {
        return $this->version;
    }

    protected function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * 签名参数
     * @param $data
     * @return string
     */
    public function makeSign($timer, $nonce)
    {
        return strtoupper(md5('appKey=' . $this->appKey . '&timer=' . $timer. '&nonce='.$nonce.'&key='. $this->appSecret));
    }

    /**
     * 设置请求参数
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        foreach ($this->getParamsField() as $field) {
            if (isset($params[$field])) {
                $this->$field = $params[$field];
                $this->requestParams[$field] = $params[$field];
            }
        }
        return $this;
    }

    /**
     * 接口调用
     * @return bool|string
     */
    public function request()
    {
        //参数校验
        list($msg, $status) = $this->check();
        if (!$status) {
            return json_encode(array('code'=>10001,'msg'=>$msg));
        }

        $host = self::HOST . $this->getMethod();

        if ($host == '' || $this->appKey == '' || $this->appSecret == '' || $this->version == '') {
            return json_encode(array('code'=>10001,'msg'=>"请完善参数"));
        }

        $type = strtoupper($this->methodType);
        if(!in_array($type, array("GET", "POST"))) {
            return json_encode(array('code'=>10001,'msg'=>"只支持GET/POST请求"));
        }

        //毫秒级时间戳
        list($msec, $sec) = explode(' ', microtime());
        $timer = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);

        //6位随机数
        $nonce = rand(100000, 999999);

        //默认必传参数
        $data = [
            'appKey' => $this->appKey,
            'version' => $this->version,
            'timer' => $timer,
            'nonce' => $nonce,
        ];

        //加密的参数
        if ($this->requestParams) {
            $data = array_merge($this->requestParams, $data);
        }

        $data['signRan'] = self::makeSign($timer, $nonce);
        try {
            if($type == 'POST') {
                //拼接请求地址
                $url = $host;
                //执行请求获取数据
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //https调用
                curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
                $header = [
                    'Content-Type: application/json',
                    'Client-Sdk-Type: php',
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                $output = curl_exec($ch);
                $a = curl_error($ch);
                if(!empty($a)){
                    return json_encode(array('code'=>10003, 'msg'=>$a));
                }
                curl_close($ch);
                return $output;
            }else{
                //拼接请求地址
                $url = $host . '?' . http_build_query($data);
                //执行请求获取数据
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
                $output = curl_exec($ch);
                $a = curl_error($ch);
                if(!empty($a)){
                    return json_encode(array('code'=>10003, 'msg'=>$a));
                }
                curl_close($ch);
                return $output;
            }
        }catch (Exception $e){
            return json_encode(array('code'=>10002,'msg'=>"请求超时或异常，请重试"));
        }
    }
}
