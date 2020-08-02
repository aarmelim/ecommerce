<?php

use \aarmelim\Page;
use \aarmelim\Model\User;
use \aarmelim\PagSeguro\Config;
use \aarmelim\PagSeguro\Transporter;
use \aarmelim\PagSeguro\Document;
use \aarmelim\PagSeguro\Phone;
use \aarmelim\PagSeguro\Address;
use \aarmelim\PagSeguro\Sender;
use \aarmelim\PagSeguro\Shipping;
use \aarmelim\PagSeguro\Item;
use \aarmelim\PagSeguro\Payment;
use \aarmelim\PagSeguro\CreditCard;
use \aarmelim\PagSeguro\CreditCard\Installment;
use \aarmelim\PagSeguro\CreditCard\Holder;
use \aarmelim\PagSeguro\Bank;
use \aarmelim\Model\Order;

$app->post('/payment/credit', function(){

    User::verifyLogin(false);

    $order = new Order();

    $order->getFromSession();

    $order->get((int)$order->getidorder());

    $address = $order->getAddress();

    $cart = $order->getCart();

    $cpf = new Document(Document::CPF, $_POST['cpf']);

    $phone = new Phone($_POST['ddd'], $_POST['phone']);

    $shippingAddress = new Address(
        $address->getdesaddress(),
        $address->getdesnumber(),
        $address->getdescomplement(),       
        $address->getdesdistrict(),
        $address->getdeszipcode(),
        $address->getdescity(),
        $address->getdesstate(),
        $address->getdescountry()
    );

    $birthDate = new DateTime($_POST['birth']);

    $sender = new Sender($order->getdesperson(), $cpf, $birthDate, $phone, $order->getdesemail(), $_POST['hash']);

    $holder = new Holder($order->getdesperson(), $cpf, $birthDate, $phone);

    $shipping = new Shipping($shippingAddress, (float)$cart->getvlfreight(), Shipping::PAC);

    $installment = new Installment((int)$_POST["installments_qtd"], (float)$_POST["installments_value"]);

    $billingAddress = new Address(
        $address->getdesaddress(),
        $address->getdesnumber(),
        $address->getdescomplement(),       
        $address->getdesdistrict(),
        $address->getdeszipcode(),
        $address->getdescity(),
        $address->getdesstate(),
        $address->getdescountry()
    );

    $creditCard = new CreditCard($_POST['token'], $installment, $holder, $billingAddress);

    $payment = new Payment($order->getidorder(), $sender, $shipping); //se quiser dar desconto tem que passar o quarto parametro (extraAmount) de desconto

    foreach($cart->getProducts() as $product)
    {

        $item = new Item(
            (int)$product['idproduct'],
            $product['desproduct'],
            (float)$product['vlprice'],
            (int)$product['nrqtd']
        );

        $payment->addItem($item);

    }

    $payment->setCreditCard($creditCard);

    Transporter::sendTransaction($payment);

    echo json_encode([
        'success'=>true
    ]);

    // para testar a criação do XML.
    //$dom = new DomDocument();
    //$test = $phone->getDOMElement();
    //$testNode = $dom->importNode($test, true);
    //$dom->appendChild($testNode);
    //echo $dom->saveXML();

    // Para testar a geração do XML para "Payment" apenas
    //$dom = $payment->getDOMDocument();
    //echo $dom->saveXml();

});

$app->get('/payment', function(){

    User::verifyLogin(false);

    $order = new Order();

    $order->getFromSession();

    $years = [];

    for ($y= date('Y'); $y < date('Y') + 14; $y++)
    {

        array_push($years, $y);

    }

    $page = new Page();

    $page->setTpl("payment", [
        "order"=>$order->getValues(),
        "msgError"=>Order::getError(),
        "years"=>$years,
        "pagseguro"=>[
            "urlJS"=>Config::getUrlJS(),
            "id"=>Transporter::createSession(),
            "maxInstallmentNoInterest"=>Config::MAX_INSTALLMENT_NO_INTEREST,
            "maxInstallment"=>Config::MAX_INSTALLMENT,
        ]
    ]);

});