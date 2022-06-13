<?php

/**
 * Class GetCarouseList 轮播图
 */
class GetCarouseList extends DtkClient
{
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/topic/carouse-list";

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
