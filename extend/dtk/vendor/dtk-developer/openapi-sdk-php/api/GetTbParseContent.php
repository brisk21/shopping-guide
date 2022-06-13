<?php

/**
 * Class GetTbParseContent 淘系万能解析
 * String content required  包含淘口令、链接的文本。优先解析淘口令，再按序解析每个链接，直至解出有效信息。如果淘口令失效或者不支持的类型的情况，会按顺序解析链接。如果存在解析失败，请再试一次
 */
class GetTbParseContent extends DtkClient
{
    protected $content;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/tb-service/parse-content";

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
        return ['content'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->content) {
            return ['content不能为空！', false];
        }
        return ['', true];
    }
}
