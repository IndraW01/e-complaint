<?php

namespace App\Traits\Accessors;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait RoleNameTitle
{

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::title($value),
        );
    }
}
