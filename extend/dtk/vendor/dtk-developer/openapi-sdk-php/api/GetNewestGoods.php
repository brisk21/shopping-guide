<?php

/**
 * Class GetNewestGoods 商品更新
 * Integer pageId required 分页id，默认为1
 * Integer pageSize required 每页条数，默认为100，最大值200，若小于10，则按10条处理，每页条数仅支持输入10,50,100,200
 * String startTime 商品上架开始时间，请求格式：yyyy-MM-dd HH:mm:ss
 * String endTime 商品上架结束时间，请求格式：yyyy-MM-dd HH:mm:ss
 * String cids 大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”
 * Integer subcid 大淘客的二级类目id，通过超级分类API获取。仅允许传一个二级id，当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
 * Integer juHuaSuan 1-聚划算商品，0-所有商品，不填默认为0
 * Integer taoQiangGou 1-淘抢购商品，0-所有商品，不填默认为0
 * Integer tmall 1-天猫商品，0-非天猫商品，不填默认全部商品
 * Integer tchaoshi 1-天猫超市商品，0-所有商品，不填默认为0
 * Integer goldSeller 1-金牌卖家，0-所有商品，不填默认为0
 * Integer haitao 1-海淘，0-所有商品，不填默认为0
 * Integer brand 1-品牌，0-所有商品，不填默认为0
 * String brandIds 品牌id，当brand传入0时，再传入brandIds将获取不到结果。品牌id可以传多个，以英文逗号隔开，如：”345,321,323”
 * Integer preSale 1-活动预售商品，0-所有商品，不填默认为0
 * Integer priceLowerLimit 价格（券后价）下限
 * Integer priceUpperLimit 价格（券后价）上限
 * Integer couponPriceLowerLimit 最低优惠券面额
 * Integer commissionRateLowerLimit 最低佣金比率
 * Integer monthSalesLowerLimit 最低月销量
 * Integer sort 排序字段，默认为0，0-综合排序，1-商品上架时间从新到旧，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 */
class GetNewestGoods extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $startTime;
    protected $endTime;
    protected $cids;
    protected $subcid;
    protected $juHuaSuan;
    protected $taoQiangGou;
    protected $tmall;
    protected $tchaoshi;
    protected $goldSeller;
    protected $haitao;
    protected $brand;
    protected $brandIds;
    protected $preSale;
    protected $priceLowerLimit;
    protected $priceUpperLimit;
    protected $couponPriceLowerLimit;
    protected $commissionRateLowerLimit;
    protected $monthSalesLowerLimit;
    protected $sort;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-newest-goods";

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
            'pageId','pageSize','startTime','endTime','cids','subcid','juHuaSuan','taoQiangGou','tmall','tchaoshi','goldSeller',
            'haitao','brand','brandIds','preSale','priceLowerLimit','priceUpperLimit','couponPriceLowerLimit','commissionRateLowerLimit',
            'monthSalesLowerLimit','sort'
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
        if (!$this->pageSize) {
            return ['pageSize不能为空！', false];
        }
        return ['', true];
    }
}
