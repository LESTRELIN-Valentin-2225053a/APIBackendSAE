<?php

namespace App\Sevices;
class ImageUploader
{
    private const CLIENT_ID = "a3c7f8605115b04";
    private const API_URL = "https://api.imgur.com/3/image";
    private const MAX_SIZE_LIMIT = 99999999;

    /**
     * @param $tmp_name
     * @param $size
     * @return false|mixed
     */
    public static function uploadPicture($tmp_name,$size): mixed
    {
        // check if file is a real image and is under the size limit
//        getimagesize($file_info["tmp_name"]) && $file_info['size'] < self::MAX_SIZE_LIMIT
        if ($size <= self::MAX_SIZE_LIMIT){
            $image_source = file_get_contents($tmp_name);
            $postFields = array('image' => base64_encode($image_source));
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL=> self::API_URL,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_POST => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_HTTPHEADER => array('Authorization: Client-ID ' . self::CLIENT_ID),
                CURLOPT_POSTFIELDS => $postFields
            ));
            $response = curl_exec($ch);
            curl_close($ch);
            $imgurData = json_decode($response);
            // check if an imgur link was created
            if(!empty($imgurData->data->link)){
                return $imgurData;
            }
        }
        return false;
    }
}
