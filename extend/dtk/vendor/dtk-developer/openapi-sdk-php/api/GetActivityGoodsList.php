<?php

/**
 * Class GetActivityGoodsList 活动商品
 * Integer pageId required 分页id，默认为1
 * Integer pageSize 每页条数，默认为100，大于100按100处理
 * Integer activityId required 通过热门活动API获取的活动id
 * Integer cid 大淘客一级分类ID：1 -女装，2 -母婴，3 -美妆，4 -居家日用，5 -鞋品，6 -美食，7 -文娱车品，8 -数码家电，9 -男装，10 -内衣，11 -箱包，12 -配饰，13 -户外运动，14 -家装家纺
 * Integer subcid 大淘客二级分类ID：可通过超级分类接口获取二级分类id，当同时传入一级分类id和二级分类id时，以一级分类id为准
 * Integer freeshipRemoteDistrict 偏远地区包邮：1.是，0.否
 */
class GetActivityGoodsList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $activityId;
    protected $cid;
    protected $subcid;
    protected $freeshipRemoteDistrict;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/activity/goods-list";

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
        return ['pageId','pageSize','activityId','cid','subcid','freeshipRemoteDistrict'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pageId) {
            return ['pageId不能为空！', false];
        }
        if (!$this->activityId) {
            return ['activityId不能为空！', false];
        }
        return ['', true];
    }
}
