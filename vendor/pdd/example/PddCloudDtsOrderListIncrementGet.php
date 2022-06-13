<?php
/**
 * 示例接口名称：pdd.cloud.dts.order.list.increment.get
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddCloudDtsOrderListIncrementGetRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddCloudDtsOrderListIncrementGetRequest();

$request->setIsLuckyFlag(1);
$request->setOrderStatus(1);
$request->setStartUpdatedAt(1);
$request->setEndUpdatedAt(1);
$request->setPageSize(1);
$request->setPage(1);
$request->setRefundStatus(1);
$request->setTradeType(1);
$request->setUseHasNext(true);
$request->setMallId(1);
$request->setExtId(1);
$request->setToken('str');
$request->setOrderSnList(array('str'));
$request->setExtendProps('str');
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