<?php

namespace aarmelim\PagSeguro;

class Config {

    const SANDBOX = true;

    const SANDBOX_EMAIL = "storeannak@gmail.com";
    const PRODUCTION_EMAIL = "storeannak@gmail.com";
    
    const SANDBOX_TOKEN = "8A62A139E4594D80A366C75BDF872278";
    const PRODUCTION_TOKEN = "29ba1403-4429-4b8a-8cf7-f8477cd24e58998c7a424e21836bed3ed6e0dc09f1e83e7f-2f7c-484d-8e7c-55c0978b17f9";

    const SANDBOX_SESSIONS = "https://ws.sandbox.pagseguro.uol.com.br/sessions";
    const PRODUCTION_SESSIONS = "https://ws.pagseguro.uol.com.br/sessions";

    const SANDBOX_URL_JS = "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";
    const PRODUCTION_URL_JS = "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";

    const MAX_INSTALLMENT_NO_INTEREST = 6; // Máximo de parcelas que será aceito sen juros
    const MAX_INSTALLMENT = 10; // Máximo de parcelas total que o nosso site irá suportar. Pagseguro não pede essa informação

    const NOTIFICATION_URL = "http://www.annakstore.com.br/payment/notification";

    public static function getAuthentication():array
    {

        if (Config::SANDBOX === true)
        {

            return [
                "email"=>Config::SANDBOX_EMAIL,
                "token"=>Config::SANDBOX_TOKEN
            ];
 
        } else {

            return [
                "email"=>Config::PRODUCTION_EMAIL,
                "token"=>Config::PRODUCTION_TOKEN
            ];

        }

    }

    public static function getUrlSessions():string
    {

        return (Config::SANDBOX === true) ? Config::SANDBOX_SESSIONS : Config::PRODUCTION_SESSIONS;

    }

    public static function getUrlJS(){

        return (Config::SANDBOX === true) ? Config::SANDBOX_URL_JS : Config::PRODUCTION_URL_JS;

    }

}