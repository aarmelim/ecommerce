<?php

namespace aarmelim\PagSeguro;

class Config {

    const SANDBOX = true;

    const SANDBOX_EMAIL = "storeannak@gmail.com";
    const PRODUCTION_EMAIL = "storeannak@gmail.com";
    
    const SANDBOX_TOKEN = "8A62A139E4594D80A366C75BDF872278";
    const PRODUCTION_TOKEN = "29ba1403-4429-4b8a-8cf7-f8477cd24e58998c7a424e21836bed3ed6e0dc09f1e83e7f-2f7c-484d-8e7c-55c0978b17f9";

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

}