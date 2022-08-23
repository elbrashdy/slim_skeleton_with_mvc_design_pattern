<?php
namespace App\Controllers;

use Firebase\JWT\JWT;

// for JWT_SECRETE_KEY write a strong random number

const JWT_SECRETE_KEY = "this_should_not_committed_to_github";


class GTController
{
    public static function generateToken($data)
    {
        $now = time();
        // You have to specify the time for your token to get expired
        $future = strtotime('+10 hour',$now);
        $secretKey = JWT_SECRETE_KEY;
        $payload = [
         "inf"=>$data,
         "iat"=>$now,
         "exp"=>$future
        ];

        return JWT::encode($payload,$secretKey,"HS256");
    }
}