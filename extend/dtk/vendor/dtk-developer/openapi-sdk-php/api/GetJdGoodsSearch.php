<?php

/**
 * Class GetJdGoodsSearch 京东联盟搜索
 * Integer cid1 一级类目id
 * Integer cid2 二级类目id
 * Integer cid3 三级类目id
 * Integer pageId 页码
 * Integer pageSize 每页数量，单页数最大30，默认20
 * String skuIds skuid集合(一次最多支持查询100个sku)，多个使用“,”分隔符
 * String keyword 关键词，字数同京东商品名称一致，目前未限制
 * float priceFrom 商品券后价格下限
 * float priceTo 商品券后价格上限
 * Integer commissionShareStart 佣金比例区间开始
 * Integer commissionShareEnd 佣金比例区间结束
 * String owner 商品类型：自营[g]，POP[p]
 * String sortName 排序字段(price：单价, commissionShare：佣金比例, commission：佣金， inOrderCount30Days：30天引单量， inOrderComm30Days：30天支出佣金)
 * String sort asc：升序；desc：降序。默认降序
 * Integer isCoupon 是否是优惠券商品，1：有优惠券，0：无优惠券
 * float pingouPriceStart 拼购价格区间开始
 * float pingouPriceEnd 拼购价格区间结束
 * String brandCode 品牌code
 * Integer shopId 店铺Id
 * Integer hasBestCoupon 1：查询有最优惠券商品；其他值过滤掉此入参条件。（查询最优券需与isCoupon同时使用）
 * String pid 联盟id_应用iD_推广位id
 * String jxFlags 京喜商品类型，1京喜、2京喜工厂直供、3京喜优选（包含3时可在京东APP购买），入参多个值表示或条件查询
 * Integer spuId 主商品spuId
 * String couponUrl 优惠券链接
 * Integer deliveryType 京东配送 1：是，0：不是
 */
class GetJdGoodsSearch extends DtkClient
{
    protected $cid1;
    protected $cid2;
    protected $cid3;
    protected $pageId;
    protected $pageSize;
    protected $skuIds;
    protected $keyword;
    protected $priceFrom;
    protected $priceTo;
    protected $commissionShareStart;
    protected $commissionShareEnd;
    protected $owner;
    protected $sortName;
    protected $sort;
    protected $isCoupon;
    protected $pingouPriceStart;
    protected $pingouPriceEnd;
    protected $brandCode;
    protected $shopId;
    protected $hasBestCoupon;
    protected $pid;
    protected $jxFlags;
    protected $spuId;
    protected $couponUrl;
    protected $deliveryType;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/jd/goods/search";

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
            'cid1','cid2','cid3','pageId','pageSize','skuIds','keyword','priceFrom','priceTo','commissionShareStart','commissionShareEnd','deliveryType',
            'owner','sortName','sort','isCoupon','pingouPriceStart','pingouPriceEnd','brandCode','shopId','hasBestCoupon','pid','jxFlags','spuId','couponUrl'
        ];
    }

    /**
     * @return array
     */
    public function check()
    {
        return ['', true];
    }
}
