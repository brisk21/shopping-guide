<?php

/**
 * Class GetListSimilerGoods 猜你喜欢
 * Integer id required 大淘客的商品id
 * Integer size 每页条数，默认10 ， 最大值100
 */
class GetListSimilerGoods extends DtkClient
{
    protected $id;
    protected $size;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/list-similer-goods-by-open";

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
        return ['id','size'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->id) {
            return ['id不能为空！', false];
        }
        return ['', true];
    }
}
