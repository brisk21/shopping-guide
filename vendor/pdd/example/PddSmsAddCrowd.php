<?php
/**
 * 示例接口名称：pdd.sms.add.crowd
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddSmsAddCrowdRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddSmsAddCrowdRequest();

$request->setLocation(array(1));
$request->setLocationType(1);
$request->setGender(1);
$request->setGoodsFavorDays(1);
$request->setMallFavorDays(1);
$request->setName('str');
$request->setNonePurchaseDays(1);
$request->setPurchaseDays(1);
$request->setMinOrderCount(1);
$request->setMaxOrderCount(1);
$request->setFirstBuyStartTime('str');
$request->setFirstBuyEndTime('str');
$request->setMallVisitDays(1);
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