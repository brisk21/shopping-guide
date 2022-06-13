<?php
/**
 * 示例接口名称：pdd.train.create.otcbook
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddTrainCreateOtcbookRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddTrainCreateOtcbookRequest();

$request->setDepartStation('str');
$request->setArriveStation('str');
$request->setTrainDate('str');
$request->setTrainNo('str');
$request->setDepartTime('str');
$request->setArriveTime('str');
$request->setAcceptOtherSeat(1);
$request->setAcceptStandSeat(1);
$request->setPddOrderId('str');
$request->setOtcChooseSeat();
$request->setPassengerInfos();
$request->setRequestId('str');
$request->setComment('str');
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