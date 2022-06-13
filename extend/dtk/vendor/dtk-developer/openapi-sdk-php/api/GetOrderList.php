<?php

/**
 * Class GetOrderList 京东一元购订单查询
 * String orderTimeType required 订单时间类型：(1：下单时间，2：完成时间（购买用户确认收货时间），3：更新时间
 * String startTime required 开始时间 格式yyyy-MM-dd HH:mm:ss，与endTime间隔不超过30天
 * String endTime required 结束时间 格式yyyy-MM-dd HH:mm:ss，与startTime间隔不超过30天
 * String pageId 分页id，默认为1，支持scroll翻页查询
 * Integer pageSize 每页记录条数，最大支持200
 * String code 自定义标识，用于区分下游推广渠道（如果没有做代理返利模式，可不传）
 */
class GetOrderList extends DtkClient
{
    protected $orderTimeType;
    protected $startTime;
    protected $endTime;
    protected $pageId;
    protected $pageSize;
    protected $code;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/jd/order/outer/get-order-list";

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
        return ['orderTimeType','startTime','endTime','pageId','pageSize','code'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->orderTimeType) {
            return ['orderTimeType不能为空！', false];
        }
        if (!$this->startTime) {
            return ['startTime不能为空！', false];
        }
        if (!$this->endTime) {
            return ['endTime不能为空！', false];
        }
        return ['', true];
    }
}
