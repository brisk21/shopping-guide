<?php

/**
 * Class GetDtkSearchGoods 大淘客搜索
 * Integer pageId required 分页id，默认为1，支持传统的页码分页方式和scroll_id分页方式，根据用户自身需求传入值。示例1：商品入库，则首次传入1，后续传入接口返回的pageid，
 *      接口将持续返回符合条件的完整商品列表，该方式可以避免入口商品重复；示例2：根据pagesize和totalNum计算出总页数，按照需求返回指定页的商品（该方式可能在临近页取到重复商品）
 * Integer pageSize required 每页条数，默认为100，最大值200，若小于10，则按10条处理，每页条数仅支持输入10,50,100,200
 * String keyWords required 关键词搜索
 * Integer cids 大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”。当一级类目id和二级类目id同时传入时，会自动忽略二级类目id，一级分类id请求详情：
 *      1 -女装，2 -母婴，3 -美妆，4 -居家日用，5 -鞋品，6 -美食，7 -文娱车品，8 -数码家电，9 -男装，10 -内衣，11 -箱包，12 -配饰，13 -户外运动，14 -家装家纺
 * Integer subcid 大淘客的二级类目id，通过超级分类API获取。仅允许传一个二级id，当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
 * Integer juHuaSuan 是否聚划算，1-聚划算商品，0-所有商品，不填默认为0
 * Integer taoQiangGou 是否淘抢购，1-淘抢购商品，0-所有商品，不填默认为0
 * Integer tmall 是否天猫商品，1-天猫商品，0-非天猫商品，不填默认为所有商品
 * Integer tchaoshi 是否天猫超市商品，1-天猫超市商品，0-所有商品，不填默认为0
 * Integer goldSeller 是否金牌卖家，1-金牌卖家，0-所有商品，不填默认为0
 * Integer haitao 是否海淘商品，1-海淘商品，0-所有商品，不填默认为0
 * Integer brand 是否品牌商品，1-品牌商品，0-所有商品，不填默认为0
 * String brandIds 品牌id，当brand传入0时，再传入brandIds将获取不到结果。品牌id可以传多个，以英文逗号隔开，如：”345,321,323”
 * Integer priceLowerLimit 价格（券后价）下限
 * Integer priceUpperLimit 价格（券后价）上限
 * Integer couponPriceLowerLimit 最低优惠券面额
 * Integer commissionRateLowerLimit 最低佣金比率
 * Integer monthSalesLowerLimit 最低月销量
 * String sort 排序字段，默认为0，0-综合排序，1-商品上架时间从新到旧，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 * Integer freeshipRemoteDistrict 偏远地区包邮，1-是，0-非偏远地区，不填默认所有商品
 */
class GetDtkSearchGoods extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $keyWords;
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
    protected $priceLowerLimit;
    protected $priceUpperLimit;
    protected $couponPriceLowerLimit;
    protected $commissionRateLowerLimit;
    protected $monthSalesLowerLimit;
    protected $sort;
    protected $freeshipRemoteDistrict;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-dtk-search-goods";

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
            'pageId','pageSize','keyWords','cids','subcid','juHuaSuan','taoQiangGou','tmall','tchaoshi','goldSeller','haitao',
            'brand','brandIds','priceLowerLimit','priceUpperLimit','couponPriceLowerLimit','commissionRateLowerLimit','monthSalesLowerLimit',
            'sort','freeshipRemoteDistrict'
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
        if (!$this->keyWords) {
            return ['keyWords不能为空！', false];
        }
        return ['', true];
    }
}
