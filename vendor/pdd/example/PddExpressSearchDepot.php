<?php
/**
 * 示例接口名称：pdd.express.search.depot
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddExpressSearchDepotRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddExpressSearchDepotRequest();

$request->setCode('str');
$request->setLength(1);
$request->setName('str');
$request->setStart(1);
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