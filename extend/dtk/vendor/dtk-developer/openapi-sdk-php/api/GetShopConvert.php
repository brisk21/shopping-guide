<?php

/**
 * Class GetShopConvert 店铺转链
 * String sellerId required 店铺id
 * String pid required 推广位id
 * String relationId 渠道id
 * String shopName required 店铺名称，用于返回淘口令
 */
class GetShopConvert extends DtkClient
{
    protected $sellerId;
    protected $pid;
    protected $relationId;
    protected $shopName;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/shop/convert";

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
        return ['sellerId','pid','relationId','shopName'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->sellerId) {
            return ['sellerId不能为空！', false];
        }
        if (!$this->pid) {
            return ['pid不能为空！', false];
        }
        if (!$this->shopName) {
            return ['shopName不能为空！', false];
        }
        return ['', true];
    }
}
