<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOpenLogisticsPreCheckRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(String, "ship_code")
	*/
	private $shipCode;

	/**
	* @JsonProperty(String, "tracking_number")
	*/
	private $trackingNumber;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "ship_code", $this->shipCode);
		$this->setUserParam($params, "tracking_number", $this->trackingNumber);

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
		return "pdd.open.logistics.pre.check";
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setShipCode($shipCode)
	{
		$this->shipCode = $shipCode;
	}

	public function setTrackingNumber($trackingNumber)
	{
		$this->trackingNumber = $trackingNumber;
	}

}
