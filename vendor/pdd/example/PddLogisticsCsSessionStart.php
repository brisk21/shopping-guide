<?php
/**
 * 示例接口名称：pdd.logistics.cs.session.start
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddLogisticsCsSessionStartRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddLogisticsCsSessionStartRequest();

$request->setSessionId('str');
$request->setWpSessionId('str');
$request->setActionTime('str');
$request->setBizType(1);
$request->setDealerId('str');
$request->setQueueId('str');
$request->setQueueName('str');
$request->setQueueIndex(1);
$request->setExceptionCode(1);
$request->setExceptionMsg('str');
$request->setQueueAddress('str');
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