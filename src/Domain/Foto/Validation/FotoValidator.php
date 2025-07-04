<?php

namespace App\Domain\Foto\Validation;

use App\Domain\Foto\Data\FotoData;
use App\Domain\Foto\Enum\FotoMsg;
use App\Domain\Foto\Exception\FotoException;

// Validates item data for item manipulation
final class FotoValidator {

    public function isFileChoosen(FotoData $data)
    {
        $file = $data->file;
        if ($file === null || empty($file))
        throw new FotoException(
            FotoMsg::ADD_FILE->value
        );
    }

    public function isFileChoosenForUpd(FotoData $data)
    {
        $file = $data->file;
        return $file !== null || !empty($file);
    }

    // Validates uploaded file media type
    public function isFileFormatOk(FotoData $data) 
    {
        if (!in_array(
                $data->file->getClientMediaType(), 
                // Allows certain files media type (JPG, PNG)
                ['image/png', 'image/jpeg']
            )
        ) 
        throw new FotoException(
            FotoMsg::WRONG_FORMAT_FILE->value
        );
    }

    public function isNameValid(FotoData $data)
    {
        $name = trim((string)$data->name);
        // Checks if name is null or empty        
        if ($name == null || empty($name) || $name == "") 
        throw new FotoException(
            FotoMsg::ADD_NAME->value
        );
    }

    public function isDescriptionValid(FotoData $data)
    {
        $description = trim((string)$data->description);
        // Checks if desription is null or empty        
        if ($description == null || empty($description) || $description == "") 
        throw new FotoException(
            FotoMsg::ADD_DESCRIPTION->value
        );
    }

    public function isFileUploaded(FotoData $data) 
    {
        $file = $data->file;
        if ($file->getError() !== UPLOAD_ERR_OK)
        throw new FotoException(
            FotoMsg::FILE_UNUPLOADED->value
        );
    }
}
