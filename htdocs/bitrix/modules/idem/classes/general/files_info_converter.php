<?php

namespace Idem;

class CIdemFileInfo
{
    public static function convert($data,$n = null)
    {
        $info = [];
        foreach ($data as $key => $value){
            if(isset($value['tmp_name']) && is_array($value['tmp_name'])) {
                $res = self::convert($value['tmp_name'], $value['name']);
                $info[$key] = $res;
            }elseif(isset($value['tmp_name']) && !is_array($value['tmp_name'])){
                $info[$key] = self::putFile($value['tmp_name'],$value['name']);
            }elseif(!isset($value['name']) && is_array($value)){
                $info[$key] = self::convert($value,$n[$key]);
            }else{
                if($data){
                    $info[$key] = self::putFile($value,$n[$key]);
                }else{
                    $info[$key] = null;
                }
            }
        }

        return $info;
    }

    public static function putFile($path,$name)
    {
        $filePath = $_SERVER['DOCUMENT_ROOT'].'/upload/static_content/';
        if(!is_dir($filePath)){
            mkdir($filePath);
        }

        if(move_uploaded_file($path,$filePath.$name)){
            return '/upload/static_content/'.$name;
        }else{
            return null;
        }
    }
}