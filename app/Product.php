<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductRenews;

class Product extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['renew'];

    /**
     * Get the renews text base on the Product name
     *
     * @return bool
     */
    public function getRenewAttribute()
    {
        return $this->attributes['renew'] = ProductRenews::getValue($this->name);
    }
}
