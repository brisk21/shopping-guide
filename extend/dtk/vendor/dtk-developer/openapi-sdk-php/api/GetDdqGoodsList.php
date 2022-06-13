<?php

/**
 * Class GetDdqGoodsList 咚咚抢
 * String roundTime required 默认为当前场次，场次时间输入方式：yyyy-mm-dd hh:mm:ss
 */
class GetDdqGoodsList extends DtkClient
{
    protected $roundTime;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/category/ddq-goods-list";

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
        return ['roundTime'];
    }

    /**
     * @return array
     */
    public function check()
    {
        return ['', true];
    }
}
