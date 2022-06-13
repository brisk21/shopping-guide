<?php
/**
 * 示例接口名称：pdd.train.callback.reserve
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddTrainCallbackReserveRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddTrainCallbackReserveRequest();

$request->setArriveDate('str');
$request->setArriveStation('str');
$request->setArriveTime('str');
$request->setCode(1);
$request->setCrhOrder('str');
$request->setDepartDate('str');
$request->setDepartStation('str');
$request->setDepartTime('str');
$request->setMsg('str');
$request->setOrderId('str');
$request->setPassengers();
$request->setPayLimitTime('str');
$request->setPddOrderId('str');
$request->setRequestId('str');
$request->setTrainNo('str');
$request->setUseIdCardIn(1);
$request->setVendorTime('str');
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