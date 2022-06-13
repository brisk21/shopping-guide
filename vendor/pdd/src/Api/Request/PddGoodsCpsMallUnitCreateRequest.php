<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsCpsMallUnitCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "rate")
	*/
	private $rate;

	/**
	* @JsonProperty(String, "erp_code")
	*/
	private $erpCode;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "rate", $this->rate);
		$this->setUserParam($params, "erp_code", $this->erpCode);

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
		return "pdd.goods.cps.mall.unit.create";
	}

	public function setRate($rate)
	{
		$this->rate = $rate;
	}

	public function setErpCode($erpCode)
	{
		$this->erpCode = $erpCode;
	}

}
