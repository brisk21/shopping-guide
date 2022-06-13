<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsSellRecordListQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "status")
	*/
	private $status;

	/**
	* @JsonProperty(Integer, "order_by_send_time")
	*/
	private $orderBySendTime;

	/**
	* @JsonProperty(Integer, "page_number")
	*/
	private $pageNumber;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "status", $this->status);
		$this->setUserParam($params, "order_by_send_time", $this->orderBySendTime);
		$this->setUserParam($params, "page_number", $this->pageNumber);
		$this->setUserParam($params, "page_size", $this->pageSize);

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
		return "pdd.sms.sell.record.list.query";
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setOrderBySendTime($orderBySendTime)
	{
		$this->orderBySendTime = $orderBySendTime;
	}

	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

}
