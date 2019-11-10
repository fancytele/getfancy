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
        'extensions' => 'array',
    ];

    private static $default_days_data = [
        [
            'id' => 'monday',
            'text' => 'Mon',
            'start' => null,
            'end' => null,
            'enable' => false
        ],
        [
            'id' => 'tuesday',
            'text' => 'Tue',
            'start' => null,
            'end' => null,
            'enable' => false
        ],
        [
            'id' => 'wednesday',
            'text' => 'Wed',
            'start' => null,
            'end' => null,
            'enable' => false
        ],
        [
            'id' => 'thursday',
            'text' => 'Thu',
            'start' => null,
            'end' => null,
            'enable' => false
        ],
        [
            'id' => 'friday',
            'text' => 'Fri',
            'start' => null,
            'end' => null,
            'enable' => false
        ],
        [
            'id' => 'saturday',
            'text' => 'Sat',
            'start' => null,
            'end' => null,
            'enable' => false
        ],
        [
            'id' => 'sunday',
            'text' => 'Sun',
            'start' => null,
            'end' => null,
            'enable' => false
        ]
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the Fancy Number that owns the Fancy Setting.
     */
    public function fancy_number()
    {
        return $this->belongsTo(FancyNumber::class);
    }

    public static function defaultBusinessHours()
    {
        return [
            'allDay' => false,
            'days' => self::$default_days_data
        ];
    }

    public static function defaultDowntimeHours()
    {
        return [
            'enable' => false,
            'days' => self::$default_days_data
        ];
    }

}
