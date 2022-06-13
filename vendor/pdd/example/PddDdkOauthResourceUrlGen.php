<?php
/**
 * 示例接口名称：pdd.ddk.oauth.resource.url.gen
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthResourceUrlGenRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddDdkOauthResourceUrlGenRequest();

$request->setCustomParameters('str');
$request->setGenerateWeApp(true);
$request->setPid('str');
$request->setResourceType(1);
$request->setUrl('str');
$request->setGenerateSchemaUrl(true);
$request->setGenerateQqApp(true);
try{
	$response = $client->syncInvoke($request, Config::$accessToken);
} catch(Com\Pdd\Pop\Sdk\PopHttpException $e){
	echo $e->getMessage();
	exit;
}
$content = $response->getContent();
if(isset($content['error_response'])){
	echo "异常返回";
}
echo json_encode($content,JSON_UNESCAPED_UNICODE);