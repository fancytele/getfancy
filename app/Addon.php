<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    public function scopeGetWithLocal($query, $args)
    {
        return $query->get($args)->each(function ($item) {
            $item->name = __($item->name);
            $item->description = __($item->description);
        });
    }
}
