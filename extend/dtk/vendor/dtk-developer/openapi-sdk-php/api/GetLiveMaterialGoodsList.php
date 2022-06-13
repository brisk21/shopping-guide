<?php

/**
 * Class GetLiveMaterialGoodsList 直播好货
 * String date 选择某一天的直播商品数据，默认返回全部参与过直播，且未下架的商品。时间格式：2020-09-16
 * Integer sort 排序方式，默认为0，0-综合排序，1-商品上架时间从高到低，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 */
class GetLiveMaterialGoodsList extends DtkClient
{
    protected $date;
    protected $sort;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/liveMaterial-goods-list";

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
        return ['date','sort'];
    }

    /**
     * @return array
     */
    public function check()
    {
        return ['', true];
    }
}
