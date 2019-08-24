<?php

namespace App;

use App\Enums\AddonType;
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

    /**
     * Scope a query to only include subscriptions type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubscription($query)
    {
        return $query->whereType(AddonType::Subscription);
    }
}
