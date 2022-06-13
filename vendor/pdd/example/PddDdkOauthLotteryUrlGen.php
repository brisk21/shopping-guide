<?php
/**
 * 示例接口名称：pdd.ddk.oauth.lottery.url.gen
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthLotteryUrlGenRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddDdkOauthLotteryUrlGenRequest();

$request->setCustomParameters('str');
$request->setGenerateQqApp(true);
$request->setGenerateSchemaUrl(true);
$request->setGenerateShortUrl(true);
$request->setGenerateWeappWebview(true);
$request->setGenerateWeApp(true);
$request->setMultiGroup(true);
$request->setPidList(array('str'));
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