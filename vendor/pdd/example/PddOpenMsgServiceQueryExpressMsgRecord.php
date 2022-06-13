<?php
/**
 * 示例接口名称：pdd.open.msg.service.query.express.msg.record
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddOpenMsgServiceQueryExpressMsgRecordRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddOpenMsgServiceQueryExpressMsgRecordRequest();

$request->setBizId('str');
$request->setPageNumber(1);
$request->setPageSize(1);
$request->setSendDate('str');
$request->setWaybillCode('str');
$request->setWpCode('str');
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