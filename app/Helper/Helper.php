<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function generateReferCode()
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
        return strtoupper(substr(str_shuffle($str_result),0, 10));
    }

    public static function storeImage($image, $destinationPath)
    {
        $file = $image;
        $name =time().'-'.$file->getClientOriginalName();
        $temp = $file->move($destinationPath, $name);
        return $name;
    }
}
