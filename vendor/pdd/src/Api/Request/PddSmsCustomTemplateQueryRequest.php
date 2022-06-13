<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsCustomTemplateQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "status")
	*/
	private $status;

	/**
	* @JsonProperty(Boolean, "order_by_status")
	*/
	private $orderByStatus;

	/**
	* @JsonProperty(Integer, "page_number")
	*/
	private $pageNumber;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Integer, "template_type")
	*/
	private $templateType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "status", $this->status);
		$this->setUserParam($params, "order_by_status", $this->orderByStatus);
		$this->setUserParam($params, "page_number", $this->pageNumber);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "template_type", $this->templateType);

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
		return "pdd.sms.custom.template.query";
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setOrderByStatus($orderByStatus)
	{
		$this->orderByStatus = $orderByStatus;
	}

	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setTemplateType($templateType)
	{
		$this->templateType = $templateType;
	}

}
