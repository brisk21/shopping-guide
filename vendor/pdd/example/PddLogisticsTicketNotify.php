<?php
/**
 * 示例接口名称：pdd.logistics.ticket.notify
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddLogisticsTicketNotifyRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddLogisticsTicketNotifyRequest();

$request->setAttachPathList(array('str'));
$request->setTicketId(1);
$request->setWaybillNo('str');
$request->setHandleResult('str');
$request->setSignState(1);
$request->setCompensateState(1);
$request->setCompensateAmount(1);
$request->setDuty(1);
$request->setExpressDealer('str');
$request->setExpressDealerContact('str');
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