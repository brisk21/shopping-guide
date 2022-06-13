<?php

/**
 * Class GetBrandList 单个品牌详情
 * Integer pageId required 分页id，默认为1
 * Integer pageSize required 每页条数，默认为100，大于100按100处理
 * Integer brandId required 品牌id
 */
class GetBrandList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $brandId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/delanys/brand/get-goods-list";

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
        return ['pageId','pageSize','brandId'];
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
        if (!$this->brandId) {
            return ['brandId不能为空！', false];
        }
        return ['', true];
    }
}
