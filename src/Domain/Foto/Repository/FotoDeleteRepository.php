<?php

namespace App\Domain\Foto\Repository;

use App\Domain\Foto\Enum\FotoMsg;
use App\Domain\Foto\Exception\FotoException;
use PDO;
use Selective\Config\Configuration;

final class FotoDeleteRepository 
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

    public function getFileNameByItemId(int $id): string|null {
        $table = $this->config->getString('db.table.fotos');
        $sql = "SELECT img FROM $table WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $imgName = $stmt->fetch();
        return $imgName['img'];
    }

    public function deleteById(int $id) {
        $table = $this->config->getString('db.table.fotos');
        $sql = "DELETE FROM $table WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        if (!$stmt->execute([$id]))
        throw new FotoException(
            FotoMsg::DB_ERROR->value
        );
    }
}
