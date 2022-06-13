<?php

/**
 * Class GetLiveGoodsList 热门主播力荐商品
 * Integer pageSize required 每页返回条数，每页条数支持输入10,20，50
 * Integer pageId required 分页id：常规分页方式，请直接传入对应页码（比如：1,2,3……）
 */
class GetLiveGoodsList extends DtkClient
{
    protected $pageSize;
    protected $pageId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/live/goods-list";

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
        return ['pageSize','pageId'];
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
        return ['', true];
    }
}
