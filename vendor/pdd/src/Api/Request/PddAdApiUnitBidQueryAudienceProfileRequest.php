<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitBidQueryAudienceProfileRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "deliverType")
	*/
	private $deliverType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "deliverType", $this->deliverType);

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
		return "pdd.ad.api.unit.bid.query.audience.profile";
	}

	public function setDeliverType($deliverType)
	{
		$this->deliverType = $deliverType;
	}

}
