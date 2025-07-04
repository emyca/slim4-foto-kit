<?php

namespace App\Domain\Foto\Data;

// Handle collection of items/objects
final class FotoListData 
{
    /** 
    * Collection of items/objects
    * @var array|null 
    */
    public ?array $items = [];

    /**
     * Supply items/objects array for render.
     * 
     * @param string $uploadsUrl Uploaded file(s) url
     * @param array $rows Associative array of DB data
     * 
     * @return array Associative array for render
    */
    public function toRenderArray($uploadsUrl, $rows): array
    {       
        foreach($rows as $row) {
            $this->items[] = [
                'id' => $row['id'],
                'image' => $uploadsUrl.$row['img'],
                'name' => $row['name'],
                'description' => $row['description'],
            ];
        }
        return $this->items;
    }    
}
