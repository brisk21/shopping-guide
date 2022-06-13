<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkThemeGoodsSearchRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "theme_id")
	*/
	private $themeId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "theme_id", $this->themeId);

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
		return "pdd.ddk.theme.goods.search";
	}

	public function setThemeId($themeId)
	{
		$this->themeId = $themeId;
	}

}
