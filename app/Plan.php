<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $casts = [
        'is_primary' => 'boolean',
    ];
}
