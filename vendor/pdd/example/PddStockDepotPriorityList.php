<?php
/**
 * 示例接口名称：pdd.stock.depot.priority.list
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddStockDepotPriorityListRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddStockDepotPriorityListRequest();

$request->setProvinceId(1);
$request->setCityId(1);
$request->setDistrictId(1);
$request->setDepotCode('str');
$request->setPageSize(1);
$request->setPageNum(1);
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