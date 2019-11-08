<?php

namespace App;

use App\Traits\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes, Userstamps;

    protected $fillable = ['stripe_invoice'];
}
