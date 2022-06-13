<?php
/**
 * 示例接口名称：pdd.virtual.create.medicine.notify
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddVirtualCreateMedicineNotifyRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddVirtualCreateMedicineNotifyRequest();

$request->setAllergyHistory('str');
$request->setAppeal('str');
$request->setConsultNo('str');
$request->setDiagnosticName('str');
$request->setDiagnosticNo('str');
$request->setDrugInfo();
$request->setErrMessage('str');
$request->setHospitalDoctorChapter('str');
$request->setHospitalDoctorName('str');
$request->setHospitalPharmacistsChapter('str');
$request->setHospitalPharmacistsName('str');
$request->setMallId(1);
$request->setMedicalNo('str');
$request->setMedicalRecord('str');
$request->setMedicineOrderImg('str');
$request->setOutMedicalNo('str');
$request->setPastHistory('str');
$request->setPhysicalFunction();
$request->setStatus(1);
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