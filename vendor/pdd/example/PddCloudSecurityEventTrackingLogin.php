<?php
/**
 * 示例接口名称：pdd.cloud.security.event.tracking.login
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddCloudSecurityEventTrackingLoginRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddCloudSecurityEventTrackingLoginRequest();

$request->setLoginMessage('str');
$request->setLoginResult(true);
$request->setMallIdList(array(1));
$request->setPati('str');
$request->setTimestamp(1);
$request->setUserId('str');
$request->setUserIp('str');
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