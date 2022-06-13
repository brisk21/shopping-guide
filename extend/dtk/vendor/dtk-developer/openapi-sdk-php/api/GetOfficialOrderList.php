<?php

/**
 * Class GetOfficialOrderList 京东订单查询
 * Integer pageNo 页码（默认为1）
 * Integer pageSize 每页记录条数，默认100
 * Integer type required 订单时间查询类型(1：下单时间，2：完成时间（购买用户确认收货时间），3：更新时间
 * Long childUnionId 子推客unionID，传入该值可查询子推客的订单，注意不可和key同时传入。（需联系运营开通PID权限才能拿到数据）
 * String key required 工具商传入推客的授权key，可帮助该推客查询订单，注意不可和childUnionid同时传入。（需联系运营开通工具商权限才能拿到数据，请在京东联盟->我的工具->我的API->领取授权KEY中获取key）
 * String startTime required 开始时间 格式yyyy-MM-dd HH:mm:ss，与endTime间隔不超过1小时
 * String endTime required 结束时间 格式yyyy-MM-dd HH:mm:ss，与startTime间隔不超过1小时
 * String fields 支持出参数据筛选，逗号分隔，目前可用：goodsInfo（商品信息）,categoryInfo(类目信息）
 */
class GetOfficialOrderList extends DtkClient
{
    protected $pageNo;
    protected $pageSize;
    protected $type;
    protected $childUnionId;
    protected $key;
    protected $startTime;
    protected $endTime;
    protected $fields;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/jd/order/get-official-order-list";

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
        return ['pageNo','pageSize','type','childUnionId','key','startTime','endTime','fields'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->type) {
            return ['type不能为空！', false];
        }
        if (!$this->key) {
            return ['key不能为空！', false];
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
