<?php
/**
 * 示例接口名称：pdd.train.change.ticket
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddTrainChangeTicketRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddTrainChangeTicketRequest();

$request->setPddOrderId('str');
$request->setOrderId('str');
$request->setNewDepartStation('str');
$request->setNewArriveStation('str');
$request->setNewTrainDate('str');
$request->setNewTrainNo('str');
$request->setNewDepartTime('str');
$request->setNewArriveTime('str');
$request->setNewSeatType(1);
$request->setNewChooseSeat('str');
$request->setNewPassengerInfos();
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