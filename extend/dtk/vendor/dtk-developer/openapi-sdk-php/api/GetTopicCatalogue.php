<?php

/**
 * Class GetTopicCatalogue 精选专题
 */
class GetTopicCatalogue extends DtkClient
{
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/topic/catalogue";

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
