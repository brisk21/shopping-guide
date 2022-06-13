<?php
/**
 * 示例接口名称：pdd.train.create.reserve
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddTrainCreateReserveRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddTrainCreateReserveRequest();

$request->setPddOrderId('str');
$request->setDepartStation('str');
$request->setArriveStation('str');
$request->setTrainDate('str');
$request->setTrainNo('str');
$request->setDepartTime('str');
$request->setArriveTime('str');
$request->setNoSeat(1);
$request->setChooseSeat('str');
$request->setCrhAccount('str');
$request->setCrhPassword('str');
$request->setSwitchAccount(1);
$request->setPassengerInfos();
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