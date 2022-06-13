<?php
/**
 * 示例接口名称：pdd.vas.order.search
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddVasOrderSearchRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddVasOrderSearchRequest();

$request->setCreateTimeEnd(1);
$request->setCreateTimeStart(1);
$request->setMallId(1);
$request->setOrderSn('str');
$request->setOrderStatus(1);
$request->setPage(1);
$request->setPageSize(1);
$request->setPayTimeEnd(1);
$request->setPayTimeStart(1);
$request->setSkuId(1);
$request->setRefundStatus(1);
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