<?php

/**
 * Class GetMergeRedEnvelopes 三合一红包
 * Integer merchantType required 1-淘宝红包，2京东红包，3-拼多多红包
 * String pid 推广pid
 * String unionId required 选择京东红包时需要填入京东联盟ID（在京东联盟后台个人中心）。其他类型不用传
 */
class GetMergeRedEnvelopes extends DtkClient
{
    protected $merchantType;
    protected $pid;
    protected $unionId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/merge-red-envelopes";

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
        return ['merchantType','pid','unionId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->merchantType) {
            return ['merchantType不能为空！', false];
        }

        if ($this->merchantType == 2 && !$this->unionId) {
            return ['unionId不能为空！', false];
        }
        return ['', true];
    }
}
