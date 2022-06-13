<?php

/**
 * Class GetCreateTkl 淘口令生成
 * String text required 口令弹框内容，长度大于5个字符
 * String url required 口令跳转目标页，如：https://uland.taobao.com/，必须以https开头，可以是二合一链接、长链接、短链接等各种淘宝高佣链接；支持渠道备案链接。* 该参数需要进行Urlencode编码后传入*
 * String logo 口令弹框logoURL
 * String userId 生成口令的淘宝用户ID，非必传参数
 */
class GetCreateTkl extends DtkClient
{
    protected $text;
    protected $url;
    protected $logo;
    protected $userId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/tb-service/creat-taokouling";

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::METHOD;
    }

    /**
     * 可用参数
     * @return string[]
     */
    public function getParamsField()
    {
        return ['text','url','logo','userId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->text) {
            return ['text不能为空！', false];
        }
        if (!$this->url) {
            return ['url不能为空！', false];
        }
        return ['', true];
    }
}
