<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddErpOrderSyncRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(Integer, "order_state")
	*/
	private $orderState;

	/**
	* @JsonProperty(String, "waybill_no")
	*/
	private $waybillNo;

	/**
	* @JsonProperty(Long, "logistics_id")
	*/
	private $logisticsId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "order_state", $this->orderState);
		$this->setUserParam($params, "waybill_no", $this->waybillNo);
		$this->setUserParam($params, "logistics_id", $this->logisticsId);

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
		return "pdd.erp.order.sync";
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setOrderState($orderState)
	{
		$this->orderState = $orderState;
	}

	public function setWaybillNo($waybillNo)
	{
		$this->waybillNo = $waybillNo;
	}

	public function setLogisticsId($logisticsId)
	{
		$this->logisticsId = $logisticsId;
	}

}
