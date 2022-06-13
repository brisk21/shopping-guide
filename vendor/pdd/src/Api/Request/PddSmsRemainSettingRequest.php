<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsRemainSettingRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "unpaid_duration")
	*/
	private $unpaidDuration;

	/**
	* @JsonProperty(String, "template_id")
	*/
	private $templateId;

	/**
	* @JsonProperty(Integer, "open")
	*/
	private $open;

	/**
	* @JsonProperty(Integer, "scene")
	*/
	private $scene;

	/**
	* @JsonProperty(Integer, "operate_type")
	*/
	private $operateType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "unpaid_duration", $this->unpaidDuration);
		$this->setUserParam($params, "template_id", $this->templateId);
		$this->setUserParam($params, "open", $this->open);
		$this->setUserParam($params, "scene", $this->scene);
		$this->setUserParam($params, "operate_type", $this->operateType);

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
		return "pdd.sms.remain.setting";
	}

	public function setUnpaidDuration($unpaidDuration)
	{
		$this->unpaidDuration = $unpaidDuration;
	}

	public function setTemplateId($templateId)
	{
		$this->templateId = $templateId;
	}

	public function setOpen($open)
	{
		$this->open = $open;
	}

	public function setScene($scene)
	{
		$this->scene = $scene;
	}

	public function setOperateType($operateType)
	{
		$this->operateType = $operateType;
	}

}
