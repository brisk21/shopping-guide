<?php

/**
 * Class GetCommentList 商品评论
 * Integer id required 大淘客商品id（id和goodsid其中一个必填）
 * String goodsId 淘宝商品id（id和goodsid其中一个必填）
 * Integer type 默认：0-全部 评论类型：0-全部；1-含图；2-含视频；
 * Integer sort 排序方式 0-按热度排序 1-按最新添加排序 默认为0
 * Integer haopingType 评论类型 0-全部 1-去掉默认好评 默认为0(2020/12/30新增字段)
 */
class GetCommentList extends DtkClient
{
    protected $id;
    protected $goodsId;
    protected $type;
    protected $sort;
    protected $haopingType;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/comment/get-comment-list";

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
        return ['id','goodsId','type','sort','haopingType'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->id) {
            return ['id不能为空！', false];
        }
        return ['', true];
    }
}
