<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddInvoiceApplicationUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "application_id")
	*/
	private $applicationId;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(Integer, "status")
	*/
	private $status;

	/**
	* @JsonProperty(String, "reason")
	*/
	private $reason;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "application_id", $this->applicationId);
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "status", $this->status);
		$this->setUserParam($params, "reason", $this->reason);

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
		return "pdd.invoice.application.update";
	}

	public function setApplicationId($applicationId)
	{
		$this->applicationId = $applicationId;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setReason($reason)
	{
		$this->reason = $reason;
	}

}
