<?php

namespace App\Extensions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

trait HashedPassword
{
    public static function bootHashedPassword()
    {
        static::saving(function (Model $model) {
            $model->password = Hash::make($model->password);
        });
    }
}
