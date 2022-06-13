<?php

/**
 * Class GetPullGoodsByTime 定时拉取
 * Integer pageSize 每页条数，默认为100，最大值200，若小于10，则按10条处理，每页条数仅支持输入10,50,100,200
 * Integer pageId required 分页id
 * Integer cid 大淘客的一级分类id。当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
 * Integer subcid 大淘客的二级类目id，通过超级分类API获取。仅允许传一个二级id，当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
 * Integer pre 是否预告商品，1-预告商品，0-所有商品，不填默认为0
 * Integer sort 排序方式，默认为0，0-综合排序，1-商品上架时间从新到旧，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 * String startTime 开始时间，格式为yyyy-mm-dd hh:mm:ss，商品上架的时间大于等于开始时间
 * String endTime 结束时间，默认为请求的时间，商品上架的时间小于等于结束时间
 * Integer freeshipRemoteDistrict 偏远地区包邮，1-是，0-非偏远地区，不填默认所有商品
 * Integer choice 是否为精选商品，默认全部商品，1-精选商品
 */
class GetPullGoodsByTime extends DtkClient
{
    protected $pageSize;
    protected $pageId;
    protected $cid;
    protected $subcid;
    protected $pre;
    protected $sort;
    protected $startTime;
    protected $endTime;
    protected $freeshipRemoteDistrict;
    protected $choice;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/pull-goods-by-time";

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
        return ['pageId','pageSize','cid','subcid','pre','sort','startTime','endTime','freeshipRemoteDistrict','choice'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pageId) {
            return ['pageId不能为空！', false];
        }
        return ['', true];
    }
}
