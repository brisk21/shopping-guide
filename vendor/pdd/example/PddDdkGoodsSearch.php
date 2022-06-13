<?php
/**
 * 示例接口名称：pdd.ddk.goods.search
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsSearchRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddDdkGoodsSearchRequest();

$request->setActivityTags(array(1));
$request->setCatId(1);
$request->setCustomParameters('str');
$request->setGoodsIdList(array(1));
$request->setIsBrandGoods(true);
$request->setKeyword('str');
$request->setListId('str');
$request->setMerchantType(1);
$request->setMerchantTypeList(array(1));
$request->setOptId(1);
$request->setPage(1);
$request->setPageSize(1);
$request->setPid('str');
$request->setRangeList();
$request->setSortType(1);
$request->setWithCoupon(true);
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