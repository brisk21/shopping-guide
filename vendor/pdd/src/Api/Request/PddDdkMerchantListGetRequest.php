<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkMerchantListGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "cat_id")
	*/
	private $catId;

	/**
	* @JsonProperty(Boolean, "has_clt_cpn")
	*/
	private $hasCltCpn;

	/**
	* @JsonProperty(Integer, "has_coupon")
	*/
	private $hasCoupon;

	/**
	* @JsonProperty(List<Long>, "mall_id_list")
	*/
	private $mallIdList;

	/**
	* @JsonProperty(List<Integer>, "merchant_type_list")
	*/
	private $merchantTypeList;

	/**
	* @JsonProperty(Integer, "page_number")
	*/
	private $pageNumber;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Integer, "query_range_str")
	*/
	private $queryRangeStr;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddDdkMerchantListGetRequest_RangeVoListItem>, "range_vo_list")
	*/
	private $rangeVoList;

	/**
	* @JsonProperty(String, "pid")
	*/
	private $pid;

	/**
	* @JsonProperty(String, "custom_parameters")
	*/
	private $customParameters;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "cat_id", $this->catId);
		$this->setUserParam($params, "has_clt_cpn", $this->hasCltCpn);
		$this->setUserParam($params, "has_coupon", $this->hasCoupon);
		$this->setUserParam($params, "mall_id_list", $this->mallIdList);
		$this->setUserParam($params, "merchant_type_list", $this->merchantTypeList);
		$this->setUserParam($params, "page_number", $this->pageNumber);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "query_range_str", $this->queryRangeStr);
		$this->setUserParam($params, "range_vo_list", $this->rangeVoList);
		$this->setUserParam($params, "pid", $this->pid);
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
		return "pdd.ddk.merchant.list.get";
	}

	public function setCatId($catId)
	{
		$this->catId = $catId;
	}

	public function setHasCltCpn($hasCltCpn)
	{
		$this->hasCltCpn = $hasCltCpn;
	}

	public function setHasCoupon($hasCoupon)
	{
		$this->hasCoupon = $hasCoupon;
	}

	public function setMallIdList($mallIdList)
	{
		$this->mallIdList = $mallIdList;
	}

	public function setMerchantTypeList($merchantTypeList)
	{
		$this->merchantTypeList = $merchantTypeList;
	}

	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setQueryRangeStr($queryRangeStr)
	{
		$this->queryRangeStr = $queryRangeStr;
	}

	public function setRangeVoList($rangeVoList)
	{
		$this->rangeVoList = $rangeVoList;
	}

	public function setPid($pid)
	{
		$this->pid = $pid;
	}

	public function setCustomParameters($customParameters)
	{
		$this->customParameters = $customParameters;
	}

}

class PddDdkMerchantListGetRequest_RangeVoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "range_from")
	*/
	private $rangeFrom;

	/**
	* @JsonProperty(String, "range_id")
	*/
	private $rangeId;

	/**
	* @JsonProperty(String, "range_to")
	*/
	private $rangeTo;

	public function setRangeFrom($rangeFrom)
	{
		$this->rangeFrom = $rangeFrom;
	}

	public function setRangeId($rangeId)
	{
		$this->rangeId = $rangeId;
	}

	public function setRangeTo($rangeTo)
	{
		$this->rangeTo = $rangeTo;
	}

}
