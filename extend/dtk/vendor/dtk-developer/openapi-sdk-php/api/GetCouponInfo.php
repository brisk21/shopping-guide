<?php

/**
 * Class GetCouponInfo  优惠券查询
 * String content required  二合一链接，淘口令，或同时输入商品+优惠券链接
 */
class GetCouponInfo extends DtkClient
{
    protected $content;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/taobao/kit/coupon/get-coupon-info";

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
        return ['content'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->content) {
            return ['content不能为空！', false];
        }
        return ['', true];
    }
}
