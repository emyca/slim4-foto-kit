<?php

namespace App\Domain\Foto\Repository;

use App\Domain\Foto\Enum\FotoMsg;
use App\Domain\Foto\Exception\FotoException;
use PDO;
use Selective\Config\Configuration;

final class FotoCreateRepository 
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

    public function create(array $dbArray)
    {      
        $table = $this->config->getString('db.table.fotos');
        $sql = "INSERT INTO $table 
                SET img=:img,
                    name=:name,
                    description=:description";
        $stmt = $this->pdo->prepare($sql);
        if (!$stmt->execute($dbArray))
        throw new FotoException(
            FotoMsg::DB_ERROR->value
        );
    }
}
