<?php

/**
 * Class GetBrandStore 品牌库
 * Integer pageId required 分页id
 * Integer pageSize 每页条数，默认为20，最大值100
 */
class GetBrandStore extends DtkClient
{
    protected $pageId;
    protected $pageSize;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/tb-service/get-brand-list";

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
        return ['pageId','pageSize'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pageId) {
            return ['pageId不能为空！', false];
        }
        return ['', true];
    }
}
