<?php

namespace App\Domain\Foto\Data;

// Handle single item
final class FotoData implements \JsonSerializable 
{
    /**
    * @var int
    */
    public $id;
    /**
    * @var mixed
    */
    public $file;
    /**
    * @var string
    */
    public $name;
    /**
    * @var string
    */
    public $description;
    /**
    * @var string
    */
    public $fileNameWithRandomStr;
    /**
    * HTTP status code.
    * @var int
    */
    public $status;
    /**
    * Indicates (e.g. for frontend) if work 
    * on the resource was successful.
    * @var int 0(false), 1(true)
    */
    public $success;
    /**
    * Custom message.
    * @var string
    */
    public $message;

    public function __construct(
        ?array $itemData = []
    ) {
        $this->id = $itemData['id'] ?? null;
        $this->file = $itemData['file']['file'] ?? null;
        $this->name = $itemData['params']['name'] ?? null;
        $this->description = $itemData['params']['description'] ?? null;
        $this->fileNameWithRandomStr = $itemData['params']['newFileName'] ?? null;
        $this->status = $itemData[0] ?? null;
        $this->success = $itemData[1] ?? null;
        $this->message = $itemData[2] ?? null;
    }

    /**
     * Serialize DTO to array for database.
     * @param string $fileNameWithRandomStr uploaded file name 
     * concatenated with random generated string and delimiter 
     * to make file name unique. 
     * @return array keys must be identical with the database 
     * table column names.
     */
    public function toDbArray(): array
    {
        $dbArray = [];

        // Adds to the array according to the conditions. 
        // Update, Delete could need id.
        if ($this->id !== null)
            $dbArray['id'] = $this->id;

        // Adds to the array according to the conditions. 
        // Update sometimes does not need to change file.
        // Delete does not need these data at all.
        if ($this->fileNameWithRandomStr !== null)
            $dbArray['img'] = $this->fileNameWithRandomStr;

        // Adds to the array according to the conditions.
        // Delete does not need these data at all.
        if ($this->name !== null) 
            $dbArray['name'] = $this->name;

        // Adds to the array according to the conditions.
        // Delete does not need these data at all.        
        if ($this->description !== null) 
            $dbArray['description'] = $this->description;

        return $dbArray;
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
