<?php

/**
 * Class GetGoodsList 商品列表
 * Integer pageId required 分页id，默认为1
 * Integer pageSize 每页条数，默认为100，最大值200，若小于10，则按10条处理，每页条数仅支持输入10,50,100,200
 * Integer sort 排序方式，默认为0，0-综合排序，1-商品上架时间从高到低，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 * String cids 大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”
 * Integer subcid 大淘客的二级类目id，通过超级分类API获取。仅允许传一个二级id，当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
 * Integer specialId 商品卖点，1.拍多件活动；2.多买多送；3.限量抢购；4.额外满减；6.买商品礼赠
 * Integer juHuaSuan 1-聚划算商品，0-所有商品，不填默认为0
 * Integer taoQiangGou 1-淘抢购商品，0-所有商品，不填默认为0
 * Integer tmall 1-天猫商品， 0-非天猫商品，不填默认所有商品
 * Integer tchaoshi 1-天猫超市商品， 0-所有商品，不填默认为0
 * Integer goldSeller 1-金牌卖家商品，0-所有商品，不填默认为0
 * Integer haitao 1-海淘商品， 0-所有商品，不填默认为0
 * Integer pre 1-预告商品，0-所有商品，不填默认为0
 * Integer preSale 1-活动预售商品，0-所有商品，不填默认为0。
 * Integer brand 1-品牌商品，0-所有商品，不填默认为0
 * String brandIds 当brand传入0时，再传入brandIds可能无法获取结果。品牌id可以传多个，以英文逗号隔开，如：”345,321,323”
 * Integer priceLowerLimit 价格（券后价）下限
 * Integer priceUpperLimit 价格（券后价）上限
 * Integer couponPriceLowerLimit 最低优惠券面额
 * Integer commissionRateLowerLimit 最低佣金比率
 * Integer monthSalesLowerLimit 最低月销量
 * Integer directCommissionType 定向佣金类型，3查询定向佣金商品，否则查询全部商品
 * Integer choice 是否为精选商品，默认全部，1-精选商品
 * Integer freeshipRemoteDistrict 偏远地区包邮，1-是，0-非偏远地区，不填默认所有商品
 * Integer flagShipStore 1-官方旗舰店商品，0-不限是否是旗舰店，不填默认为0
 * Integer isNew 1-30天新品，0-不限，不填默认为0（新品与最低价不能同时选，否则无商品）
 * Integer lowestPrice 1-30天最低价，0-不限，不填默认为0（新品与最低价不能同时选，否则无商品）
 */
class GetGoodsList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $sort;
    protected $cids;
    protected $subcid;
    protected $specialId;
    protected $juHuaSuan;
    protected $taoQiangGou;
    protected $tmall;
    protected $tchaoshi;
    protected $goldSeller;
    protected $haitao;
    protected $pre;
    protected $preSale;
    protected $brand;
    protected $brandIds;
    protected $priceLowerLimit;
    protected $priceUpperLimit;
    protected $couponPriceLowerLimit;
    protected $commissionRateLowerLimit;
    protected $monthSalesLowerLimit;
    protected $directCommissionType;
    protected $choice;
    protected $flagShipStore;
    protected $isNew;
    protected $lowestPrice;
    protected $freeshipRemoteDistrict;
    protected $activityId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-goods-list";

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
            'pageId','pageSize','sort','cids','subcid','specialId','juHuaSuan','taoQiangGou','tmall','tchaoshi','goldSeller','haitao',
            'pre','preSale','brand','brandIds','priceLowerLimit','priceUpperLimit','couponPriceLowerLimit','commissionRateLowerLimit',
            'monthSalesLowerLimit','freeshipRemoteDistrict','directCommissionType','choice' , 'flagShipStore', 'isNew', 'lowestPrice',
            'activityId'
        ];
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
