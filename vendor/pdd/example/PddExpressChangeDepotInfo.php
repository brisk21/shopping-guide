<?php
/**
 * 示例接口名称：pdd.express.change.depot.info
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddExpressChangeDepotInfoRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddExpressChangeDepotInfoRequest();

$request->setDepotId(1);
$request->setDepotCode('str');
$request->setDepotName('str');
$request->setDepotAlias('str');
$request->setDepotProvinceId(1);
$request->setDepotCityId(1);
$request->setDepotDistrictId(1);
$request->setDepotAddress('str');
$request->setContactName('str');
$request->setTelephone('str');
$request->setDepotRegion('str');
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