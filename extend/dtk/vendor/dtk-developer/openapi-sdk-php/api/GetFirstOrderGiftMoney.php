<?php

/**
 * Class GetFirstOrderGiftMoney 首单礼金商品
 * Number pageSize required 每页返回条数，每页条数支持输入10,20，50,100,200
 * String pageId required 分页id：常规分页方式，请直接传入对应页码（比如：1,2,3……）
 * String cids 大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”。1 -女装，2 -母婴，3 -美妆，4 -居家日用，5 -鞋品，6 -美食，
 *      7 -文娱车品，8 -数码家电，9 -男装，10 -内衣，11 -箱包，12 -配饰，13 -户外运动，14 -家装家纺
 * String sort 排序方式，默认为0，0-综合排序，1-商品上架时间从高到低，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 * String keyWord 输入关键词搜索
 * Number goodsType 商品类型1表示大淘客商品2表示联盟商品。默认为1
 */
class GetFirstOrderGiftMoney extends DtkClient
{
    protected $pageSize;
    protected $pageId;
    protected $cids;
    protected $sort;
    protected $keyWord;
    protected $goodsType;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/first-order-gift-money";

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
        return ['pageSize','pageId','cids','sort','keyWord','goodsType'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pageSize) {
            return ['pageSize不能为空！', false];
        }
        if (!$this->pageId) {
            return ['pageId不能为空！', false];
        }
        return ['', true];
    }
}
