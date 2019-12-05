<?php

namespace App;

use App\Enums\TicketStatus;
use App\Traits\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FancyNumber extends Model
{
    use Userstamps, SoftDeletes;

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
     * Accesor to get DID number with US format
     */
    public function getUsDIDNumberAttribute()
    {
        return preg_replace('/(\d{1})(\d{3})(\d{3})(\d{4})/', '$1($2) $3-$4', $this->did_number);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function settings()
    {
        return $this->hasMany(FancySetting::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * @return boolean
     */
    public function hasOpenTicket()
    {
        $count = $this->tickets->whereIn('status', [TicketStatus::PENDING, TicketStatus::IN_PROGRESS])->count();

        return $this->tickets->isNotEmpty() && $count > 0;
    }

    /**
     * @return boolean
     */
    public function hasTicketInProgress()
    {
        return $this->tickets->isNotEmpty() && $this->tickets->where('status', TicketStatus::IN_PROGRESS)->count() > 0;
    }
}
