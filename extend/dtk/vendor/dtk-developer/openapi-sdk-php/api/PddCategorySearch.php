<?php

/**
 * class PddCategorySearch 拼多多商品类目接口
 * 获取拼多多商品分类
 */
class PddCategorySearch extends DtkClient
{
    protected $methodType = 'GET';
    protected $requestParams = [];

    /**
     * @var int 值=0时为顶点cat_id,通过树顶级节点获取cat树
     */
    protected $parentId = 0;


    const METHOD = '/api/dels/pdd/category/search';

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
        return ['parentId'];
    }

    /**
     * @return array
     */
    public function check()
    {
        return ['', true];
    }
}