<?php

/**
 * Class GetHalfPriceDay 每日半价
 * String sessions required 默认为当前时间场次，场次输入格式，例如02、08、12、16
 */
class GetHalfPriceDay extends DtkClient
{
    protected $sessions;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-half-price-day";

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
        return ['sessions'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->sessions) {
            return ['sessions不能为空！', false];
        }
        return ['', true];
    }
}
