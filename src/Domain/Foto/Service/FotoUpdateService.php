<?php

namespace App\Domain\Foto\Service;

use App\Domain\Foto\Data\FotoData;
use App\Domain\Foto\Enum\FotoMsg;
use App\Domain\Foto\Exception\FotoException;
use App\Domain\Foto\Repository\FotoUpdateRepository;
use App\Domain\Foto\Validation\FotoValidator;
use App\Utility\RandomStringGenerator;
use Selective\Config\Configuration;

final class FotoUpdateService 
{
    private $repository;
    private $validator;
    private $strGenerator;
    private $config;

    public function __construct(
        FotoUpdateRepository $repository,
        FotoValidator $validator,
        RandomStringGenerator $strGenerator,
        Configuration $config,
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->strGenerator = $strGenerator;
        $this->config = $config;
    }

    public function updateById(int $id, array $itemData): array
    {       
        $data = new FotoData($itemData);
       
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

        if ($this->validator->isFileChoosenForUpd($data)) {
            
            // Validates if uploaded file has right format (media type)
            try {
                $this->validator->isFileFormatOk($data);
            } catch(FotoException $e) {
                return (new FotoData(array(400, 0, $e->getMessage()))
                )->jsonSerialize();
            } 

            // Gets old file name from DB by item id.
            $oldFileName = $this->repository
                ->getOldFileNameByItemId($id);
            // Deletes the old file from uploads dir.
            if ($oldFileName !== null) {
                $uploadsSubUrl = $this->config->getString('url.uploadsSubUrl');
                $pathToFile = $uploadsSubUrl.$oldFileName;
                if (file_exists($pathToFile)) unlink($pathToFile);
            }

            // Validates if new file uploaded
            try {
                $this->validator->isFileUploaded($data);
            } catch (FotoException $e) {
                return (new FotoData(array(400, 0, $e->getMessage()))
                )->jsonSerialize();
            }

            // Renames uploaded file name adding random string to its name 
            $fileNameWithRandomStr = 
                $this->getNewFileNameWithRandomStr($data);

            // Moves uploaded file with new name to uploads dir 
            $newFile = $data->file;
            $directory = $this->config->getString('url.uploadsDir');
            $newFile->moveTo($directory. DIRECTORY_SEPARATOR .$fileNameWithRandomStr);

            //Adds item id to item data
            $itemData['id'] = $id;
            // Adds generated file name with random string to item data
            $itemData['params']['newFileName'] = $fileNameWithRandomStr;
            // Creates new item data object
            $newData = new FotoData($itemData);
            // Updates item in DB with file added
            try {
                $this->repository->updateById($newData->toDbArray());
                return (
                    new FotoData(
                        array(200, 1, FotoMsg::UPDATED->value)
                    )
                )->jsonSerialize(); 
            } catch (FotoException | \PDOException $e) {
                return (
                    new FotoData(array(500, 0, $e->getMessage()))
                )->jsonSerialize();
            }
        } else {
            // Adds item id to item data
            $itemData['id'] = $id;
            // Creates new item data object
            $newData = new FotoData($itemData);
            // Updates item in DB with no file added
            try {
                $this->repository->updateById($newData->toDbArray());
                return (
                    new FotoData(
                        array(200, 1, FotoMsg::UPDATED->value)
                    )
                )->jsonSerialize(); 
            } catch (FotoException | \PDOException $e) {
                return 
                    (new FotoData(
                        array(500, 0, $e->getMessage()))
                    )->jsonSerialize();
            }
        }  
    }

    /**
     * Adds random string to uploaded file name.
     * 
     * @param FotoData $data Item data from request
     * 
     * @return string New file name with random string
     */
    private function getNewFileNameWithRandomStr(FotoData $data) : string
    {
        $newFile = $data->file;
        $newFileName = $newFile->getClientFilename();
        $randomStr = $this->strGenerator->genRandomString(6);
        return $randomStr . "_" . $newFileName;
    }
}
