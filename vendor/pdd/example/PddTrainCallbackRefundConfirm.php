<?php
/**
 * 示例接口名称：pdd.train.callback.refund.confirm
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddTrainCallbackRefundConfirmRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddTrainCallbackRefundConfirmRequest();

$request->setCardNo('str');
$request->setCode(1);
$request->setMsg('str');
$request->setName('str');
$request->setPddOrderId('str');
$request->setRefundMoney(1);
$request->setRefundType(1);
$request->setRequestId('str');
$request->setSubOrderId('str');
$request->setSubPddOrderId('str');
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