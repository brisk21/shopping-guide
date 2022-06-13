<?php

/**
 * Class GetTwdToTwd 淘口令转淘口令
 * String content required 支持包含文本的淘口令，但最好是一个单独淘口令
 * String pid 推广位ID，用户可自由填写当前大淘客账号下已授权淘宝账号的任一pid，若未填写，则默认使用创建应用时绑定的pid
 * String channelId 渠道id将会和传入的pid进行验证，验证通过将正常转链，请确认填入的渠道id是正确的
 * String special_id 会员运营ID
 * String external_id 淘宝客外部用户标记，如自身系统账户ID；微信ID等
 */
class GetTwdToTwd extends DtkClient
{
    protected $content;
    protected $pid;
    protected $channelId;
    protected $special_id;
    protected $external_id;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/tb-service/twd-to-twd";

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
        return ['content','pid','channelId','special_id','external_id'];
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
