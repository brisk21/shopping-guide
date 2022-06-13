<?php

/**
 * Class ClipboardContentParse 剪切板内容解析识别
 * 应用场景：从其他渠道获取到的热门商品/活动的推广内容，如果内容中包含淘口令或者推广链接，则可以在打开app时调用此接口解析出商品的基本信息（佣金，价格，商品ID……）或者是活动链接，并同时进行转链
 * 接口说明：可在解析出淘宝、京东、拼多多的商品和活动会场的链接或口令的同时，同步进行转链
 */
class ClipboardContentParse extends DtkClient
{

    protected $methodType = 'GET';
    protected $requestParams = [];

    /**
     * @var string content，文本内容
     */
    protected $content;

    /**
     * @var String 淘宝联盟pid
     */
    protected $TbPid;

    /**
     * @var String 淘宝联盟渠道id
     */
    protected $TbChannelId;

    /**
     * @var integer 京东联盟unionId
     */
    protected $JdUnionId;

    /**
     * @var integer 京东联盟pid
     */
    protected $JdPid;

    /**
     * @var String 拼多多联盟pid
     */
    protected $PddPid;

    const METHOD = '/api/dels/kit/contentParse';

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
        return ['content', 'TbPid', 'TbChannelId', 'JdUnionId', 'JdPid', 'customerParameters'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->content) {
            return ['content不能为空！', false];
        }
        return ['', true];
    }
}