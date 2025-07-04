<?php

namespace App\Domain\Foto\Service;

use App\Domain\Foto\Data\FotoData;
use App\Domain\Foto\Enum\FotoMsg;
use App\Domain\Foto\Exception\FotoException;
use App\Domain\Foto\Repository\FotoCreateRepository;
use App\Domain\Foto\Validation\FotoValidator;
use App\Utility\RandomStringGenerator;
use PDOException;
use Selective\Config\Configuration;

final class FotoCreateService 
{
    private $repository;
    private $validator;
    private $strGenerator;
    private $config;

    public function __construct(
        FotoCreateRepository $repository,
        FotoValidator $validator,
        RandomStringGenerator $strGenerator,
        Configuration $config,
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->strGenerator = $strGenerator;
        $this->config = $config;
    }

    public function create(array $itemData): array 
    {
        $data = new FotoData($itemData);
        
        // Checks if file is choosen
        try {
            $this->validator->isFileChoosen($data);
        } catch(FotoException $e) {
            return (
                new FotoData(array(400, 0, $e->getMessage()))
            )->jsonSerialize();
        }

        // Validates uploaded file media type
        try {
            $this->validator->isFileFormatOk($data);
        } catch(FotoException $e) {
            return (
                new FotoData(array(400, 0, $e->getMessage()))
            )->jsonSerialize();
        }

        // Validates name
        try {
            $this->validator->isNameValid($data);
        } catch(FotoException $e) {
            return (
                new FotoData(array(400, 0, $e->getMessage()))
            )->jsonSerialize();
        }

        // Validates desription
        try {
            $this->validator->isDescriptionValid($data);
        } catch(FotoException $e) {
            return (
                new FotoData(array(400, 0, $e->getMessage()))
            )->jsonSerialize();
        }

        try {
            $this->validator->isFileUploaded($data);

            $file = $data->file;
            $directory = $this->config->getString('url.uploadsDir');
            $fileName = $file->getClientFilename();
            $randomStr = $this->strGenerator->genRandomString(6);
            $fileNameWithRandomStr = $randomStr . "_" . $fileName;
            $file->moveTo($directory. DIRECTORY_SEPARATOR .$fileNameWithRandomStr);

            // Adds generated file name with random string to item data
            $itemData['params']['newFileName'] = $fileNameWithRandomStr;

            // Adds new item data to DB
            $data = new FotoData($itemData);
            try {
                $this->repository->create($data->toDbArray());
                return (
                    new FotoData(
                        array(200, 1, FotoMsg::ADDED->value)
                    )
                )->jsonSerialize(); 
            } catch (FotoException | \PDOException $e) {
                return (
                    new FotoData(array(500, 0, $e->getMessage()))
                )->jsonSerialize();
            }
        } catch (FotoException $e) {
            return (
                new FotoData(array(400, 0, $e->getMessage()))
            )->jsonSerialize();
        }
    }
}
