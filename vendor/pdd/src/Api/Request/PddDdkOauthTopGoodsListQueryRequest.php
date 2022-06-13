<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkOauthTopGoodsListQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "limit")
	*/
	private $limit;

	/**
	* @JsonProperty(String, "list_id")
	*/
	private $listId;

	/**
	* @JsonProperty(Integer, "offset")
	*/
	private $offset;

	/**
	* @JsonProperty(String, "p_id")
	*/
	private $pId;

	/**
	* @JsonProperty(Integer, "sort_type")
	*/
	private $sortType;

	/**
	* @JsonProperty(String, "custom_parameters")
	*/
	private $customParameters;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "limit", $this->limit);
		$this->setUserParam($params, "list_id", $this->listId);
		$this->setUserParam($params, "offset", $this->offset);
		$this->setUserParam($params, "p_id", $this->pId);
		$this->setUserParam($params, "sort_type", $this->sortType);
		$this->setUserParam($params, "custom_parameters", $this->customParameters);

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
		return "pdd.ddk.oauth.top.goods.list.query";
	}

	public function setLimit($limit)
	{
		$this->limit = $limit;
	}

	public function setListId($listId)
	{
		$this->listId = $listId;
	}

	public function setOffset($offset)
	{
		$this->offset = $offset;
	}

	public function setPId($pId)
	{
		$this->pId = $pId;
	}

	public function setSortType($sortType)
	{
		$this->sortType = $sortType;
	}

	public function setCustomParameters($customParameters)
	{
		$this->customParameters = $customParameters;
	}

}
