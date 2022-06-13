<?php

/**
 * Class GetListHeightCommission 高佣精选
 * Integer pageSize required 每页返回条数，每页条数支持输入10,20，50,100。
 * Integer pageId required 分页id：常规分页方式，请直接传入对应页码（比如：1,2,3……）
 * Integer cid 大淘客的一级分类id
 * Integer sort 排序：默认按佣金比例降序1-按销量降序，2-按销量升序，3-按佣金比例降序，4-按佣金比例升序。
 */
class GetListHeightCommission extends DtkClient
{
    protected $pageSize;
    protected $pageId;
    protected $cid;
    protected $sort;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/singlePage/list-height-commission";

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
        return ['pageSize','pageId','cid','sort'];
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
