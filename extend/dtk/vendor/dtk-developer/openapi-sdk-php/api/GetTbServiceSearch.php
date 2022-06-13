<?php

/**
 * Class GetTbServiceSearch 联盟搜索
 * Integer pageNo required  第几页，默认1
 * Integer pageSize required 每页条数， 默认20，范围值1~100
 * String keyWords required 查询词
 * String sort 排序指标：销量（total_sales），淘客佣金比率（tk_rate）， 累计推广量（tk_total_sales），总支出佣金（tk_total_commi），价格（price）,
 *      排序方式：排序_des（降序），排序_asc（升序）,示例：升序查询销量：total_sales_asc
 * Integer source 是否商城商品，设置为1表示该商品是属于淘宝商城商品，设置为非1或不设置表示不判断这个属性（和overseas字段冲突，若已请求source，请勿再请求overseas）
 * Integer overseas 是否海外商品，设置为1表示该商品是属于海外商品，设置为非1或不设置表示不判断这个属性（和source字段冲突，若已请求overseas，请勿再请求source）
 * Integer endPrice 折扣价范围上限，单位：元
 * Integer startPrice 折扣价范围下限，单位：元
 * Integer startTkRate 媒体淘客佣金比率下限，如：1234表示12.34%
 * Integer endTkRate 商品筛选-淘客佣金比率上限，如：1234表示12.34%
 * Boolean hasCoupon 是否有优惠券，设置为true表示该商品有优惠券，设置为false或不设置表示不判断这个属性
 * String specialId 会员运营id
 * String channelId 渠道id将会和传入的pid进行验证，验证通过将正常转链，请确认填入的渠道id是正确的channelId对应联盟的relationId
 * String itemLoc 商品所在地，默认为全部商品，其他值：北京、上海、广州等必须是城市名称，不能带省份
 * String needPrepay 商品是否加入消费者保障，1为加入消费者保障，默认全部
 * String includeGoodRate 商品好评率是否高于行业均值，1为高于行业均值，默认全部
 */
class GetTbServiceSearch extends DtkClient
{
    protected $pageNo;
    protected $pageSize;
    protected $keyWords;
    protected $sort;
    protected $source;
    protected $overseas;
    protected $endPrice;
    protected $startPrice;
    protected $startTkRate;
    protected $endTkRate;
    protected $hasCoupon;
    protected $specialId;
    protected $channelId;
    protected $itemLoc;
    protected $needPrepay;
    protected $includeGoodRate;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/tb-service/get-tb-service";

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
            'pageNo','pageSize','keyWords','sort','overseas','endPrice','startPrice','startTkRate','endTkRate','hasCoupon',
            'specialId','channelId','itemLoc','needPrepay','includeGoodRate'
        ];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pageNo) {
            return ['pageNo不能为空！', false];
        }
        if (!$this->pageSize) {
            return ['pageSize不能为空！', false];
        }
        if (!$this->keyWords) {
            return ['keyWords不能为空！', false];
        }
        return ['', true];
    }
}
