<?php
/**
 * 示例接口名称：pdd.logistics.cs.message.send
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddLogisticsCsMessageSendRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddLogisticsCsMessageSendRequest();

$request->setSessionId('str');
$request->setWpSessionId('str');
$request->setActionTime('str');
$request->setMessageType(1);
$request->setText('str');
$request->setAttach('str');
$request->setPreview('str');
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