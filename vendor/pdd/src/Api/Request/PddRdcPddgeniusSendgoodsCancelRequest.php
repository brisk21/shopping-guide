<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddRdcPddgeniusSendgoodsCancelRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddRdcPddgeniusSendgoodsCancelRequest_Param, "param")
	*/
	private $param;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "param", $this->param);

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
		return "pdd.rdc.pddgenius.sendgoods.cancel";
	}

	public function setParam($param)
	{
		$this->param = $param;
	}

}

class PddRdcPddgeniusSendgoodsCancelRequest_Param extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "operate_time")
	*/
	private $operateTime;

	/**
	* @JsonProperty(String, "tid")
	*/
	private $tid;

	/**
	* @JsonProperty(String, "status")
	*/
	private $status;

	/**
	* @JsonProperty(Long, "refund_id")
	*/
	private $refundId;

	/**
	* @JsonProperty(Integer, "refund_fee")
	*/
	private $refundFee;

	/**
	* @JsonProperty(String, "msg")
	*/
	private $msg;

	/**
	* @JsonProperty(Integer, "fail_reason_code")
	*/
	private $failReasonCode;

	public function setOperateTime($operateTime)
	{
		$this->operateTime = $operateTime;
	}

	public function setTid($tid)
	{
		$this->tid = $tid;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setRefundId($refundId)
	{
		$this->refundId = $refundId;
	}

	public function setRefundFee($refundFee)
	{
		$this->refundFee = $refundFee;
	}

	public function setMsg($msg)
	{
		$this->msg = $msg;
	}

	public function setFailReasonCode($failReasonCode)
	{
		$this->failReasonCode = $failReasonCode;
	}

}
