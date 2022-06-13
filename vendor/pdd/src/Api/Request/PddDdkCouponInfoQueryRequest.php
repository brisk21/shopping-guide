<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkCouponInfoQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<String>, "coupon_ids")
	*/
	private $couponIds;

	/**
	* @JsonProperty(List<Long>, "mall_ids")
	*/
	private $mallIds;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "coupon_ids", $this->couponIds);
		$this->setUserParam($params, "mall_ids", $this->mallIds);

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
		return "pdd.ddk.coupon.info.query";
	}

	public function setCouponIds($couponIds)
	{
		$this->couponIds = $couponIds;
	}

	public function setMallIds($mallIds)
	{
		$this->mallIds = $mallIds;
	}

}
