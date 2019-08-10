<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function scopeGetWithLocal($query, $args)
    {
        return $query->get($args)->each(function ($item) {
            $item->name = __($item->name);
        });
    }
}
