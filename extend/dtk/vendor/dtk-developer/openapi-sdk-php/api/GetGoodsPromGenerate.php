<?php

/**
 * Class GetGoodsPromGenerate 拼多多商品转链
 * String pid required  拼多多推广位id(联盟通知，在2021/4/30日之前，pid、custom_parameters必须进行备案)
 * String goodsSign required 商品goodsSign（详细说明可复制链接查看http://www.dataoke.com/kfpt/open-gz.html?id=100）
 * String customParameters 自定义参数，为链接打上自定义标签； 自定义参数最长限制64个字节； 格式为： {"uid":"11111","sid":"22222"} ，
 *      其中 uid 用户唯一标识，可自行加密后传入， 每个用户仅且对应一个标识，必填； sid 上下文信息标识，例如sessionId等， 非必填。该json字符串中
 *      也可以加入其他自定义的key In
 * String zsDuoId 招商多多客ID
 */
class GetGoodsPromGenerate extends DtkClient
{
    protected $pid;
    protected $goodsSign;
    protected $customParameters;
    protected $zsDuoId;
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/pdd/kit/goods-prom-generate";

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
        return ['pid','goodsSign','customParameters','zsDuoId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pid) {
            return ['pid不能为空！', false];
        }
        if (!$this->goodsSign) {
            return ['goodsSign不能为空！', false];
        }
        return ['', true];
    }
}
