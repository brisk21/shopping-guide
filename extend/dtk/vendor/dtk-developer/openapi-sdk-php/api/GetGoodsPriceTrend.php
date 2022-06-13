<?php

/**
 * Class GetGoodsPriceTrend 商品历史券后价
 * String id required 在大淘客的在线商品id
 * String goodsId 淘宝商品id
 */
class GetGoodsPriceTrend extends DtkClient
{
    protected $id;
    protected $goodsId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/price-trend";

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
        return ['id','goodsId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->id) {
            return ['Id不能为空！', false];
        }
        return ['', true];
    }
}
