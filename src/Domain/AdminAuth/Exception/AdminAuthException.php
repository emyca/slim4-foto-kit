<?php

namespace App\Domain\AdminAuth\Exception;

class AdminAuthException extends \RuntimeException
{
    /**
     * @param string $message Exception message.
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
