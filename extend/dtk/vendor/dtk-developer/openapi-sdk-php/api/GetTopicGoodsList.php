<?php

/**
 * Class GetTopicGoodsList 专题商品
 * Integer pageId required 分页id，默认为1
 * Integer pageSize 每页条数，默认为100，大于100按100处理
 * Integer topicId required 专辑id
 */
class GetTopicGoodsList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $topicId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/topic/goods-list";

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
        return ['pageId','pageSize','topicId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pageId) {
            return ['pageId不能为空！', false];
        }
        if (!$this->topicId) {
            return ['topicId不能为空！', false];
        }
        return ['', true];
    }
}
