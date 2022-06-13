<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKttOrderLogisticCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "logisticsId")
	*/
	private $logisticsId;

	/**
	* @JsonProperty(String, "logisticsName")
	*/
	private $logisticsName;

	/**
	* @JsonProperty(String, "orderSn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(String, "waybillNo")
	*/
	private $waybillNo;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "logisticsId", $this->logisticsId);
		$this->setUserParam($params, "logisticsName", $this->logisticsName);
		$this->setUserParam($params, "orderSn", $this->orderSn);
		$this->setUserParam($params, "waybillNo", $this->waybillNo);

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
		return "pdd.ktt.order.logistic.create";
	}

	public function setLogisticsId($logisticsId)
	{
		$this->logisticsId = $logisticsId;
	}

	public function setLogisticsName($logisticsName)
	{
		$this->logisticsName = $logisticsName;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setWaybillNo($waybillNo)
	{
		$this->waybillNo = $waybillNo;
	}

}
