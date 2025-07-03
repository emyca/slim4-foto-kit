<?php

namespace App\Domain\AdminAuth\Enum;

enum AdminAuthMsg: string
{
    case INPUT_LOGIN = "Enter login!";
    case INPUT_PASS = 'Enter password!';
    case NO_DATA_FOUND = 'No data have been found!';
    case ACCESS_NOT_ALLOWED = 'Access NOT allowed! Check login and password.';    
}
