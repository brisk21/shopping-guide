<?php

/**
 * Class GetRankingList 各大榜单
 * Integer pageId 分页id
 * Integer pageSize 每页条数返回条数（支持10,20.50，默认返回20条）
 * Integer cid 大淘客一级类目id
 * Integer rankType required 榜单类型，1.实时榜 2.全天榜 3.热推榜 4.复购榜 5.热词飙升榜 6.热词排行榜 7.综合热搜榜
 */
class GetRankingList extends DtkClient
{
    protected $pageId;
    protected $pageSize;
    protected $cid;
    protected $rankType;

    protected $methodType = 'GET';
    protected $requestParams = [];

    const METHOD = "/api/goods/get-ranking-list";

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
        return ['pageId','pageSize','cid','rankType'];
    }

    /**
     * @return array
     */
    public function check()
    {
        if (!$this->rankType) {
            return ['rankType不能为空！', false];
        }
        return ['', true];
    }
}
