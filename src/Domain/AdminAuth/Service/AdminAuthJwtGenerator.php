<?php

namespace App\Domain\AdminAuth\Service;

use Firebase\JWT\JWT;
use Selective\Config\Configuration;

// Generates JWT to auth admin
final readonly class AdminAuthJwtGenerator {

    public function __construct(
        private Configuration $config
    ) {
    }

    public function generate($adminJwtSecretKey): string 
    {
        $jwtissuer = $this->config->getString('jwt.issuer');
        $jwtaudience = $this->config->getString('jwt.audience');
        $timestamp = time();
        $expiry = $timestamp + (60 * 15); // token valid for 15 minutes

        $timezone = "";
        if (date_default_timezone_get()) {
            $timezone = date_default_timezone_get();
        } elseif (ini_get('date.timezone')) {
            $timezone = ini_get('date.timezone');
        }

        $token = [
            "iss" => $jwtissuer,
            "aud" => $jwtaudience,
            "iat" => $timestamp,
            "nbf" => $timestamp,
            "exp" => $expiry,
            "timezone" => $timezone,
        ];

        return JWT::encode($token, $adminJwtSecretKey, 'HS256');
    }
}
