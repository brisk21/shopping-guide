<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsShortStatisticQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "setting_id")
	*/
	private $settingId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "setting_id", $this->settingId);

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
		return "pdd.sms.short.statistic.query";
	}

	public function setSettingId($settingId)
	{
		$this->settingId = $settingId;
	}

}
