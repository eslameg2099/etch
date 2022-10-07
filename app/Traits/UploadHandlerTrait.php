<?php


namespace App\Traits;


use Illuminate\Support\Str;

trait UploadHandlerTrait
{
    public function uploadImage($image_key,$path) {
        $newPath = null;
        if(request()->hasFile($image_key)) {

            $image = request()->file($image_key);
            $newPath  = $image->storeAs($path, Str::uuid().'.'.$image->getClientOriginalExtension(), 'public');
        }
        return $newPath;
    }
}
