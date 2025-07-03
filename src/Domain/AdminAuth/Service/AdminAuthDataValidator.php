<?php

namespace App\Domain\AdminAuth\Service;

use App\Domain\AdminAuth\Data\AdminAuthData;
use App\Domain\AdminAuth\Enum\AdminAuthMsg;
use App\Domain\AdminAuth\Exception\AdminAuthException;

// Validates incoming request admin data. 
// Basic validation only.
final class AdminAuthDataValidator {

    public function isAdminLoginRequestValid(AdminAuthData $data)
    {
        $login = trim((string)$data->getAdminLogin());
        // Checks if login is empty        
        if ($login == null || empty($login) || $login == "") 
        throw new AdminAuthException(
            AdminAuthMsg::INPUT_LOGIN->value
        );
    }

    public function isAdminPassRequestValid(AdminAuthData $data)
    {
        $pass = trim((string)$data->getAdminPass());
        // Checks if pass is empty        
        if ($pass == null || empty($pass) || $pass == "") 
        throw new AdminAuthException(
            AdminAuthMsg::INPUT_PASS->value
        );
    }
}
