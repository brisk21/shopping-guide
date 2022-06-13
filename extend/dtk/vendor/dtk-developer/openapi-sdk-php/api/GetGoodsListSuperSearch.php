<?php

/**
 * Class GetGoodsListSuperSearch 超级搜索
 * Integer type required 搜索类型：0-综合结果，1-大淘客商品，2-联盟商品
 * Integer pageId required 请求的页码，默认参数1
 * Integer pageSize required 每页条数，默认为20，最大值100
 * String keyWords required 关键词搜索
 * Integer tmall 是否天猫商品：1-天猫商品，0-所有商品，不填默认为0
 * Integer haitao 是否海淘商品：1-海淘商品，0-所有商品，不填默认为0
 * Integer sort 排序字段信息 销量（total_sales） 价格（price），排序_des（降序），排序_asc（升序），示例：升序查询销量total_sales_asc 新增排序字段和排序方式，默认为0，0-综合排序，
 *      1-销量从高到低，2-销量从低到高，3-佣金比例从低到高，4-佣金比例从高到低，5-价格从高到低，6-价格从低到高(2021/1/15新增字段，之前的排序方式也可以使用)
 * String specialId 会员运营id
 * String channelId 渠道id将会和传入的pid进行验证，验证通过将正常转链，请确认填入的渠道id是正确的channelId对应联盟的relationId
 * String priceLowerLimit 商品券后价下限
 * String priceUpperLimit 商品券后价上限
 * String endTkRate 淘客佣金比率上限
 * String startTkRate 淘客佣金比率下限
 * String hasCoupon 是否有券，1为有券，默认为全部
 * String activityId 活动id，多个使用,分隔符。示例：1,2,3
 */
class GetGoodsListSuperSearch extends DtkClient
{
    protected $type;
    protected $pageId;
    protected $pageSize;
    protected $keyWords;
    protected $tmall;
    protected $haitao;
    protected $sort;
    protected $specialId;
    protected $channelId;
    protected $priceLowerLimit;
    protected $priceUpperLimit;
    protected $endTkRate;
    protected $startTkRate;
    protected $hasCoupon;
    protected $activityId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/list-super-goods";

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
        return [
            'type','pageId','pageSize','keyWords','tmall','haitao','sort','specialId','channelId','priceLowerLimit','priceUpperLimit',
            'endTkRate','startTkRate','hasCoupon','activityId'
        ];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!in_array($this->type, [0,1,2])) {
            return ['type错误！', false];
        }
        if (!$this->pageId) {
            return ['pageId错误！', false];
        }
        if (!$this->pageSize) {
            return ['pageSize错误！', false];
        }
        if (!$this->keyWords) {
            return ['keyWords错误！', false];
        }
        return ['', true];
    }
}
