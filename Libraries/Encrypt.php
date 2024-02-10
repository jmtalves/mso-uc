<?php

namespace Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Encrypt
{
    //@var string $jwt_secret jwt_secret
    private static $jwt_secret = "59gsv4Bn7VcEyM10uiZiyY72l2KJp31N";


    /**
     * decryptJwt
     *
     * @param  string $jwt jwt token to decrypt
     * @throws \Exception
     * @return array
     */
    public static function decryptJwt($jwt)
    {
        try {
            return  (array)JWT::decode($jwt, new Key(self::$jwt_secret, 'HS256'));
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
