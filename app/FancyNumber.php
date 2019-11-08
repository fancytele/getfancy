<?php

namespace App;

use App\Enums\TicketStatus;
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

    /**
     * Get the Ticket for the Fancy Number
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function hasPendingTicket()
    {
        return $this->tickets->isNotEmpty() && $this->tickets->where('status', TicketStatus::PENDING)->count() > 0;
    }

    public function hasTicketInProgress()
    {
        return $this->tickets->isNotEmpty() && $this->tickets->where('status', TicketStatus::IN_PROGRESS)->count() > 0;
    }
}
