<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVirtualCreateMedicineNotifyRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "allergy_history")
	*/
	private $allergyHistory;

	/**
	* @JsonProperty(String, "appeal")
	*/
	private $appeal;

	/**
	* @JsonProperty(String, "consult_no")
	*/
	private $consultNo;

	/**
	* @JsonProperty(String, "diagnostic_name")
	*/
	private $diagnosticName;

	/**
	* @JsonProperty(String, "diagnostic_no")
	*/
	private $diagnosticNo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddVirtualCreateMedicineNotifyRequest_DrugInfoItem>, "drug_info")
	*/
	private $drugInfo;

	/**
	* @JsonProperty(String, "err_message")
	*/
	private $errMessage;

	/**
	* @JsonProperty(String, "hospital_doctor_chapter")
	*/
	private $hospitalDoctorChapter;

	/**
	* @JsonProperty(String, "hospital_doctor_name")
	*/
	private $hospitalDoctorName;

	/**
	* @JsonProperty(String, "hospital_pharmacists_chapter")
	*/
	private $hospitalPharmacistsChapter;

	/**
	* @JsonProperty(String, "hospital_pharmacists_name")
	*/
	private $hospitalPharmacistsName;

	/**
	* @JsonProperty(Long, "mall_id")
	*/
	private $mallId;

	/**
	* @JsonProperty(String, "medical_no")
	*/
	private $medicalNo;

	/**
	* @JsonProperty(String, "medical_record")
	*/
	private $medicalRecord;

	/**
	* @JsonProperty(String, "medicine_order_img")
	*/
	private $medicineOrderImg;

	/**
	* @JsonProperty(String, "out_medical_no")
	*/
	private $outMedicalNo;

	/**
	* @JsonProperty(String, "past_history")
	*/
	private $pastHistory;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddVirtualCreateMedicineNotifyRequest_PhysicalFunction, "physical_function")
	*/
	private $physicalFunction;

	/**
	* @JsonProperty(Integer, "status")
	*/
	private $status;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "allergy_history", $this->allergyHistory);
		$this->setUserParam($params, "appeal", $this->appeal);
		$this->setUserParam($params, "consult_no", $this->consultNo);
		$this->setUserParam($params, "diagnostic_name", $this->diagnosticName);
		$this->setUserParam($params, "diagnostic_no", $this->diagnosticNo);
		$this->setUserParam($params, "drug_info", $this->drugInfo);
		$this->setUserParam($params, "err_message", $this->errMessage);
		$this->setUserParam($params, "hospital_doctor_chapter", $this->hospitalDoctorChapter);
		$this->setUserParam($params, "hospital_doctor_name", $this->hospitalDoctorName);
		$this->setUserParam($params, "hospital_pharmacists_chapter", $this->hospitalPharmacistsChapter);
		$this->setUserParam($params, "hospital_pharmacists_name", $this->hospitalPharmacistsName);
		$this->setUserParam($params, "mall_id", $this->mallId);
		$this->setUserParam($params, "medical_no", $this->medicalNo);
		$this->setUserParam($params, "medical_record", $this->medicalRecord);
		$this->setUserParam($params, "medicine_order_img", $this->medicineOrderImg);
		$this->setUserParam($params, "out_medical_no", $this->outMedicalNo);
		$this->setUserParam($params, "past_history", $this->pastHistory);
		$this->setUserParam($params, "physical_function", $this->physicalFunction);
		$this->setUserParam($params, "status", $this->status);

	}

	public function getVersion()
	{
		return "V1";
	}

	public function getDataType()
	{
		return "JSON";
	}

	public function getType()
	{
		return "pdd.virtual.create.medicine.notify";
	}

	public function setAllergyHistory($allergyHistory)
	{
		$this->allergyHistory = $allergyHistory;
	}

	public function setAppeal($appeal)
	{
		$this->appeal = $appeal;
	}

	public function setConsultNo($consultNo)
	{
		$this->consultNo = $consultNo;
	}

	public function setDiagnosticName($diagnosticName)
	{
		$this->diagnosticName = $diagnosticName;
	}

	public function setDiagnosticNo($diagnosticNo)
	{
		$this->diagnosticNo = $diagnosticNo;
	}

	public function setDrugInfo($drugInfo)
	{
		$this->drugInfo = $drugInfo;
	}

	public function setErrMessage($errMessage)
	{
		$this->errMessage = $errMessage;
	}

	public function setHospitalDoctorChapter($hospitalDoctorChapter)
	{
		$this->hospitalDoctorChapter = $hospitalDoctorChapter;
	}

	public function setHospitalDoctorName($hospitalDoctorName)
	{
		$this->hospitalDoctorName = $hospitalDoctorName;
	}

	public function setHospitalPharmacistsChapter($hospitalPharmacistsChapter)
	{
		$this->hospitalPharmacistsChapter = $hospitalPharmacistsChapter;
	}

	public function setHospitalPharmacistsName($hospitalPharmacistsName)
	{
		$this->hospitalPharmacistsName = $hospitalPharmacistsName;
	}

	public function setMallId($mallId)
	{
		$this->mallId = $mallId;
	}

	public function setMedicalNo($medicalNo)
	{
		$this->medicalNo = $medicalNo;
	}

	public function setMedicalRecord($medicalRecord)
	{
		$this->medicalRecord = $medicalRecord;
	}

	public function setMedicineOrderImg($medicineOrderImg)
	{
		$this->medicineOrderImg = $medicineOrderImg;
	}

	public function setOutMedicalNo($outMedicalNo)
	{
		$this->outMedicalNo = $outMedicalNo;
	}

	public function setPastHistory($pastHistory)
	{
		$this->pastHistory = $pastHistory;
	}

	public function setPhysicalFunction($physicalFunction)
	{
		$this->physicalFunction = $physicalFunction;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

}

