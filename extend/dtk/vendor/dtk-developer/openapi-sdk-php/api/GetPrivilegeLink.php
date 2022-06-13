<?php

/**
 * Class GetPrivilegeLink 高效转链
 * String goodsId required  淘宝商品id
 * String couponId 商品的优惠券ID，一个商品在联盟可能有多个优惠券，可通过填写该参数的方式选择使用的优惠券，请确认优惠券ID正确，否则无法正常跳转
 * String pid 推广位ID，用户可自由填写当前大淘客账号下已授权淘宝账号的任一pid，若未填写，则默认使用创建应用时绑定的pid
 * String channelId 渠道id将会和传入的pid进行验证，验证通过将正常转链，请确认填入的渠道id是正确的 channelId对应联盟的relationId
 * Number rebateType 付定返红包，0.不使用付定返红包，1.参与付定返红包
 * String specialId 会员运营id
 * String externalId 淘宝客外部用户标记，如自身系统账户ID；微信ID等
 * String xid 团长与下游渠道合作的特殊标识，用于统计渠道推广效果
 * String leftSymbol 淘口令左边自定义符号,默认￥
 * String rightSymbol 淘口令右边自定义符号,默认￥
 */
class GetPrivilegeLink extends DtkClient
{
    protected $goodsId;
    protected $couponId;
    protected $pid;
    protected $channelId;
    protected $rebateType;
    protected $specialId;
    protected $externalId;
    protected $xid;
    protected $leftSymbol;
    protected $rightSymbol;
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/tb-service/get-privilege-link";

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
        return ['goodsId','couponId','pid','channelId','rebateType','specialId','externalId','xid','leftSymbol','rightSymbol'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->goodsId) {
            return ['goodsId不能为空！', false];
        }
        return ['', true];
    }
}
