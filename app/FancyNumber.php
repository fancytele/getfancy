<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FancyNumber extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'did_id',
        'did_purchase_id',
        'did_number',
        'did_reference',
        'did_status'
    ];

    /**
     * Get the settings for the Fancy number.
     */
    public function settings()
    {
        return $this->hasMany(FancySetting::class);
    }
}
