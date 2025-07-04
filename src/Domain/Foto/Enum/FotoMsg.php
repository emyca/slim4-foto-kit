<?php

namespace App\Domain\Foto\Enum;

enum FotoMsg: string
{
    case ADD_FILE = 'Add file!';
    case WRONG_FORMAT_FILE = 'Wrong file format!';
    case ADD_NAME = 'Add name!';
    case ADD_DESCRIPTION = 'Add description!';
    case FILE_UNUPLOADED = 'File is unuploaded!';
    case ADDED = 'Added.';
    case UPDATED = 'Updated.';
    case DELETED = 'Deleted.';
    case DB_ERROR = 'DB ERROR!';
    case FILE_NOT_EXISTS = 'File does NOT exist!';
}
