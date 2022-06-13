<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsCustomSettingRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "template_id")
	*/
	private $templateId;

	/**
	* @JsonProperty(List<String>, "phones")
	*/
	private $phones;

	/**
	* @JsonProperty(String, "send_time")
	*/
	private $sendTime;

	/**
	* @JsonProperty(Integer, "template_type")
	*/
	private $templateType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "template_id", $this->templateId);
		$this->setUserParam($params, "phones", $this->phones);
		$this->setUserParam($params, "send_time", $this->sendTime);
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
		return "pdd.sms.custom.setting";
	}

	public function setTemplateId($templateId)
	{
		$this->templateId = $templateId;
	}

	public function setPhones($phones)
	{
		$this->phones = $phones;
	}

	public function setSendTime($sendTime)
	{
		$this->sendTime = $sendTime;
	}

	public function setTemplateType($templateType)
	{
		$this->templateType = $templateType;
	}

}
