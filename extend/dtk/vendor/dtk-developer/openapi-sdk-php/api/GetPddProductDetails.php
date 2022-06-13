<?php
/**
 * Class GetPddProductDetails 拼多多商品详情
 * 应用场景：当用户点击某个拼多多商品时，调用该接口。获取对应商品的详细信息
 * 接口说明：通过拼多多商品goodsSign，获取指定商品的详细详细数据（商品价格，优惠券信息，详情图，主图……）
 */
class GetPddProductDetails extends DtkClient
{

    protected $methodType = 'GET';
    protected $requestParams = [];

    /**
     * @var string 商品goodsSign，支持通过goodsSign查询商品。goodsSign是加密后的goodsId, goodsId已下线，请使用goodsSign来替代。
     * 使用说明：https://jinbao.pinduoduo.com/qa-system?questionId=252
     */
    protected $goodsSign;

    /**
     * @var integer 搜索id，建议填写，可提高收益。
     * 可通过pdd.ddk.goods.recommend.get、pdd.ddk.goods.search、pdd.ddk.top.goods.list.query等接口获取
     */
    protected $searchId;

    /**
     * @var integer 商品主图类型：1-场景图，2-白底图，默认为0
     */
    protected $goodsImgType;

    const METHOD = '/api/dels/pdd/goods/detail';

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
        return ['goodsSign', 'searchId', 'goodsImgType'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->goodsSign) {
            return ['goodsSign不能为空！', false];
        }
        return ['', true];
    }
}