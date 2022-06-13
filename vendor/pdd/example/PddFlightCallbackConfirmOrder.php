<?php
/**
 * 示例接口名称：pdd.flight.callback.confirm.order
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackConfirmOrderRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddFlightCallbackConfirmOrderRequest();

$request->setErrorCode(1);
$request->setErrorMsg('str');
$request->setFlightInfoList();
$request->setOutOrderNo('str');
$request->setParentTravelSn('str');
$request->setPassengerInfoList();
$request->setTicketStatus(1);
$request->setTicketTime('str');
$request->setTotalAirportTax(1);
$request->setTotalFuelTax(1);
$request->setTotalPay(1);
$request->setTotalSettlePrice(1);
$request->setTraceId('str');
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