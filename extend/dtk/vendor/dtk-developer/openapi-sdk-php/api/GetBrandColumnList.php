<?php

/**
 * Class GetBrandColumnList 品牌栏目
 * Integer pageId required 分页id，默认为1
 * Integer pageSize required 每页记录条数（每页记录最大支持50，如果参数大于50时取50作为每页记录条数）
 * Integer cid required 大淘客分类id
 */
class GetBrandColumnList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $cid;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/delanys/brand/get-column-list";

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
        return ['pageId','pageSize','cid'];
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
        if (!$this->cid) {
            return ['cid不能为空！', false];
        }
        return ['', true];
    }
}
