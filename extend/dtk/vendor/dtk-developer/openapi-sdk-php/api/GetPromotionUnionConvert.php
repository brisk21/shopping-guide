<?php

/**
 * Class GetPromotionUnionConvert 京东商品批量转链
 * Number unionId required  目标推客的联盟ID
 * Number positionId 新增推广位id （若无subUnionId权限，可入参该参数用来确定不同用户下单情况）
 * String childPid 联盟子推客身份标识（不能传入接口调用者自己的pid）
 * String subUnionId 子渠道标识，您可自定义传入字母、数字或下划线，最多支持80个字符，该参数会在订单行查询接口中展示，需要有权限才可使用
 * String content required 待转链京东商品物料地址(需要urlencode，优惠券无法进行转链，无法转链的地址会按照原数据返回)
 */
class GetPromotionUnionConvert extends DtkClient
{
    protected $unionId;
    protected $positionId;
    protected $childPid;
    protected $subUnionId;
    protected $content;
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/jd/kit/content/promotion-union-convert";

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
        return ['unionId','positionId','childPid','subUnionId','content'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->unionId) {
            return ['unionId不能为空！', false];
        }
        if (!$this->content) {
            return ['content不能为空！', false];
        }
        return ['', true];
    }
}
