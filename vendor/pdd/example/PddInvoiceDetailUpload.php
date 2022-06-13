<?php
/**
 * 示例接口名称：pdd.invoice.detail.upload
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddInvoiceDetailUploadRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddInvoiceDetailUploadRequest();

$request->setApplicationId(1);
$request->setBusinessType(1);
$request->setInvoiceAmount(1);
$request->setInvoiceCode('str');
$request->setInvoiceFileContent('str');
$request->setInvoiceKind(1);
$request->setInvoiceNo('str');
$request->setInvoiceTime(1);
$request->setInvoiceType(1);
$request->setMemo('str');
$request->setOrderSn('str');
$request->setOriginalInvoiceCode('str');
$request->setOriginalInvoiceNo('str');
$request->setPayeeOperator('str');
$request->setPayerAccount('str');
$request->setPayerAddress('str');
$request->setPayerBank('str');
$request->setPayerName('str');
$request->setPayerPhone('str');
$request->setPayerRegisterNo('str');
$request->setSumPrice(1);
$request->setSumTax(1);
$request->setTaxRate(1);
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