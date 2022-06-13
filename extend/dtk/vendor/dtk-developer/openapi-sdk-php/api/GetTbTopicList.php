<?php

/**
 * Class GetTbTopicList 官方活动(1元购)
 * Integer pageId required 分页id，支持传统的页码分页方式
 * Integer pageSize 每页条数，默认为20
 * Integer type 输出的端口类型：0.全部（默认），1.PC，2.无线
 * Integer channelID 阿里妈妈上申请的渠道id
 */
class GetTbTopicList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $type;
    protected $channelID;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/category/get-tb-topic-list";

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
        return ['pageId','pageSize','type','channelID'];
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
