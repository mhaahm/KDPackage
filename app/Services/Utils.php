<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;

class Utils
{
    public function downloadFile($file,$dir)
    {
        $ch = curl_init($file);
        $dir = str_replace("//", DIRECTORY_SEPARATOR, $dir);
        $file_name = basename($file);
        $save_file_loc = $dir . $file_name;
        $fp = fopen($save_file_loc, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return (file_exists($dir.'/'.$file_name));
    }

    public function createPackageSocleTechniqueDir($platform)
    {
        Storage::disk('package')->makeDirectory('KD_Package_'.$platform,0777);
        $dir = ucfirst($platform).'_Socle_Technique';
        Storage::disk('package')->makeDirectory($dir,0777);
        return Storage::disk('package')->getConfig()['root'].DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;
    }

    public function getPackageDirs($platform)
    {
        $dir = ucfirst($platform).'_Socle_Technique';
        $root = Storage::disk('package')->getConfig()['root'];
        $socle = $root.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;
        $global = $root.DIRECTORY_SEPARATOR.'KD_Package_'.$platform.DIRECTORY_SEPARATOR;
        return [
            $socle,
            $global
        ];
    }
}
