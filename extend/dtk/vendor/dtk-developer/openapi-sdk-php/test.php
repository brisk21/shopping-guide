<?php
    include 'vendor/autoload.php';

    //线报api
    $client = new GetTipList();

    $client->setAppKey('xxxxxxxxx');
    $client->setAppSecret('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
    $client->setVersion('v3.0.0');

    $res = $client->setParams([])->request();
    var_dump($res);