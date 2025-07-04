<?php

namespace App\Domain\Foto\Exception;

class FotoException extends \RuntimeException
{
    /**
     * @param string $message The message for frontend.
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
