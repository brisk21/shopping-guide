<?php
/**
 * 示例接口名称：pdd.flight.callback.confirm.change
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackConfirmChangeRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddFlightCallbackConfirmChangeRequest();

$request->setChangeTime('str');
$request->setChangeType(1);
$request->setErrorCode(1);
$request->setErrorMsg('str');
$request->setOutChangeNo('str');
$request->setOutOrderNo('str');
$request->setParentTravelSn('str');
$request->setPassengerInfoList();
$request->setSubTraceId('str');
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