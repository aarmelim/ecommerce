<?php

namespace aarmelim\PagSeguro;

use Exception;
use DOMDocument;
use DOMElement;
use aarmelim\PagSeguro\CreditCard\Installment;
use aarmelim\PagSeguro\CreditCard\Holder;

class CreditCard {

	private $token;
	private $installment;
	private $holder;
    private $billingAddress;
	
	public function __construct(
		string $token,
		Installment $installment,
		Holder $holder,
		Address $billingAddress
	)
	{

		if (!$token)
		{

			throw new Exception("Informe o token do cartão de crédito.");

		}

		$this->token = $token;
		$this->installment = $installment;
		$this->holder = $holder;
		$this->billingAddress = $billingAddress;

	}

	public function getDOMElement()
	{
	
		$dom = new DOMDocument();

		$creditCard = $dom->createElement("creditCard");
		$creditCard = $dom->appendChild($creditCard);

		$token = $dom->createElement("token", $this->token);
		$token = $creditCard->appendChild($token);
		
		$installment = $this->installment->getDomElement();
		$installment = $dom->importNode($installment, true);
		$installment = $creditCard->appendChild($installment);

		$holder = $this->holder->getDomElement();
		$holder = $dom->importNode($holder, true);
		$holder = $creditCard->appendChild($holder);

		$billingAddress = $this->billingAddress->getDomElement("billingAddress"); //aqui que estou mudando o nome do nó de acordo com o parametro passado, ja que o endereço de cobrança e de entrega são os mesmos nesse projeto
		$billingAddress = $dom->importNode($billingAddress, true);
		$billingAddress = $creditCard->appendChild($billingAddress);

		return $creditCard;

	}

}