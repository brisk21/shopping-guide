<?php

/**
 * Class GetAlbumList 专辑列表
 * Integer pageId 默认为1，支持scroll查询
 * Integer pageSize 每页记录条数：10，20，50，100
 * Integer albumType required 专辑类型：0-全部，1-官方精选，2-创作者
 * Integer sort 排序方式，0-默认排序；1-按推广量降序排列
 */
class GetAlbumList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $albumType;
    protected $sort;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/album/album-list";

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
        return ['pageId','pageSize','albumType','sort'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!in_array($this->albumType, [0,1,2])) {
            return ['albumType错误！', false];
        }
        return ['', true];
    }
}
