<?php

namespace App\Sevices;
use CURLFile;

class MediaUploader
{
    private const CLIENT_ID = "a3c7f8605115b04";
    private const API_URL_IMAGE = "https://api.imgur.com/3/image";
    private const API_URL_VIDEO = "https://api.imgur.com/3/upload";
    /**
     * @param $tmp_name
     * @param $type
     * @return false|mixed
     */
    public static function uploadMedia($tmp_name,$type): mixed
    {
        // check if file is a real image and is under the size limit
//        getimagesize($file_info["tmp_name"]) && $file_info['size'] < self::MAX_SIZE_LIMIT
            $media_source = file_get_contents($tmp_name);
            $postFields = array('image' => base64_encode($media_source));
            $url ='';
            if ($type == 'image') {
                $url = self::API_URL_IMAGE;
            } elseif ($type == 'video') {
                $url = self::API_URL_VIDEO;
            }
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL=> $url,
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
                return $imgurData->data->link;
            }
        return false;
    }
}
