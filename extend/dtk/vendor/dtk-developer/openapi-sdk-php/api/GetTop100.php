<?php

/**
 * Class GetTop100 热搜记录
 * Integer type 1：买家热搜榜（默认）、2：淘客热搜榜
 */
class GetTop100 extends DtkClient
{
    protected $type;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/category/get-top100";

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
