<?php

namespace aarmelim\PagSeguro;

class Payment {

    private $mode = "default";
	private $currency = "BRL";
	private $extraAmount = 0; //caso precise adicionar um valor ao valor final ou colocar um desconto
	private $reference = ""; //meu número
	private $items = [];
	private $sender;
	private $shipping;
	private $method;
	private $creditCard;
    private $bank;

}