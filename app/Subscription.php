<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscripion extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'trial_ends_at', 'ends_at',
        'created_at', 'updated_at',
    ];
}
