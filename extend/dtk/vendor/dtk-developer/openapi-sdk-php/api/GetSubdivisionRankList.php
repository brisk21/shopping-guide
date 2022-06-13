<?php

/**
 * Class GetSubdivisionRankList 细分类目榜
 * String subdivisionId required 细分类目榜分类id（从商品详情获取）
 */
class GetSubdivisionRankList extends DtkClient
{
    protected $subdivisionId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/subdivision/get-rank-list";

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
        return ['subdivisionId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->subdivisionId) {
            return ['subdivisionId不能为空！', false];
        }
        return ['', true];
    }
}
