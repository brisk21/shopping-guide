<?php

/**
 * Class GetOrderDetails 淘系订单查询
 * Number queryType required  查询时间类型，1：按照订单淘客创建时间查询，2:按照订单淘客付款时间查询，3:按照订单淘客结算时间查询，4：按照订单更新时间（5.27新增字段）
 * String positionIndex 位点，第一页数据返回里面有个这个字段，查第二页的数据的时候就传过去
 * Number pageSize 页大小，默认20，1~100
 * Number memberType 推广者角色类型,2:二方，3:三方，不传，表示所有角色
 * Number tkStatus 淘客订单状态，12-付款，13-关闭，14-确认收货，3-结算成功;不传，表示所有状态
 * String endTime 订单查询结束时间，订单开始时间至订单结束时间，中间时间段日常要求不超过3个小时，但如618、双11、年货节等大促期间预估时间段不可超过20分钟，超过会提示错误，调用时请务必注意时间段的选择，以保证亲能正常调用！ 时间格式：YYYY-MM-DD HH:MM:SS
 * String startTime 订单查询开始时间。时间格式：YYYY-MM-DD HH:MM:SS
 * Number jumpType 跳转类型，当向前或者向后翻页必须提供,-1: 向前翻页,1：向后翻页
 * Number pageNo 第几页，默认1，1~100
 * Number orderScene 场景订单场景类型，1:常规订单，2:渠道订单，3:会员运营订单，默认为1
 */
class GetOrderDetails extends DtkClient
{
    protected $queryType;
    protected $positionIndex;
    protected $pageSize;
    protected $memberType;
    protected $tkStatus;
    protected $endTime;
    protected $startTime;
    protected $jumpType;
    protected $pageNo;
    protected $orderScene;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/tb-service/get-order-details";

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
        return ['queryType','positionIndex','pageSize','memberType','tkStatus','endTime','startTime','jumpType','pageNo','orderScene'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->queryType) {
            return ['queryType不能为空！', false];
        }
        if (!$this->endTime) {
            return ['endTime不能为空！', false];
        }
        if (!$this->startTime) {
            return ['startTime不能为空！', false];
        }
        return ['', true];
    }
}
