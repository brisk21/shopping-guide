<?php

/**
 * Class GetHotAdvance 爆品预告商品合集
 * Integer type 时间段1、昨天0点，2、昨天10点，3、今天0点，4、今天10点（默认），5、明天0点，6、明天10点
 */
class GetHotAdvance extends DtkClient
{
    protected $type;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-hot-advance";

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
        return ['type'];
    }

    /**
     * @return array
     */
    public function check()
    {
        return ['', true];
    }
}
