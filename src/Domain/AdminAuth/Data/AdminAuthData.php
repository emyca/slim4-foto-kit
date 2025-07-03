<?php

namespace App\Domain\AdminAuth\Data;

final class AdminAuthData implements \JsonSerializable 
{
    /**
    * @var string
    */
    private $adminLogin;
    /**
    * @var string
    */
    private $adminPass;
    /**
    * HTTP status code.
    * @var int
    */
    private $status;
    /**
    * Indicates (e.g. for frontend) if work 
    * on the resource was successful.
    * @var int 0(false), 1(true)
    */
    private $success;
    /**
    * Custom message or redirect url.
    * @var string
    */
    private $message;

    public function __construct(
        ?array $adminAuthData = []
    ) {
        $this->adminLogin = $adminAuthData['adminLogin'] ?? null;
        $this->adminPass = $adminAuthData['adminPass'] ?? null;
        $this->status = $adminAuthData[0] ?? null;
        $this->success = $adminAuthData[1] ?? null;
        $this->message = $adminAuthData[2] ?? null;
    }

    /**
     * Get the value of adminLogin
     */
    public function getAdminLogin()
    {
        return $this->adminLogin;
    }

    /**
     * Get the value of adminPass
     */
    public function getAdminPass()
    {
        return $this->adminPass;
    }

    /**
     * Defines how json_encode() should serialize the object
     * @return array in the format expected by the frontend
     */
    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'success' => boolval($this->success),
            'message' => $this->message
        ];
    }
}
