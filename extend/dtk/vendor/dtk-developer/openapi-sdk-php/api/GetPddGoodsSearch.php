<?php

/**
 * Class GetPddGoodsSearch 拼多多联盟搜索
 * String activityTags 活动商品标记数组，例：[4,7]， 4-秒杀，7-百亿补贴，31-品牌黑标，10564-精选爆品-官方直推爆款，10584-精选爆品-团长推荐， 24-品牌高佣，
 *      20-行业精选，21-金牌商家，10044-潜力爆品，10475-爆品上新，其他的值请忽略
 * String blockCats 自定义屏蔽一级/二级/三级类目ID，自定义数量不超过20个
 * String blockCatPackages 屏蔽商品类目包：1-拼多多小程序屏蔽的类目&关键词;2-虚拟类目;3-医疗器械;4-处方药;5-非处方药
 * Integer catId 商品类目ID
 * String goodsSignList 商品goodsSign列表 访问括号内链接可查看字段相关说明(http://www.dataoke.com/kfpt/open-gz.html?id=100)
 * Integer isBrandGoods 是否为品牌商品
 * String keyword 商品关键词(暂不支持goodid进行搜索，如需定向搜索商品建议使用goodsign进行搜索)
 * String listId 翻页时建议填写前页返回的list_id值
 * String merchantTypeList 店铺类型数组 1-个人，2-企业，3-旗舰店，4-专卖店，5-专营店，6-普通店（未传为全部）
 * Integer optId 商品标签类目ID
 * Integer page 默认值1，商品分页数
 * Integer pageSize 默认100，每页商品数量
 * String rangeList 筛选范围列表 样例：[{"range_id":0,"range_from":1,"range_to":1500}, {"range_id":1,"range_from":1,"range_to":1500}]
 * Integer sortType 排序方式:0-综合排序;2-按佣金比例降序;3-按价格升序;4-按价格降序;6-按销量降序;9-券后价升序排序;10-券后价降序排序;16-店铺描述评分降序
 * Integer withCoupon 是否只返回优惠券的商品，0返回所有商品，1只返回有优惠券的商品
 */
class GetPddGoodsSearch extends DtkClient
{
    protected $activityTags;
    protected $blockCats;
    protected $blockCatPackages;
    protected $catId;
    protected $goodsSignList;
    protected $isBrandGoods;
    protected $keyword;
    protected $listId;
    protected $merchantTypeList;
    protected $optId;
    protected $page;
    protected $pageSize;
    protected $rangeList;
    protected $sortType;
    protected $withCoupon;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/pdd/goods/search";

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
        return [
            'activityTags','blockCats','blockCatPackages','catId','goodsSignList','isBrandGoods','keyword','listId','merchantTypeList',
            'optId','page','pageSize','rangeList','sortType','withCoupon', 'withCategoryInfo'];
    }

    /**
     * @return array
     */
    public function check()
    {
        return ['', true];
    }
}
