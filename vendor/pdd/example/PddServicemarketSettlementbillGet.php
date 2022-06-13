<?php
/**
 * 示例接口名称：pdd.servicemarket.settlementbill.get
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddServicemarketSettlementbillGetRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddServicemarketSettlementbillGetRequest();

$request->setPage(1);
$request->setPageSize(1);
$request->setServiceOrderSn('str');
$request->setSettleMonth('str');
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