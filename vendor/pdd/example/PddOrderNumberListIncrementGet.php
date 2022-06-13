<?php
/**
 * 示例接口名称：pdd.order.number.list.increment.get
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddOrderNumberListIncrementGetRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddOrderNumberListIncrementGetRequest();

$request->setIsLuckyFlag(1);
$request->setOrderStatus(1);
$request->setStartUpdatedAt(1);
$request->setEndUpdatedAt(1);
$request->setPageSize(1);
$request->setPage(1);
$request->setRefundStatus(1);
$request->setTradeType(1);
$request->setUseHasNext(true);
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