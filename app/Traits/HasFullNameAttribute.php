<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasFullNameAttribute
{
    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) =>
                    ($attributes['first_name'] ?? '')
                        . ' '
                        . ($attributes['last_name'] ?? '')
        );
    }


    protected function fullnameLastFirst(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) =>
                    ($attributes['last_name'] ?? '')
                        .', '
                        . ($attributes['first_name'] ?? '')
        );
    }
}
