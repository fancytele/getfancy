<?php

namespace App\Traits;

use App\Observers\ModelObserver;

trait Userstamps
{
    public static function bootUserstamps()
    {
        static::observe(ModelObserver::class);
    }
}
