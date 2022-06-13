<?php

/**
 * Class GetSuperCategory 超级分类
 */
class GetSuperCategory extends DtkClient
{
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/category/get-super-category";

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
