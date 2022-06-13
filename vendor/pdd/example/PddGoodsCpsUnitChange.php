<?php
/**
 * 示例接口名称：pdd.goods.cps.unit.change
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddGoodsCpsUnitChangeRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddGoodsCpsUnitChangeRequest();

$request->setGoodsId(1);
$request->setRate(1);
$request->setCouponId(1);
$request->setCouponStartTime('str');
$request->setCouponEndTime('str');
$request->setDiscount(1);
$request->setInitQuantity(1);
$request->setRemainQuantity(1);
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