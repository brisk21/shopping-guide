<?php

/**
 * Class GetJdHistoryPriceRecords 京东商品历史券后价
 * String skuId required 商品id
 * Integer offsetDays 查询时间类型：默认30天，可以1-近7天，2-近30天，3-近60天
 */
class GetJdHistoryPriceRecords extends DtkClient
{
    protected $skuId;
    protected $offsetDays;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/jd/stats/goods/historyPriceRecords";

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
        return ['skuId','offsetDays'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->skuId) {
            return ['skuId不能为空！', false];
        }
        return ['', true];
    }
}
