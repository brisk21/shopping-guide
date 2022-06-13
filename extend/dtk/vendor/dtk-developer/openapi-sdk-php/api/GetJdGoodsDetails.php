<?php

/**
 * Class GetJdGoodsDetails 京东商品详情
 * String skuIds required 商品skuId，多个使用逗号分隔，最多支持10个skuId同时查询（需使用半角状态下的逗号）
 */
class GetJdGoodsDetails extends DtkClient
{
    protected $skuIds;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/jd/goods/get-details";

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
        return ['skuIds'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->skuIds) {
            return ['skuIds不能为空！', false];
        }
        return ['', true];
    }
}
