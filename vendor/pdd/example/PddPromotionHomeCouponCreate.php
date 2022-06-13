<?php
/**
 * 示例接口名称：pdd.promotion.home.coupon.create
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddPromotionHomeCouponCreateRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddPromotionHomeCouponCreateRequest();

$request->setBatchDesc('str');
$request->setBatchStartTime(1);
$request->setBatchEndTime(1);
$request->setDiscount(1);
$request->setMinOrderAmount(1);
$request->setInitQuantity(1);
$request->setUserLimit(1);
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