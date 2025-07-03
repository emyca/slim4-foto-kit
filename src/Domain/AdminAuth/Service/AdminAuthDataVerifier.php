<?php

namespace App\Domain\AdminAuth\Service;

use App\Domain\AdminAuth\Data\AdminAuthData;

// Verifies admin auth data.
// Returns admin jwt secret key if admin auth data verified.
final class AdminAuthDataVerifier 
{
    public function verify($adminAuthDataDecoded, AdminAuthData $data) 
    {
        // Gets admin_login decoded
        $adminLoginDecoded = $adminAuthDataDecoded->admin_login;        
        // Gets admin_pass decoded
        $adminPassDecoded = $adminAuthDataDecoded->admin_pass;
        // Gets admin_jwt_secret_key decoded
        $adminJwtSecretKeyDecoded = $adminAuthDataDecoded->admin_jwt_secret_key;

        $isAdminPassValid = password_verify(
            $data->getAdminPass(), $adminPassDecoded
        );

        if($data->getAdminLogin() == 
            $adminLoginDecoded && $isAdminPassValid) {
                return $adminJwtSecretKeyDecoded;
        }
    }
}
