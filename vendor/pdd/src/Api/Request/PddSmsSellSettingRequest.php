<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsSellSettingRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "scene")
	*/
	private $scene;

	/**
	* @JsonProperty(Long, "crowd_id")
	*/
	private $crowdId;

	/**
	* @JsonProperty(String, "send_time")
	*/
	private $sendTime;

	/**
	* @JsonProperty(Integer, "template_id")
	*/
	private $templateId;

	/**
	* @JsonProperty(Integer, "template_type")
	*/
	private $templateType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "scene", $this->scene);
		$this->setUserParam($params, "crowd_id", $this->crowdId);
		$this->setUserParam($params, "send_time", $this->sendTime);
		$this->setUserParam($params, "template_id", $this->templateId);
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
		return "pdd.sms.sell.setting";
	}

	public function setScene($scene)
	{
		$this->scene = $scene;
	}

	public function setCrowdId($crowdId)
	{
		$this->crowdId = $crowdId;
	}

	public function setSendTime($sendTime)
	{
		$this->sendTime = $sendTime;
	}

	public function setTemplateId($templateId)
	{
		$this->templateId = $templateId;
	}

	public function setTemplateType($templateType)
	{
		$this->templateType = $templateType;
	}

}
