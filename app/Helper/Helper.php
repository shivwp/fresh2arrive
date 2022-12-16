<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class Helper
{
    public static function generateReferCode()
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
        return strtoupper(substr(str_shuffle($str_result),0, 10));
    }

    public static function storeImage($image, $destinationPath)
    {
        try {
            $file = $image;
            $name =time().'-'.$file->getClientOriginalName();
            $file->move($destinationPath, $name);
            return $name;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function generateOtp()
    {
        return rand(1111,9999);
    }

    public static function Messages() {
        $jsonString = file_get_contents(storage_path('json/message.json'));
        $data = json_decode($jsonString, true);
        return $data;
    }
}
