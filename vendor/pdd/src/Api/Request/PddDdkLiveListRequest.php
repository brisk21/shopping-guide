<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkLiveListRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "goods_page_size")
	*/
	private $goodsPageSize;

	/**
	* @JsonProperty(Boolean, "need_goods_info")
	*/
	private $needGoodsInfo;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goods_page_size", $this->goodsPageSize);
		$this->setUserParam($params, "need_goods_info", $this->needGoodsInfo);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);

	}

	public function getVersion()
	{
		return "V1";
	}

	public function getDataType()
	{
		return "JSON";
	}

	public function getType()
	{
		return "pdd.ddk.live.list";
	}

	public function setGoodsPageSize($goodsPageSize)
	{
		$this->goodsPageSize = $goodsPageSize;
	}

	public function setNeedGoodsInfo($needGoodsInfo)
	{
		$this->needGoodsInfo = $needGoodsInfo;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

}
