<?php
/**
 * 示例接口名称：pdd.flight.order.create
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddFlightOrderCreateRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddFlightOrderCreateRequest();

$request->setTraceId('str');
$request->setSubTraceId('str');
$request->setTripType('str');
$request->setFlightInfoList();
$request->setPassengerInfoList();
$request->setPriceInfoList();
$request->setProductType(1);
$request->setProductId('str');
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