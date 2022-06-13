<?php

/**
 * Class GetTipList 线报
 * Integer topic  线报类型：1-超值买返2-天猫超市3-整点抢购4-最新线报-所有数据(默认)5-最新线报-天猫6-最新线报-京东7-最新线报-拼多多8-最新线报-淘宝
 * Integer pageId 页码，默认为1
 * Integer pageSize 每页记录数，默认20
 * Integer selectTime rush-整点抢购时的时间戳（秒），示例：1617026400
 */
class GetTipList extends DtkClient
{
    protected $topic;
    protected $pageId;
    protected $pageSize;
    protected $selectTime;
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/spider/list-tip-off";

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
        return ['topic','pageId','pageSize','selectTime'];
    }

    /**
     * @return array
     */
    public function check()
    {
        return ['', true];
    }
}
