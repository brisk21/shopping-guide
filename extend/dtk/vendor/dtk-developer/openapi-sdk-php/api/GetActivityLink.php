<?php

/**
 * Class GetActivityLink 官方活动会场转链
 * String promotionSceneId required  联盟官方活动ID，从联盟官方活动页获取（或从大淘客官方活动推广接口获取（饿了么微信推广活动ID：20150318020002192，饿了么外卖活动ID：20150318019998877，饿了么商超活动ID：1585018034441）
 * String pid 推广pid，默认为在”我的应用“添加的pid
 * String relationId 渠道id将会和传入的pid进行验证，验证通过将正常转链，请确认填入的渠道id是正确的
 * String unionId 自定义输入串，英文和数字组成，长度不能大于12个字符，区分不同的推广渠道
 */
class GetActivityLink extends DtkClient
{
    protected $promotionSceneId;
    protected $pid;
    protected $relationId;
    protected $unionId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/tb-service/activity-link";

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
        return ['promotionSceneId','pid','relationId','unionId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->promotionSceneId) {
            return ['promotionSceneId不能为空！', false];
        }
        return ['', true];
    }
}
