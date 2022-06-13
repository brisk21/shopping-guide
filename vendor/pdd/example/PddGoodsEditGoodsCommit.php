<?php
/**
 * 示例接口名称：pdd.goods.edit.goods.commit
*/
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddGoodsEditGoodsCommitRequest;
$client = new PopHttpClient(Config::$clientId, Config::$clientSecret);

$request = new PddGoodsEditGoodsCommitRequest();

$request->setBadFruitClaim(1);
$request->setBuyLimit(1);
$request->setCarouselGallery(array('str'));
$request->setCarouselVideo();
$request->setCarouselVideoUrl('str');
$request->setCatId(1);
$request->setCostTemplateId(1);
$request->setCountryId(1);
$request->setCustomerNum(1);
$request->setCustoms('str');
$request->setDeliveryOneDay(1);
$request->setDetailGallery(array('str'));
$request->setElecGoodsAttributes();
$request->setGoodsDesc('str');
$request->setGoodsName('str');
$request->setGoodsProperties();
$request->setGoodsTradeAttr();
$request->setGoodsTravelAttr();
$request->setGoodsType(1);
$request->setImageUrl('str');
$request->setInvoiceStatus(1);
$request->setIsCustoms(true);
$request->setIsFolt(true);
$request->setIsPreSale(true);
$request->setIsRefundable(true);
$request->setLackOfWeightClaim(1);
$request->setMaiJiaZiTi('str');
$request->setMarketPrice(1);
$request->setOrderLimit(1);
$request->setOriginCountryId(1);
$request->setOutGoodsId('str');
$request->setOverseaGoods();
$request->setOverseaType(1);
$request->setPreSaleTime(1);
$request->setQuanGuoLianBao(1);
$request->setSecondHand(true);
$request->setShangMenAnZhuang('str');
$request->setShipmentLimitSecond(1);
$request->setSizeSpecId(1);
$request->setSkuList();
$request->setSkuType(1);
$request->setSongHuoAnZhuang('str');
$request->setSongHuoRuHu('str');
$request->setTinyName('str');
$request->setWarehouse('str');
$request->setWarmTips('str');
$request->setZhiHuanBuXiu(1);
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