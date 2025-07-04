<?php

namespace App\Domain\Foto\Repository;

use PDO;
use Selective\Config\Configuration;

final class FotoReadRepository 
{
    private $pdo;
    private $config;

    public function __construct(
        PDO $pdo,
        Configuration $config
    ) {
        $this->pdo = $pdo;
        $this->config = $config; 
    }

    public function readAll(): array 
    {
        $table = $this->config->getString('db.table.fotos');
        $sql = "SELECT id, img, name, description FROM $table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
