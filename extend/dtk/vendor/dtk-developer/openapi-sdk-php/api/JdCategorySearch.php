<?php

/**
 * class JdCategorySearch 京东商品类目接口
 * 获取京东商品分类
 */
class JdCategorySearch extends DtkClient
{
    protected $methodType = 'GET';
    protected $requestParams = [];

    /**
     * @var int 值=0时为顶点cat_id,通过树顶级节点获取cat树
     */
    protected $parentId = 0;

    protected $level;

    const METHOD = '/api/dels/jd/category/search';

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
        return ['parentId', 'level'];
    }

    /**
     * @return array
     */
    public function check()
    {
        return ['', true];
    }
}