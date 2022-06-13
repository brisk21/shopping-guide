<?php

/**
 * Class GetJdListNines 京东9.9包邮
 * Integer pageId 页码（默认为1）
 * Integer pageSize 每页记录条数（默认20）
 * Integer sort required 排序：0-综合排序；1-价格升序；2-价格降序
 */
class GetJdListNines extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $sort;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/dels/jd/column/list-nines";

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
        return ['pageId','pageSize','sort'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!in_array($this->sort, [0,1,2])) {
            return ['sort错误！', false];
        }
        return ['', true];
    }
}
