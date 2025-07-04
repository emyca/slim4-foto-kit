<?php

namespace App\Domain\Foto\Service;

use App\Domain\Foto\Data\FotoListData;
use App\Domain\Foto\Repository\FotoReadRepository;
use Selective\Config\Configuration;

final class FotoReadService 
{
    private $repository;
    private $config;

    public function __construct(
        FotoReadRepository $repository, 
        Configuration $config
    ) {
        $this->repository = $repository;
        $this->config = $config;
    }

    public function readAll(): array 
    {
        $uploadsUrl = $this->config->getString('url.uploadsUrl');
        $rows = $this->repository->readAll();
        $listData = new FotoListData();
        return $listData->toRenderArray($uploadsUrl, $rows);
    }
}
