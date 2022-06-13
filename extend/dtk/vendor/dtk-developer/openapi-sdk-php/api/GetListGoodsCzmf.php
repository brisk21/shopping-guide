<?php

/**
 * Class GetListGoodsCzmf 超值买返商品
 * Integer sort required 排序方式：1-返得红包百分比升序2-返得红包百分比降序3-销量降序4-销量升序5-返得红包金额升序6-返得红包金额降序
 * Integer pageId 分页id
 * Integer pageSize 每页记录条数
 */
class GetListGoodsCzmf extends DtkClient
{
    protected $sort;
    protected $pageId;
    protected $pageSize;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/activity/list-goods-czmf";

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
        return ['sort','pageId','pageSize'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->sort) {
            return ['sort不能为空！', false];
        }
        if (!$this->pageId) {
            return ['pageId不能为空！', false];
        }
        if (!$this->pageSize) {
            return ['pageSize不能为空！', false];
        }
        return ['', true];
    }
}
