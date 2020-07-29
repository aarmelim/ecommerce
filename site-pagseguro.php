<?php

use \aarmelim\Page;
use \GuzzleHttp\Client;
use \aarmelim\Model\User;
use \aarmelim\Model\Order;
use \aarmelim\PagSeguro\Config;


$app->get('/payment', function(){

    User::verifyLogin(false);

    $order = new Order();

    $order->getFromSession();

    $years = [];

    for ($y= date('Y'); $y < date('Y') + 14; $y++)
    {

        array_push($years, $y);

    }

    $page = new Page([
        "footer"=>false
    ]);

    $page->setTpl("payment", [
        "order"=>$order->getValues(),
        "msgError"=>Order::getError(),
        "years"=>$years,
        "pagseguro"=>[
            "urlJS"=>Config::getUrlJS()
        ]
    ]);

});

$app->get('/payment/pagseguro', function() {

    $client = new Client();
    $res = $client->request('POST', Config::getUrlSessions() . "?" . http_build_query(Config::getAuthentication()), [
        'verify'=>false
    ]);

    echo $res->getBody()->getContents();

});