<?php

namespace App\Domain\Foto\Service;

use App\Domain\Foto\Data\FotoData;
use App\Domain\Foto\Enum\FotoMsg;
use App\Domain\Foto\Exception\FotoException;
use App\Domain\Foto\Repository\FotoDeleteRepository;
use Selective\Config\Configuration;

final class FotoDeleteService 
{
    private $repository;
    private $config;

    public function __construct(
        FotoDeleteRepository $repository,
        Configuration $config
    ) {
        $this->repository = $repository;
        $this->config = $config;
    }

    public function deleteById(int $id): array 
    {
        // Gets file name from DB.
        $fileName = $this->repository->getFileNameByItemId($id);
        
        // Deletes file from uploads dir.
        if ($fileName !== null) {
            $uploadsSubUrl = $this->config->getString('url.uploadsSubUrl');
            $pathToFile = $uploadsSubUrl.$fileName;
            if (file_exists($pathToFile)) unlink($pathToFile);
        }
       
        // Deletes item from DB by id.
        try {
            $this->repository->deleteById($id);
            return (
                new FotoData(
                    array(200, 1, FotoMsg::DELETED->value)
                )
            )->jsonSerialize(); 
        } catch (FotoException | \PDOException $e) {
            return (
                new FotoData(array(500, 0, $e->getMessage()))
            )->jsonSerialize();
        }
    }
}
