<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsCrowdsPeopleNumberQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "crowd_id")
	*/
	private $crowdId;

	/**
	* @JsonProperty(Integer, "location_type")
	*/
	private $locationType;

	/**
	* @JsonProperty(List<Long>, "location")
	*/
	private $location;

	/**
	* @JsonProperty(Integer, "gender")
	*/
	private $gender;

	/**
	* @JsonProperty(Long, "purchase_days")
	*/
	private $purchaseDays;

	/**
	* @JsonProperty(Long, "none_purchase_days")
	*/
	private $nonePurchaseDays;

	/**
	* @JsonProperty(Long, "goods_favor_days")
	*/
	private $goodsFavorDays;

	/**
	* @JsonProperty(Long, "mall_favor_days")
	*/
	private $mallFavorDays;

	/**
	* @JsonProperty(Long, "min_order_count")
	*/
	private $minOrderCount;

	/**
	* @JsonProperty(Long, "max_order_count")
	*/
	private $maxOrderCount;

	/**
	* @JsonProperty(String, "first_buy_start_time")
	*/
	private $firstBuyStartTime;

	/**
	* @JsonProperty(String, "first_buy_end_time")
	*/
	private $firstBuyEndTime;

	/**
	* @JsonProperty(Long, "mall_visit_days")
	*/
	private $mallVisitDays;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "crowd_id", $this->crowdId);
		$this->setUserParam($params, "location_type", $this->locationType);
		$this->setUserParam($params, "location", $this->location);
		$this->setUserParam($params, "gender", $this->gender);
		$this->setUserParam($params, "purchase_days", $this->purchaseDays);
		$this->setUserParam($params, "none_purchase_days", $this->nonePurchaseDays);
		$this->setUserParam($params, "goods_favor_days", $this->goodsFavorDays);
		$this->setUserParam($params, "mall_favor_days", $this->mallFavorDays);
		$this->setUserParam($params, "min_order_count", $this->minOrderCount);
		$this->setUserParam($params, "max_order_count", $this->maxOrderCount);
		$this->setUserParam($params, "first_buy_start_time", $this->firstBuyStartTime);
		$this->setUserParam($params, "first_buy_end_time", $this->firstBuyEndTime);
		$this->setUserParam($params, "mall_visit_days", $this->mallVisitDays);

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
		return "pdd.sms.crowds.people.number.query";
	}

	public function setCrowdId($crowdId)
	{
		$this->crowdId = $crowdId;
	}

	public function setLocationType($locationType)
	{
		$this->locationType = $locationType;
	}

	public function setLocation($location)
	{
		$this->location = $location;
	}

	public function setGender($gender)
	{
		$this->gender = $gender;
	}

	public function setPurchaseDays($purchaseDays)
	{
		$this->purchaseDays = $purchaseDays;
	}

	public function setNonePurchaseDays($nonePurchaseDays)
	{
		$this->nonePurchaseDays = $nonePurchaseDays;
	}

	public function setGoodsFavorDays($goodsFavorDays)
	{
		$this->goodsFavorDays = $goodsFavorDays;
	}

	public function setMallFavorDays($mallFavorDays)
	{
		$this->mallFavorDays = $mallFavorDays;
	}

	public function setMinOrderCount($minOrderCount)
	{
		$this->minOrderCount = $minOrderCount;
	}

	public function setMaxOrderCount($maxOrderCount)
	{
		$this->maxOrderCount = $maxOrderCount;
	}

	public function setFirstBuyStartTime($firstBuyStartTime)
	{
		$this->firstBuyStartTime = $firstBuyStartTime;
	}

	public function setFirstBuyEndTime($firstBuyEndTime)
	{
		$this->firstBuyEndTime = $firstBuyEndTime;
	}

	public function setMallVisitDays($mallVisitDays)
	{
		$this->mallVisitDays = $mallVisitDays;
	}

}
