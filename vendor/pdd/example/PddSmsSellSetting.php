<?php
/**
 * 示例接口名称：pdd.sms.sell.setting
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddSmsSellSettingRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddSmsSellSettingRequest();

$request->setScene(1);
$request->setCrowdId(1);
$request->setSendTime('str');
$request->setTemplateId(1);
$request->setTemplateType(1);
try{
	$response = $client->syncInvoke($request);
} catch(Com\Pdd\Pop\Sdk\PopHttpException $e){
	echo $e->getMessage();
	exit;
}
$content = $response->getContent();
if(isset($content['error_response'])){
	echo "异常返回";
}
echo json_encode($content,JSON_UNESCAPED_UNICODE);