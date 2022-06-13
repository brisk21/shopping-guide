<?php

/**
 * Class GetOwnerGoods 我发布的商品
 * String pageId required 分页id，默认为1，支持传统的页码分页方式和scroll_id分页方式，根据用户自身需求传入值。示例1：商品入库，则首次传入1，后续传入接口返回的pageid，
 *      接口将持续返回符合条件的完整商品列表，该方式可以避免入口商品重复；示例2：根据pagesize和totalNum计算出总页数，按照需求返回指定页的商品（该方式可能在临近页取到重复商品）
 * Number pageSize required 每页条数，默认为100，最大值200，若小于10，则按10条处理，每页条数仅支持输入10,50,100,200
 * Number online 是否下架，默认为1,1-未下架商品，0-已下架商品
 * Date startTime 商品提交开始时间，请求格式：yyyy-MM-dd HH:mm:ss
 * Date endTime 商品上架结束时间，请求格式：yyyy-MM-dd HH:mm:ss
 * String sort 排序字段，默认为0，0-综合排序，1-商品上架时间从新到旧，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 */
class GetOwnerGoods extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $online;
    protected $startTime;
    protected $endTime;
    protected $sort;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-owner-goods";

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
        return ['pageId','pageSize','online','startTime','endTime','sort'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pageId) {
            return ['pageId不能为空！', false];
        }
        if (!$this->pageSize) {
            return ['pageSize不能为空！', false];
        }
        return ['', true];
    }
}
