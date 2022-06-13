<?php

/**
 * Class GetParseTpwd 淘口令解析
 * String content required  包含淘口令的文本。 若文本中有多个淘口令，仅解析第一个。（目前仅支持商品口令和二合一券口令）
 */
class GetParseTpwd extends DtkClient
{
    protected $content;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/tb-service/parse-taokouling";

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
