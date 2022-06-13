<?php

/**
 * Class GetTurnLink 超值买返商品转链
 * String goodsId required 商品id
 * String title required 商品标题
 * String pid 淘宝联盟pid
 * String relationId 渠道id
 * String couponId 优惠券id
 */
class GetTurnLink extends DtkClient
{
    protected $goodsId;
    protected $title;
    protected $pid;
    protected $relationId;
    protected $couponId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/taobao/kit/turnLink/czmf";

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
        return ['goodsId','title','pid','relationId','couponId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->goodsId) {
            return ['goodsId不能为空！', false];
        }
        if (!$this->title) {
            return ['title不能为空！', false];
        }
        return ['', true];
    }
}
