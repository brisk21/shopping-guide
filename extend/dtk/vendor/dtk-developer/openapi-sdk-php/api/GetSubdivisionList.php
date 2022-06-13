<?php

/**
 * Class GetSubdivisionList 细分类目合集
 * Integer cid required 大淘客一级分类ID，1 -女装，2 -母婴，3 -美妆，4 -居家日用，5 -鞋品，6 -美食，7 -文娱车品，8 -数码家电，9 -男装，10 -内衣，11 -箱包，12 -配饰，13 -户外运动，14 -家装家纺
 * Integer pageId required 分页id
 * Integer pageSize required 每页条数，默认20，最大100条
 */
class GetSubdivisionList extends DtkClient
{
    protected $cid;
    protected $pageId;
    protected $pageSize;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/subdivision/get-list";

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
        return ['cid','pageId','pageSize'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->cid) {
            return ['cid不能为空！', false];
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
