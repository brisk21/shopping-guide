<?php

/**
 * Class GetGoodsSearchSuggestion 联想词
 * String keyWords required 关键词
 * Integer type required 当前搜索API类型：1.大淘客搜索 2.联盟搜索 3.超级搜索
 */
class GetGoodsSearchSuggestion extends DtkClient
{
    protected $keyWords;
    protected $type;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/search-suggestion";

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
        return ['keyWords','type'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->keyWords) {
            return ['keyWords不能为空！', false];
        }
        if (!$this->type) {
            return ['type不能为空！', false];
        }
        return ['', true];
    }
}
