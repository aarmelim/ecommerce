<?php

namespace aarmelim\PagSeguro;

use Exception;
use DOMDocument;
use DOMElement;
use aarmelim\PagSeguro\Payment\Method;
use aarmelim\PagSeguro\Config;

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

	public function __construct(
		string $reference,
		Sender $sender,
		Shipping $shipping,
		float $extraAmount = 0
	)
	{

		$this->sender = $sender;
		$this->shipping = $shipping;
		$this->reference = $reference;
		$this->extraAmount = number_format($extraAmount, 2, ".", "");
		
	}

	public function addItem(Item $item)
	{

		array_push($this->items, $item);

	}

	public function setCreditCard(CreditCard $creditCard)
	{

		$this->creditCard = $creditCard;
		$this->method = Method::CREDIT_CARD;

	}

	public function setBank(Bank $bank) //para quando é débito automático
	{

		$this->bank = $bank;
		$this->method = Method::DEBIT;

	}

	public function setBoleto()
	{

		$this->method = Method::BOLETO;

	}

	public function getDOMDocument()
	{

		$dom = new DOMDocument("1.0", "ISO-8859-1");

		return $dom;

	}

}