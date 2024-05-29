<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\Base64ImageDecoder;

trait ManageFile
{
    public function storeBase64File(String $file,String $directory){
        //check validation
        if (!preg_match('/^data:image\/\w+;base64,/', $file)){
            throw new \Exception('Base64 is not valid');
        }
            $pos = strpos($file, ';');
            $sub = substr($file, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = Auth::user()->id . time(). "." . $ext[1];
            $base_64 = explode(',', $file);
            //verify the file data
            if(!base64_decode($base_64[1])){
                throw new \Exception('Base64 is not verified');
            }
            $manager = new ImageManager(new Driver());
            $image = $manager->read($base_64[1],Base64ImageDecoder::class);
            $image = $image->resize(300, 300);
            $path = '/backend/'.$directory.'/'.$fileName;
            $image->save('backend/'.$directory.'/'.$fileName);
            
            return $path;
    }

}
