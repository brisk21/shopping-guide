<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsSendRecordListQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Long>, "scene")
	*/
	private $scene;

	/**
	* @JsonProperty(String, "start_time")
	*/
	private $startTime;

	/**
	* @JsonProperty(String, "end_time")
	*/
	private $endTime;

	/**
	* @JsonProperty(Integer, "status")
	*/
	private $status;

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
		$this->setUserParam($params, "scene", $this->scene);
		$this->setUserParam($params, "start_time", $this->startTime);
		$this->setUserParam($params, "end_time", $this->endTime);
		$this->setUserParam($params, "status", $this->status);
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
		return "pdd.sms.send.record.list.query";
	}

	public function setScene($scene)
	{
		$this->scene = $scene;
	}

	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setStatus($status)
	{
		$this->status = $status;
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
