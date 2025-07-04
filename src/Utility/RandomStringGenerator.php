<?php

namespace App\Utility;

final class RandomStringGenerator
{
    /**
     * Generate random string. 
     * Can be used as prefix for uploaded file name to make it unique.
     *
     * @param int $length Random string length
     *
     * @return string Random string
     */
    public function genRandomString($length): string {
        $str = '';
        $strs = array_merge(range(0, 9), range('a', 'z'));
        for ($i = 0; $i < $length; $i++) {
            $str .= $strs[array_rand($strs)];
        }    
        return $str;
    }
}
