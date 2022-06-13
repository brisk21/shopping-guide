<?php
/**
 * 示例接口名称：pdd.express.add.depot
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddExpressAddDepotRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddExpressAddDepotRequest();

$request->setContactName('str');
$request->setDepotAddress('str');
$request->setDepotAlias('str');
$request->setDepotCityId(1);
$request->setDepotCode('str');
$request->setDepotDistrictId(1);
$request->setDepotName('str');
$request->setDepotProvinceId(1);
$request->setDepotRegion();
$request->setTelephone('str');
$request->setZipCode('str');
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