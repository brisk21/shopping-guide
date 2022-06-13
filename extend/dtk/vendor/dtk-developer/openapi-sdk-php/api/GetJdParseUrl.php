<?php

/**
 * Class GetJdParseUrl 京东链接解析
 * String url required  京东链接地址，内容URLEncode后使用
 */
class GetJdParseUrl extends DtkClient
{
    protected $url;
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/jd/kit/parseUrl";

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
        return ['url'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->url) {
            return ['url不能为空！', false];
        }
        return ['', true];
    }
}
