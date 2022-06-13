<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkFinanceCpaQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "date_query")
	*/
	private $dateQuery;

	/**
	* @JsonProperty(String, "pid")
	*/
	private $pid;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "date_query", $this->dateQuery);
		$this->setUserParam($params, "pid", $this->pid);

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
		return "pdd.ddk.finance.cpa.query";
	}

	public function setDateQuery($dateQuery)
	{
		$this->dateQuery = $dateQuery;
	}

	public function setPid($pid)
	{
		$this->pid = $pid;
	}

}
