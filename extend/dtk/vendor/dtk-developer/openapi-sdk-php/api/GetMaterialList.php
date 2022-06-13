<?php

/**
 * Class GetMaterialList 商品精推素材
 * String id required  大淘客商品id或联盟商品id
 */
class GetMaterialList extends DtkClient
{
    protected $id;
    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/material/list";

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
        return ['id'];
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
