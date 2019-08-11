<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    /**
     * Scope to get all Addons with Localization
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param array $args
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeGetWithLocal($query, $args)
    {
        return $query->get($args)->each(function ($item) {
            $item->name = __($item->name);
            $item->description = __($item->description);
        });
    }
}
