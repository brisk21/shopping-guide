<?php

/**
 * Class GetListHotWords 热搜榜
 */
class GetListHotWords extends DtkClient
{
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/etc/search/list-hot-words";

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
