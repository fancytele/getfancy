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
     * @return boolean
     */
    public function inProgress()
    {
        return $this->status === TicketStatus::IN_PROGRESS;
    }

    /**
     * @return boolean
     */
    public function fancyNumber()
    {
        return $this->belongsTo(FancyNumber::class);
    }

    public function parent()
    {
        return $this->hasOne(Ticket::class, 'id', 'parent_id')->withTrashed();
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_id');
    }
}
