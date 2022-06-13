<?php
/**
 * 示例接口名称：pdd.mall.info.store.get
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddMallInfoStoreGetRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddMallInfoStoreGetRequest();

$request->setCity('str');
$request->setDistrict('str');
$request->setPageNumber(1);
$request->setPageSize(1);
$request->setProvince('str');
$request->setStoreId(1);
$request->setStoreName('str');
$request->setStoreNumber('str');
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