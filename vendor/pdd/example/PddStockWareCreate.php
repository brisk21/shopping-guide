<?php
/**
 * 示例接口名称：pdd.stock.ware.create
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddStockWareCreateRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddStockWareCreateRequest();

$request->setWareType(1);
$request->setWareInfos();
$request->setWareSn('str');
$request->setWareName('str');
$request->setNote('str');
$request->setServiceQuality(1);
$request->setVolume(1);
$request->setLength(1);
$request->setWidth(1);
$request->setHeight(1);
$request->setWeight(1);
$request->setGrossWeight(1);
$request->setNetWeight(1);
$request->setTareWeight(1);
$request->setPrice(1);
$request->setColor('str');
$request->setPacking('str');
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