<?php

namespace App;

use App\Enums\TicketStatus;
use App\Traits\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    use SoftDeletes, Userstamps;

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->status = TicketStatus::CANCELED;
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

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
    public function isPending()
    {
        return $this->status === TicketStatus::PENDING;
    }

    /**
     * @return boolean
     */
    public function isCompleted()
    {
        return $this->status === TicketStatus::COMPLETED;
    }

    /**
     * @return boolean
     */
    public function isCanceled()
    {
        return $this->status === TicketStatus::CANCELED;
    }

    /**
     * @return boolean
     */
    public function isOpen()
    {
        return $this->status !== TicketStatus::PENDING;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\FancyNumber
     */
    public function fancy_number()
    {
        return $this->belongsTo(FancyNumber::class);
    }

    /**
     * Get related parent Ticket
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\App\Ticket
     */
    public function parent()
    {
        return $this->hasOne(Ticket::class, 'id', 'parent_id')->withTrashed();
    }

    /**
     * Get the assigned User
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\User
     */
    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_id');
    }

    /**
     * Get User that removed the Ticket
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\User
     */
    public function removed_by()
    {
        return $this->belongsTo(User::class, 'reason_by');
    }

    /**
     * @return boolean
     */
    public function belongsToAuthenticatedUser()
    {
        return $this->assigned_id === Auth::id();
    }
}
