<?php
/**
 * 示例接口名称：pdd.ddk.goods.recommend.get
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsRecommendGetRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddDdkGoodsRecommendGetRequest();

$request->setChannelType(1);
$request->setCustomParameters('str');
$request->setLimit(1);
$request->setListId('str');
$request->setOffset(1);
$request->setPid('str');
$request->setCatId(1);
$request->setGoodsIds(array(1));
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