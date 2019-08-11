<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Scope to get all Products with Localization
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param array $args
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeGetWithLocal($query, $args)
    {
        return $query->get($args)->each(function ($item) {
            $item->name = __($item->name);
        });
    }
}
