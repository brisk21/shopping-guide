<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkLiveDetailRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "goods_page")
	*/
	private $goodsPage;

	/**
	* @JsonProperty(Integer, "goods_page_size")
	*/
	private $goodsPageSize;

	/**
	* @JsonProperty(Boolean, "need_goods_info")
	*/
	private $needGoodsInfo;

	/**
	* @JsonProperty(String, "room_id")
	*/
	private $roomId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goods_page", $this->goodsPage);
		$this->setUserParam($params, "goods_page_size", $this->goodsPageSize);
		$this->setUserParam($params, "need_goods_info", $this->needGoodsInfo);
		$this->setUserParam($params, "room_id", $this->roomId);

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
		return "pdd.ddk.live.detail";
	}

	public function setGoodsPage($goodsPage)
	{
		$this->goodsPage = $goodsPage;
	}

	public function setGoodsPageSize($goodsPageSize)
	{
		$this->goodsPageSize = $goodsPageSize;
	}

	public function setNeedGoodsInfo($needGoodsInfo)
	{
		$this->needGoodsInfo = $needGoodsInfo;
	}

	public function setRoomId($roomId)
	{
		$this->roomId = $roomId;
	}

}
