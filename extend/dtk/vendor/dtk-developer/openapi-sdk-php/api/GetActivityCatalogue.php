<?php

/**
 * Class GetActivityCatalogue 热门活动
 */
class GetActivityCatalogue extends DtkClient
{
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/activity/catalogue";

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
        return [];
    }

    /**
     * @return array
     */
    public function check()
    {
        return ['', true];
    }
}
