<?php

namespace App\Domain\Foto\Repository;

use App\Domain\Foto\Enum\FotoMsg;
use App\Domain\Foto\Exception\FotoException;
use PDO;
use Selective\Config\Configuration;

final class FotoUpdateRepository 
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

    public function getOldFileNameByItemId(int $id): string|null 
    {
        $table = $this->config->getString('db.table.fotos');
        $sql = "SELECT img FROM $table WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $imgName = $stmt->fetch();
        return $imgName['img'];
    }

    public function updateById(array $dbArray)
    {
        $table = $this->config->getString('db.table.fotos');
        // Checks if 'img' key exists in the array 
        // to map to sql statement properly
        if (array_key_exists('img', $dbArray)) {
            $sql = "UPDATE $table 
                    SET img=:img,
                        name=:name,
                        description=:description 
                    WHERE id=:id";
            $stmt = $this->pdo->prepare($sql);
            if (!$stmt->execute($dbArray))
            throw new FotoException(
                FotoMsg::DB_ERROR->value
            );
        } else {
            $sql = "UPDATE $table 
                    SET name=:name,
                        description=:description 
                    WHERE id=:id";
            $stmt = $this->pdo->prepare($sql);
            if (!$stmt->execute($dbArray))
            throw new FotoException(
                FotoMsg::DB_ERROR->value
            );
        }
    }
}
