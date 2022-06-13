<?php
/**
 * 示例接口名称：pdd.flight.changeable.flight.list
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddFlightChangeableFlightListRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddFlightChangeableFlightListRequest();

$request->setTraceId('str');
$request->setSubTraceId('str');
$request->setTripType('str');
$request->setParentTravelSn('str');
$request->setOutOrderNo('str');
$request->setChangeDate('str');
$request->setPassengerInfoList();
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