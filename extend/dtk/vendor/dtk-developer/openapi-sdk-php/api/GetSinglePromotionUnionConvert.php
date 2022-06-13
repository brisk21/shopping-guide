<?php

/**
 * Class GetSinglePromotionUnionConvert 京东商品转链
 * Number unionId required  目标推客的联盟ID
 * String materialId required 推广物料url，例如活动链接、商品链接等；不支持仅传入skuid
 * Number positionId 新增推广位id （若无subUnionId权限，可入参该参数用来确定不同用户下单情况）
 * String childPid 联盟子推客身份标识（不能传入接口调用者自己的pid）
 * String subUnionId 子渠道标识，您可自定义传入字母、数字或下划线，最多支持80个字符，该参数会在订单行查询接口中展示，需要有权限才可使用
 * String couponUrl 优惠券领取链接，在使用优惠券、商品二合一功能时入参，且materialId须为商品详情页链接（5.27更新：若不填则会自动匹配上全额最大的优惠券进行转链）
 * Integer chainType 转链类型，默认短链，短链有效期60天1：长链2：短链 3：长链+短链，
 * String giftCouponKey 礼金批次号
 */
class GetSinglePromotionUnionConvert extends DtkClient
{
    protected $unionId;
    protected $materialId;
    protected $positionId;
    protected $childPid;
    protected $subUnionId;
    protected $couponUrl;
    protected $chainType;
    protected $giftCouponKey;
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/jd/kit/promotion-union-convert";

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
        return ['unionId','materialId','positionId','childPid','subUnionId','couponUrl','chainType','giftCouponKey'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->unionId) {
            return ['unionId不能为空！', false];
        }
        if (!$this->materialId) {
            return ['materialId不能为空！', false];
        }
        return ['', true];
    }
}
