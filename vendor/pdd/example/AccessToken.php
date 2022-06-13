<?php
//多多客授权：https://jinbao.pinduoduo.com/open.html?client_id=$client_id&response_type=code&redirect_uri=https://hanshan.com
require_once dirname(__FILE__).'/Config.php';
require_once dirname(__FILE__)."/../vendor/autoload.php";

use Com\Pdd\Pop\Sdk\PopAccessTokenClient;


$clientId = Config::$clientId;
$clientSecret = Config::$clientSecret;
$client = new PopAccessTokenClient($clientId, $clientSecret);

$code = Config::$code;//通过授权获取
$result = $client->generate($code);
$result = json_encode($result->getContent(),JSON_UNESCAPED_UNICODE);
echo $result;
die();

$result = $client->refresh(Config::$refreshToken);
$result = json_encode($result->getContent(),JSON_UNESCAPED_UNICODE);
echo $result;



