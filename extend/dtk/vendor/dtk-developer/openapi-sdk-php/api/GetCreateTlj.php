<?php

/**
 * Class GetCreateTlj 淘礼金创建
 * String alimamaAppKey required 请填写您申请的具有淘礼金应用权限的Appkey 申请地址https://survey.taobao.com/apps/zhiliao/BQ2RPRlpU
 * String alimamaAppSecret required 请填写您申请的具有淘礼金应用权限的Appsecret
 * String name required 淘礼金名称，最大10个字符
 * String itemId required 宝贝商品id
 * String pid 联盟应用对应的pid
 * Integer campaignType 佣金计划类型1-定向（DX）；2-鹊桥（LINK_EVENT）；3-营销（MKT）
 * String perFace required 单个淘礼金面额，支持两位小数，单位元
 * Integer totalNum required 淘礼金总个数
 * Integer winNumLimit required 单用户累计中奖次数上限，最小值为1
 * String sendStartTime required 发放开始时间，格式为yyyy-MM-dd HH:mm:ss示例：发放开始时间 2018-09-01 00:00:00
 * String sendEndTime required 发放截止时间，格式为yyyy-MM-dd HH:mm:ss发放截止时间，示例： 2018-09-01 00:00:00
 * String useEndTimeMode 结束日期的模式,1:相对时间，2:绝对时间使用结束日期。如果是结束时间模式为相对时间，时间格式为1-7直接的整数,
 *      例如，1（相对领取时间1天）； 如果是绝对时间，格式为yyyy-MM-dd，例如，2019-01-29，表示到2019-01-29 23:59:59结束
 * String useStartTime 使用开始日期。相对时间，无需填写，以用户领取时间作为使用开始时间。绝对时间，格式 yyyy-MM-dd，例如，2019-01-29，
 *      表示从2019-01-29 00:00:00 开始
 * String userEndTime 使用结束日期。如果是结束时间模式为相对时间，时间格式为1-7直接的整数,例如，1（相对领取时间1天）； 如果是绝对时间，
 *      格式为yyyy-MM-dd，例如，2019-01-29，表示到2019-01-29 23:59:59结束
 */
class GetCreateTlj extends DtkClient
{
    protected $alimamaAppKey;
    protected $alimamaAppSecret;
    protected $name;
    protected $itemId;
    protected $pid;
    protected $campaignType;
    protected $perFace;
    protected $totalNum;
    protected $winNumLimit;
    protected $sendStartTime;
    protected $sendEndTime;
    protected $useEndTimeMode;
    protected $useStartTime;
    protected $userEndTime;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/taobao/kit/create-tlj";

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
        return ['alimamaAppKey','alimamaAppSecret','name','itemId','pid','campaignType','perFace','totalNum',
            'winNumLimit','sendStartTime','sendEndTime','useEndTimeMode','useStartTime','userEndTime'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->alimamaAppKey) {
            return ['alimamaAppKey不能为空！', false];
        }
        if (!$this->alimamaAppSecret) {
            return ['alimamaAppSecret不能为空！', false];
        }
        if (!$this->name) {
            return ['name不能为空！', false];
        }
        if (!$this->itemId) {
            return ['itemId不能为空！', false];
        }
        if (!$this->perFace) {
            return ['perFace不能为空！', false];
        }
        if (!$this->totalNum) {
            return ['totalNum不能为空！', false];
        }
        if (!$this->winNumLimit) {
            return ['winNumLimit不能为空！', false];
        }
        if (!$this->sendStartTime) {
            return ['sendStartTime不能为空！', false];
        }
        if (!$this->sendEndTime) {
            return ['sendEndTime不能为空！', false];
        }
        return ['', true];
    }
}
