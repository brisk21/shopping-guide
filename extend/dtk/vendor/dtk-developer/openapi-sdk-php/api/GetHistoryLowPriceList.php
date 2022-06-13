<?php

/**
 * Class GetHistoryLowPriceList 历史新低商品合集
 * Integer pageId required 分页id，默认为1
 * Integer pageSize required 每页返回条数，每页条数支持输入10,20，50,100。默认50条
 * String cids 大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”
 * Integer sort required 排序方式，默认为0，0-综合排序，1-商品上架时间从高到低，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 */
class GetHistoryLowPriceList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $cids;
    protected $sort;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-history-low-price-list";

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
        return ['pageId','pageSize','cids','sort'];
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
        if (!is_numeric($this->sort)) {
            return ['sort错误！', false];
        }
        return ['', true];
    }
}