class PddVirtualCreateMedicineNotifyRequest_DrugInfoItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "approval_no")
	*/
	private $approvalNo;

	/**
	* @JsonProperty(Integer, "dosage_form")
	*/
	private $dosageForm;

	/**
	* @JsonProperty(String, "drug_name")
	*/
	private $drugName;

	/**
	* @JsonProperty(String, "general_name")
	*/
	private $generalName;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Long, "mall_id")
	*/
	private $mallId;

	/**
	* @JsonProperty(String, "mall_name")
	*/
	private $mallName;

	/**
	* @JsonProperty(Integer, "num")
	*/
	private $num;

	/**
	* @JsonProperty(String, "pack")
	*/
	private $pack;

	/**
	* @JsonProperty(Long, "sku_id")
	*/
	private $skuId;

	/**
	* @JsonProperty(String, "specs")
	*/
	private $specs;

	/**
	* @JsonProperty(String, "usage_and_dosage")
	*/
	private $usageAndDosage;

	public function setApprovalNo($approvalNo)
	{
		$this->approvalNo = $approvalNo;
	}

	public function setDosageForm($dosageForm)
	{
		$this->dosageForm = $dosageForm;
	}

	public function setDrugName($drugName)
	{
		$this->drugName = $drugName;
	}

	public function setGeneralName($generalName)
	{
		$this->generalName = $generalName;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setMallId($mallId)
	{
		$this->mallId = $mallId;
	}

	public function setMallName($mallName)
	{
		$this->mallName = $mallName;
	}

	public function setNum($num)
	{
		$this->num = $num;
	}

	public function setPack($pack)
	{
		$this->pack = $pack;
	}

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

	public function setSpecs($specs)
	{
		$this->specs = $specs;
	}

	public function setUsageAndDosage($usageAndDosage)
	{
		$this->usageAndDosage = $usageAndDosage;
	}

}

class PddVirtualCreateMedicineNotifyRequest_PhysicalFunction extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "liver_function")
	*/
	private $liverFunction;

	/**
	* @JsonProperty(String, "pregnancy_lactation")
	*/
	private $pregnancyLactation;

	/**
	* @JsonProperty(String, "renal_function")
	*/
	private $renalFunction;

	public function setLiverFunction($liverFunction)
	{
		$this->liverFunction = $liverFunction;
	}

	public function setPregnancyLactation($pregnancyLactation)
	{
		$this->pregnancyLactation = $pregnancyLactation;
	}

	public function setRenalFunction($renalFunction)
	{
		$this->renalFunction = $renalFunction;
	}

}
