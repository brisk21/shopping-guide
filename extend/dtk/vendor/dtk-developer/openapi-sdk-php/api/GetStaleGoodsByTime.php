<?php

/**
 * Class GetStaleGoodsByTime 失效商品
 * Integer pageSize 每页条数，默认为100，最大值200，若小于10，则按10条处理，每页条数仅支持输入10,50,100,200
 * Integer pageId required 分页id
 * String startTime 开始时间，默认为yyyy-mm-dd hh:mm:ss，商品下架的时间大于等于开始时间，开始时间需要在当日
 * String endTime 结束时间，默认为请求的时间，商品下架的时间小于等于结束时间，结束时间需要在当日
 */
class GetStaleGoodsByTime extends DtkClient
{
    protected $pageSize;
    protected $pageId;
    protected $startTime;
    protected $endTime;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-stale-goods-by-time";

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
        return ['pageSize','pageId','startTime','endTime'];
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
