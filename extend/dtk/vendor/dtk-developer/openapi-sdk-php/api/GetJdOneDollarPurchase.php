<?php

/**
 * Class GetJdOneDollarPurchase 京东年货节商品
 * Integer pageSize required 每页返回条数，每页条数支持输入10,20，50,100。默认50条
 * Integer pageId required 分页id
 * String cids 大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”
 * Integer sort required 排序方式，默认为0，0-综合排序，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 * String subsidy 礼金类型（3-三元区；5-五元区）默认为三元区
 */
class GetJdOneDollarPurchase extends DtkClient
{
    protected $pageSize;
    protected $pageId;
    protected $cids;
    protected $sort;
    protected $subsidy;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/jd-one-dollar-purchase";

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
        return ['pageSize','pageId','cids','sort','subsidy'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pageSize) {
            return ['pageSize不能为空！', false];
        }
        if (!$this->pageId) {
            return ['pageId不能为空！', false];
        }
        if (!is_numeric($this->sort)) {
            return ['sort错误！', false];
        }
        return ['', true];
    }
}
