<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FancySetting extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'business_hours' => 'array',
        'downtime_hours' => 'array',
        'languages' => 'array',
        'extensions' => 'array',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return string
     */
    public function getPeriodNotificationLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->period_notification));
    }

    /**
     * @return string
     */
    public function getAudioLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->audio_type));
    }

    public function getAudioDownloadUrlAttribute()
    {
        return \Storage::disk('s3')->url($this->audio_url);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\FancyNumber
     */
    public function fancy_number()
    {
        return $this->belongsTo(FancyNumber::class);
    }

    /**
     * Get the selected PBX Bussiness message
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\PBXMessage
     */
    public function pbx_business()
    {
        return $this->belongsTo(PBXMessage::class, 'business_message_id');
    }

    /**
     * Get the selected PBX Downtime message
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\PBXMessage
     */
    public function pbx_downtime()
    {
        return $this->belongsTo(PBXMessage::class, 'downtime_message_id');
    }

    /**
     * Get the selected PBX On-hold message
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\PBXMessage
     */
    public function pbx_onhold()
    {
        return $this->belongsTo(PBXMessage::class, 'onhold_message_id');
    }

    /**
     * @return boolean
     */
    public function hasPBX()
    {
        $has_business = $this->business_message_id || $this->business_custom_message;
        $has_downtime = $this->downtime_message_id || $this->downtime_custom_message;
        $has_onhold = $this->onhold_message_id || $this->onhold_custom_message;

        return $has_business || $has_downtime || $has_onhold;
    }
}
