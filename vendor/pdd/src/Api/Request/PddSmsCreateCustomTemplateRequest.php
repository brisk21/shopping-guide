<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsCreateCustomTemplateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddSmsCreateCustomTemplateRequest_ContentItem>, "content")
	*/
	private $content;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "name", $this->name);
		$this->setUserParam($params, "content", $this->content);

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
		return "pdd.sms.create.custom.template";
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

}

class PddSmsCreateCustomTemplateRequest_ContentItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "value")
	*/
	private $value;

	/**
	* @JsonProperty(Integer, "type")
	*/
	private $type;

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

}
