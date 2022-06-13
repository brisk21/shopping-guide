<?php

/**
 * Class GetNineOpGoodsList 9.9包邮精选
 * Integer pageId required 分页id
 * Integer pageSize required 每页条数：默认为20，最大值100
 * Integer nineCid required 9.9精选的类目id，分类id请求详情：-1-精选，1 -5.9元区，2 -9.9元区，3 -19.9元区
 */
class GetNineOpGoodsList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $nineCid;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/nine/op-goods-list";

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
        return ['pageId','pageSize','nineCid'];
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
        if (!$this->nineCid) {
            return ['nineCid不能为空！', false];
        }
        return ['', true];
    }
}
