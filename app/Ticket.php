<?php

namespace App;

use App\Enums\TicketStatus;
use App\Traits\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes, Userstamps;

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->status = TicketStatus::REMOVED;
            $model->save();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'status',
    ];

    /**
     * Return if Ticket is In Progress
     *
     * @return bool
     */
    public function inProgress()
    {
        return $this->status === TicketStatus::IN_PROGRESS;
    }
}
