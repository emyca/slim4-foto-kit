<?php

namespace App\Domain\AdminAuth\Repository;

use Selective\Config\Configuration;

final readonly class AdminAuthRepository 
{
    public function __construct(
        private Configuration $config
    ) {
    }
  
    // Gets json string admin auth data from json file
    public function getJsonStringAdminAuthData(): string {
        // Gets the file path
        $filePath = $this->config->getString('url.adminAuthFile');
        return file_get_contents($filePath);
    }
}
