<?php

namespace App\Domain\AdminAuth\Service;

use App\Domain\AdminAuth\Data\AdminAuthData;
use App\Domain\AdminAuth\Enum\AdminAuthMsg;
use App\Domain\AdminAuth\Exception\AdminAuthException;
use App\Domain\AdminAuth\Repository\AdminAuthRepository;
use App\Domain\AdminAuth\Service\AdminAuthDataValidator;
use App\Domain\AdminAuth\Service\AdminAuthDataVerifier;
use App\Domain\AdminAuth\Service\AdminAuthJwtGenerator;
use Selective\Config\Configuration;

final class AdminAuthService 
{
    private $repository;
    private $validator;
    private $verifier;
    private $jwtGenerator;
    private $config;

    public function __construct(
        AdminAuthRepository $repository,
        AdminAuthDataValidator $validator,
        AdminAuthDataVerifier $verifier,
        AdminAuthJwtGenerator $jwtGenerator,
        Configuration $config,
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->verifier = $verifier;
        $this->jwtGenerator = $jwtGenerator;
        $this->config = $config;
    }

    public function auth(array $adminAuthData): array 
    {
        $data = new AdminAuthData($adminAuthData);

        // Validates login
        try {
            $this->validator->isAdminLoginRequestValid($data);
        } catch(AdminAuthException $e) {
            return (
                new AdminAuthData(array(400, 0, $e->getMessage()))
            )->jsonSerialize();
        }

        // Validates pass
        try {
            $this->validator->isAdminPassRequestValid($data);
        } catch(AdminAuthException $e) {
            return (
                new AdminAuthData(array(400, 0, $e->getMessage()))
            )->jsonSerialize();
        }

        // Checks if admin data file exists
        if(!file_exists($this->config->getString('url.adminAuthFile')))
        return (
            new AdminAuthData(array(404, 0, AdminAuthMsg::NO_DATA_FOUND))
        )->jsonSerialize();

        // Gets json string admin auth data from reposiory.
        // Decodes admin auth data from json string.
        $adminAuthDataDecoded = 
            json_decode($this->repository->getJsonStringAdminAuthData());

        $adminJwtSecretKeyDecoded = 
            $this->verifier->verify($adminAuthDataDecoded, $data);
        
        if($adminJwtSecretKeyDecoded != null) {
 
            $jwtGenerated = 
                $this->jwtGenerator->generate($adminJwtSecretKeyDecoded);
            
            // Based on https://www.php.net/manual/en/function.setcookie.php#125242
            $cookieOptions = array (
                'expires' => time()+900, // 15 minutes
                'httponly' => true, // prevent XSS
            );
            $cookieName = $this->config->getString('jwt.cookie_name');
            setcookie($cookieName, $jwtGenerated, $cookieOptions);
            
            // Because of AJAX, redirect url should be sent in JSON response
            $redirectUrl = $this->config->getString('url.adminFotos');
            
            return (
                new AdminAuthData(array(200, 1, $redirectUrl))
            )->jsonSerialize();
        } else {
            return (
                new AdminAuthData(array(400, 0, AdminAuthMsg::ACCESS_NOT_ALLOWED))
            )->jsonSerialize();
        }
    }
}
