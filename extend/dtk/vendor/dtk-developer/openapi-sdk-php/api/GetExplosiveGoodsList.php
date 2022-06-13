<?php

/**
 * Class GetExplosiveGoodsList 每日爆品推荐
 * Integer pageId required 分页id
 * Integer pageSize required 每页返回条数，每页条数支持输入10,20，50,100。默认50条
 * String PriceCid 价格区间，1表示10~20元区；2表示20~40元区；3表示40元以上区；默认为1
 * String cids 大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”。1 -女装，2 -母婴，3 -美妆，4 -居家日用，5 -鞋品，6 -美食，7 -文娱车品，
 *      8 -数码家电，9 -男装，10 -内衣，11 -箱包，12 -配饰，13 -户外运动，14 -家装家纺。不填默认全部
 */
class GetExplosiveGoodsList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $PriceCid;
    protected $cids;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/explosive-goods-list";

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
        return ['pageId','pageSize','PriceCid','cids'];
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
