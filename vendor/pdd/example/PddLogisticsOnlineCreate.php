<?php
/**
 * 示例接口名称：pdd.logistics.online.create
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddLogisticsOnlineCreateRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddLogisticsOnlineCreateRequest();

$request->setTrackingNumber('str');
$request->setShippingId(1);
$request->setReturnId('str');
$request->setDeliveryPhone('str');
$request->setDeliveryName('str');
$request->setDeliveryAddress('str');
$request->setDeliveryId('str');
$request->setOrderSn('str');
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