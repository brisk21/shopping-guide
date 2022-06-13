<?php

/**
 * Class GetCollectionList 我的收藏
 * String pageId required 默认为1，支持传统的页码分页方式和scroll_id分页方式，根据用户自身需求传入值。示例1：商品入库，则首次传入1，后续传入接口返回的pageid，
 *      接口将持续返回符合条件的完整商品列表，该方式可以避免入口商品重复；示例2：根据pagesize和totalNum计算出总页数，按照需求返回指定页的商品（该方式可能在临近页取到重复商品）
 * Number pageSize 每页条数，默认为100，最大值200，若小于10，则按10条处理，每页条数仅支持输入10,50,100,200
 * String cid required 商品在大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”。当一级类目id和二级类目id同时传入时，会自动忽略二级类目id，1 -女装，2 -母婴，
 *      3 -美妆，4 -居家日用，5 -鞋品，6 -美食，7 -文娱车品，8 -数码家电，9 -男装，10 -内衣，11 -箱包，12 -配饰，13 -户外运动，14 -家装家纺
 * Number trailerType 是否返回预告商品，1为预告商品，0为在线商品，不填则全部商品
 * String sort 排序字段，默认为0，0-综合排序，1-商品上架时间从高到低，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
 * Number collectionTimeOrder 加入收藏时间
 */
class GetCollectionList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $cid;
    protected $trailerType;
    protected $sort;
    protected $collectionTimeOrder;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-collection-list";

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
        return ['pageId','pageSize','cid','trailerType','sort','collectionTimeOrder'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->pageId) {
            return ['pageId不能为空！', false];
        }
        if (!$this->cid) {
            return ['cid不能为空！', false];
        }
        return ['', true];
    }
}
