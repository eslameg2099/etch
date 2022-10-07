<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imageable extends Model
{
    use HasFactory;
    protected $table    =   'images';
    protected $guarded  =   ['id'];
    protected $appends  =   ['image_url'];

    public function imageable() {
        $this->morphTo();
    }

    public function getImageUrlAttribute() {
        return asset("storage/$this->path");
    }
}
