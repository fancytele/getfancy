<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FancySetting extends Model
{
    public function fancy_number()
    {
        return $this->belongsTo(FancyNumber::class);
    }
}
