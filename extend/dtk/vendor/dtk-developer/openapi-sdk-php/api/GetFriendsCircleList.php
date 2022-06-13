<?php

/**
 * Class GetFriendsCircleList 朋友圈文案
 * Integer pageId required 分页id，默认为1
 * Integer pageSize 每页条数，默认为100，若小于10，则按10条处理，每页条数仅支持输入10,50,100
 * Integer sort 排序方式，默认为0，0-综合排序，1-商品上架时间从高到低，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 * String cid 大淘客的一级分类id
 * Integer subcid 大淘客的二级类目id，通过超级分类API获取。仅允许传一个二级id，当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
 * Integer pre 是否预告商品，1-预告商品，0-所有商品，不填默认为0
 * Integer freeshipRemoteDistrict 偏远地区包邮：1.是，0.否
 * String goodsId 大淘客id或淘宝id，查询单个商品是否有朋友圈文案，如果有，则返回商品信息及朋友圈文案，如果没有，显示10006错误
 */
class GetFriendsCircleList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $sort;
    protected $cid;
    protected $subcid;
    protected $pre;
    protected $freeshipRemoteDistrict;
    protected $goodsId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/friends-circle-list";

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
        return ['pageId','pageSize','sort','cid','subcid','pre','freeshipRemoteDistrict','goodsId'];
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
