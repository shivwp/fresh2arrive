<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use File;

class Helper
{
    public static function generateReferCode()
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
        return strtoupper(substr(str_shuffle($str_result),0, 10));
    }

    public static function storeImage($image, $destinationPath, $old_image = null)
    {
        try {
            if(!empty($old_image)) {
                if(File::exists($destinationPath.'/'.$old_image)) {
                    unlink($destinationPath.'/'.$old_image);
                }
            }
            $file = $image;
            $name =time().'-'.$file->getClientOriginalName();
            $file->move($destinationPath, $name);
            return $name;
        } catch (\Exception $e) {
            return 0;
        }
    }

    // public static function removeImage($destinationPath, $old_image = null)
    // {
    //     try {
    //         if(!empty($old_image)) {
    //             if(File::exists($destinationPath.'/'.$old_image)) {
    //                 unlink($destinationPath.'/'.$old_image);
    //             }
    //         }
    //         return 'Image Removed';
    //     } catch (\Exception $e) {
    //         return 0;
    //     }
    // }

    public static function generateOtp()
    {
        return rand(1111,9999);
    }

    public static function Messages() {
        $jsonString = file_get_contents(storage_path('json/message.json'));
        $data = json_decode($jsonString, true);
        return $data;
    }

    public static function Units() {
        return $units = [
            'kg' => 'kg',
            'grm' => 'grm',
            'ltr' => 'ltr',
            'ml' => 'ml',
            'dozen' => 'dozen'
        ];
    }

    public static function DeliveryRange() {
        return $range = [
            '5' => '5 km',
            '10' => '10 km',
            '15' => '15 km',
            '20' => '20 km',
            '25' => '25 km',
            '30' => '30 km',
            '35' => '35 km',
            '40' => '40 km',
            '45' => '45 km',
            '50' => '50 km',
        ];
    }
}
