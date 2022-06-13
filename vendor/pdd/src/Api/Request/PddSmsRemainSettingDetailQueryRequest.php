<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsRemainSettingDetailQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "scene")
	*/
	private $scene;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "scene", $this->scene);

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
		return "pdd.sms.remain.setting.detail.query";
	}

	public function setScene($scene)
	{
		$this->scene = $scene;
	}

}
