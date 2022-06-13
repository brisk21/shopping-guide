<?php

/**
 * Class GetAlbumGoodsList 单个专辑商品列表
 * Integer albumId required 专辑id
 */
class GetAlbumGoodsList extends DtkClient
{
    protected $albumId;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/album/goods-list";

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
        return ['albumId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->albumId) {
            return ['albumId错误！', false];
        }
        return ['', true];
    }
}
