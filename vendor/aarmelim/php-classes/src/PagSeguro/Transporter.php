<?php

namespace aarmelim\PagSeguro;

use \GuzzleHttp\Client;

class Transporter {

    public static function createSession()
    {

        $client = new Client();

        $res = $client->request('POST', Config::getUrlSessions() . "?" . http_build_query(Config::getAuthentication()), [
            "verify"=>false
        ]);

        $xml = simplexml_load_string($res->getBody()->getContents()); //transforma em um objeto

        return ((string)$xml->id);
    
    }

}