<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Illuminate\Support\Str;

class PhoneNumberMiddleware extends TransformsRequest
{
    /**
     * The attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * Transform the given value.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if ($key != 'mobile') {
            return $value;
        }
        $newValue = $value;
        if (Str::startsWith($value,'0')){
            // remove 0
            $newValue = substr($value, 1);
        }

        if (Str::length($value) != 9) {
            if (Str::startsWith($value,'0')){
                // remove 0
                $newValue = substr($value, 1);
            }
            if (Str::length($value) == 12 && Str::startsWith($value,'966')){
                // remove 966
                $newValue = substr($value, 3);
            }
            if (Str::length($value) == 13 && Str::startsWith($value,'966')){
                // remove 966
                $newValue = substr($value, 4);
            }
        }
        return $newValue;
    }
}
